<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserType;
use App\Models\UserTypeLocation;
use App\Models\Location;

class UserTypeLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTypes = UserType::all();
        return view('pages.configurations.userTypeLocations.index', compact('userTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserTypeLocation $userTypeLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $userType = UserType::findOrFail($id);
        $locations = Location::all();
        $listOfLocations = [];
        foreach ($locations as $loc) {
            $chain = Location::getParentLocation(locationId: $loc->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $listOfLocations[$loc->id] = implode(' / ', array_merge($names, [$loc->location_name]));
        }
        // dd($listOfLocations);   
        return view('pages.configurations.userTypeLocations.form', compact('userType', 'listOfLocations'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // dd($id);
        UserTypeLocation::updateOrCreate(
            ['user_type_id' => $id],
            [
                'locations_list' => implode(',', $request->location),
            ]
        );

        return redirect()->route('userTypeLocations.index')->with('success', 'User Type Locations updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserTypeLocation $userTypeLocation)
    {
        //
    }
}
