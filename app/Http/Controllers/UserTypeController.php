<?php

namespace App\Http\Controllers;
use App\Models\UserType;
use App\Models\Location;
use App\Models\UserTypeLocation;
use Illuminate\Http\Request;
use App\Models\Gateway;
use App\Services\SensorOfflineService;
use DB;
use Response;
use Illuminate\Validation\Rule;

class UserTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userTypes = UserType::all();
        $locations = Location::all();
        $listOfLocations = [];
        foreach ($locations as $loc) {
            $chain = Location::getParentLocation(locationId: $loc->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $listOfLocations[$loc->id] = implode(' / ', array_merge($names, [$loc->location_name]));
        }

        return view('pages.configurations.userTypes.index', compact('userTypes', 'listOfLocations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::all();
        $listOfLocations = [];
        foreach ($locations as $loc) {
            $chain = Location::getParentLocation(locationId: $loc->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $listOfLocations[$loc->id] = implode(' / ', array_merge($names, [$loc->location_name]));
        }
        return view('pages.configurations.userTypes.form', compact('listOfLocations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());
        DB::enableQueryLog();
        $userType = new UserType($request->all());
        $userType->save();
        // $usrTypeLocations = $request->input('location', []);      
        $userTypeLocation = new UserTypeLocation();
        $userTypeLocation->user_type_id = $userType->id;
        $userTypeLocation->locations_list = implode(',', $request->location);
        $userTypeLocation->save();

        return redirect()->route('userTypes.index')->with('success', 'User Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserType $userType)
    {
        $userType = UserType::find($userType->id);
        $locations = Location::all();
        $listOfLocations = [];
        foreach ($locations as $loc) {
            $chain = Location::getParentLocation(locationId: $loc->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $listOfLocations[$loc->id] = implode(' / ', array_merge($names, [$loc->location_name]));
        }
        return view('pages.configurations.userTypes.form', compact('listOfLocations', 'userType', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserType $userType)
    {
        $request->validate(self::formRule($userType->id), self::errorMessage(), self::changeAttributes());
        $userType->update($request->all());

        $userTypeLocation = UserTypeLocation::where('user_type_id', $userType->id)->first();
        if (!$userTypeLocation) {
            $userTypeLocation = new UserTypeLocation();
            $userTypeLocation->user_type_id = $userType->id;
        }
        $userTypeLocation->locations_list = implode(',', $request->location);
        $userTypeLocation->save();

        return redirect()->route('userTypes.index')->with('success', 'User Type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::enableQueryLog();
        $id = $request->id;

        $locations = UserTypeLocation::where('user_type_id', $id)->first();      
        $locations->delete();    
        
        $userType = $userType = UserType::findOrFail($id);
        $userType->save();
        $userType->delete();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->delete(DB::getQueryLog(), $gateway->id);
        }

        return Response::json(['success' => true, 'message' => 'User Type deleted successfully.']);
    }

    public function formRule($id = false): array
    {
        return [
            'name' => ['required', 'max:255', Rule::unique('user_types')->ignore($id, 'id')],
        ];
    }

    public function errorMessage(): array
    {
        return [
            'name.required' => 'The User Type Name field is required.',
            'name.unique' => 'The User Type Name has already been taken.',
        ];
    }

    public function changeAttributes(): array
    {
        return [
            'name' => 'User Type Name',
        ];
    }
}
