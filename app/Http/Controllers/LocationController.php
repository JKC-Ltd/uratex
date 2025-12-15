<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Location;
use App\Services\SensorOfflineService;
use DB;
use Illuminate\Http\Request;
use Response;
use Illuminate\Validation\Rule;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $locations = Location::all();
        $parentPaths = [];
        foreach ($locations as $loc) {
            $chain = Location::getParentLocation($loc->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $parentPaths[$loc->id] = implode(' / ', $names);
        }

        return view('pages.configurations.locations.index')
            ->with('locations', $locations)
            ->with('listOfLocationsParents', $parentPaths);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $listOfLocations = Location::all();
        $listOfLocationsParents = self::getLocationParent();
        return view('pages.configurations.locations.form')
            ->with('listOfLocations', $listOfLocations)
            ->with('listOfLocationsParents', $listOfLocationsParents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $location = new Location($request->all());
        $location->save();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id, 'location_code');
        }


        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */  
    public function edit(string $id)
    {
        // $location = Location::findOrFail($id);
        // $listOfLocationsParents = self::getLocationParent();
        // return view('pages.configurations.locations.form', compact('location'));

        $listOfLocations = Location::findOrFail($id);
        $listOfLocationsParents = self::getLocationParent();
        return view('pages.configurations.locations.form')
            ->with('location', $listOfLocations)
            ->with('listOfLocationsParents', $listOfLocationsParents);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        $request->validate(self::formRule($location->id), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $location->update($request->all());

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->update(DB::getQueryLog(), $gateway->id);
        }

        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::enableQueryLog();

        $id = $request->id;
        $location = $location = Location::findOrFail($id);
        $location->save();
        $location->delete();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->delete(DB::getQueryLog(), $gateway->id);
        }

        return Response::json($location);
    }
    public function formRule($id = false)
    {
        return [
            // 'location_code' => ['required', 'string', 'min:2', 'max:200', Rule::unique('locations')->ignore($id ? $id : "")],
            'location_code' => ['required', 'string', 'min:2', 'max:200'],
            'location_name' => ['required', 'string', 'min:2', 'max:200']
        ];
    }
    public function errorMessage()
    {
        return [
            'location_code.required' => 'Location code is required',
            // 'location_code.unique' => 'Location code already exists',
            'location_name.required' => 'Location name is required'
        ];
    }
    public function changeAttributes()
    {
        return [
            'location_code' => 'Location Code',
            'location_name' => 'Location Name'
        ];
    }

    // public function getLocationChart()
    // {
    //     $locations = Location::select('id', 'pid', 'location_name as name')
    //         ->get()
    //         ->map(function ($location) {
    //             $location->tags = ["Location"];
    //             return $location;
    //         });

    //     return Response::json($locations);
    // }

    public function getLocationChart()
    {
        // Locations to tag as "Building"
        $buildingNames = ['EMS','Building 1', 'Building 2', 'Building 3'];
    
        // Locations to exclude by name
        $excludedNames = ['SEP', 'injection', 'CIP2', 'Building 4'];
    
        // Locations to exclude by ID (6, 7, 8 excluded because they come from sensor chart as buildings)
        $excludedIds = [2,6, 7, 8, 9, 10, 15, 16, 19, 18, 20, 25, 26];
    
        $locations = Location::select('id', 'pid', 'location_name as name')
            ->whereNotIn('location_name', $excludedNames)
            ->whereNotIn('id', $excludedIds)
            ->get()
            ->map(function ($location) use ($buildingNames) {
                $location->tags = in_array($location->name, $buildingNames)
                    ? ["Building"]
                    : ["Location"];
                return $location;
            });
    
        return Response::json($locations);
    }

    public function getLocationParent()
    {
        $allLocations = Location::all();

        $listOfLocationsParents = $allLocations->map(function ($loc) {
            $parentChain = Location::getParentLocation($loc->id);

            $parentNames = array_map(function ($parent) {
                return $parent->location_name;
            }, $parentChain);

            $fullPath = implode(' / ', array_merge($parentNames, [$loc->location_name]));

            return [
                'fullPath' => $fullPath,
                'location' => $loc,
            ];
        });

        return $listOfLocationsParents->sortBy('fullPath')->values()->all();
    }
}
