<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use App\Models\Location;
use App\Models\Gateway;
use App\Models\SensorType;
use App\Models\SensorModel;
use App\Services\EnergyConsumptionService;
use App\Services\SensorOfflineService;
use DB;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use Response;


class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensor = Sensor::all();
        $listOfLocationsParents = self::getLocationParent();
        return view('pages.configurations.sensors.index')
            ->with('sensors', $sensor)
            ->with('listOfLocationsParents', $listOfLocationsParents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $location = Location::all();
        $gateway = Gateway::all();
        $sensorModels = SensorModel::all();

        return view('pages.configurations.sensors.form')
            ->with('locations', $location)
            ->with('gateways', $gateway)
            ->with('sensorModels', $sensorModels);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $sensor = new Sensor($request->all());
        $sensor->save();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id);
            // (new SensorOfflineService())->store(DB::getQueryLog(), $request->gateway_id);
        }

        return redirect()->route('sensors.index');

    }

    /**
     * Display the specified resource.

     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sensor = Sensor::find($id);
        $location = Location::all();
        $gateway = Gateway::all();
        $sensorModels = SensorModel::all();
         $listOfLocationsParents = self::getLocationParent();
        $parentPaths = [];
        foreach ($location as $parentlocation) {
            $chain = Location::getParentLocation($parentlocation->id);
            $names = array_map(fn($p) => $p->location_name, $chain);
            $parentPaths[$parentlocation->id] = implode(' / ', $names);
        }

        return view('pages.configurations.sensors.form')
            ->with('sensor', $sensor)
            ->with('parentlocations', $parentPaths)
            ->with('locations', $location)
            ->with('gateways', $gateway)
            ->with('sensorModels', $sensorModels);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sensor $sensor)
    {

        $request->validate(self::formRule($sensor->id), self::errorMessage(), self::changeAttributes());
        DB::enableQueryLog();
        $sensor->update($request->all());

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id);
        }

        return redirect()->route('sensors.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {

        DB::enableQueryLog();

        $id = $request->id;
        $sensor = $sensor = Sensor::findOrFail($id);
        $sensor->save();
        $sensor->delete();

        (new SensorOfflineService())->store(DB::getQueryLog(), $sensor->gateway_id);

        return Response::json($sensor);
    }

    public function formRule($id = false)
    {
        return [
            'slave_address' => ['required', 'string', 'min:1', 'max:200', Rule::unique('sensors')->ignore($id ? $id : '')],
            'description' => ['required', 'string', 'min:3', 'max:500'],
            'location_id' => 'required',
            'gateway_id' => 'required',
            'sensor_model_id' => 'required',
        ];
    }

    public function errorMessage()
    {
        return [
            'slave_address.required' => 'Slave Address is required',
            'description.required' => 'Description is required',
            'location_id.required' => 'Location is required',
            'gateway_id.required' => 'Gateway is required',
            'sensor_model_id.required' => 'Sensor Model is required',
        ];
    }

    public function changeAttributes()
    {
        return [
            'slave_address' => 'Slave Address',
            'description' => 'Description',
            'location_id' => 'Location',
            'gateway_id' => 'Gateway',
            'sensor_model_id' => 'Sensor Model',
        ];
    }

    public function getSensorChart(Request $request)
    {

        $getEnergy = (new EnergyConsumptionService)->get($request);
        $energyResult = collect($getEnergy->get());
        // Only exclude sensor ID 15 (MDP in Building 1)
        $excludedIds = [15,19];

        $sensors = Sensor::select(
            'sensors.location_id as pid',
            'sensors.description as name',
            'sensors.id',
            'sensor_models.sensor_brand'
        )
            ->leftJoin('gateways', 'sensors.gateway_id', '=', 'gateways.id')
            ->leftJoin('sensor_models', 'sensor_model_id', '=', 'sensor_models.id')
            ->whereNotIn('sensors.id', $excludedIds)
            ->get()
            ->map(function ($sensor) use ($energyResult) {
                $energy = $energyResult->where('sensor_id', $sensor->id)->first();
                // $formatter = new NumberFormatter('en_US', NumberFormatter::DECIMAL);
    
                if ($energy) {
                    $energy->real_power = $sensor->sensor_brand === "Eastron"
                        ? number_format($energy->real_power / 1000, 2, '.', ',')
                        : number_format($energy->real_power, 2, '.', ',');

                    $sensor->real_power = $energy->real_power;
                    $sensor->daily_consumption = $energy->daily_consumption;
                } else {
                    $sensor->real_power = null;
                    $sensor->daily_consumption = null;
                }

                // Remap sensor IDs 6, 7, 8 to avoid conflict with building IDs
                if (in_array($sensor->id, [6, 7, 8])) {
                    $sensor->id = $sensor->id + 100; // Change to 106, 107, 108
                }

                $sensor->tags = ["Sensor"];
                return $sensor;
            });

        // Also append aggregated Building entries (ids 6,7,8) computed from sensors 15..19
        $mapBySensor = [];
        $energyResult->each(function ($row) use (&$mapBySensor) {
            $id = intval($row->sensor_id ?? 0);
            $mapBySensor[$id] = ($mapBySensor[$id] ?? 0) + floatval($row->daily_consumption ?? 0);
        });

        $building2 = ($mapBySensor[16] ?? 0) + ($mapBySensor[17] ?? 0) + ($mapBySensor[18] ?? 0);
        $building3 = $mapBySensor[19] ?? 0;
        $building1 = ($mapBySensor[15] ?? 0) - $building2;

        $building1 = round($building1, 2);
        $building2 = round($building2, 2);
        $building3 = round($building3, 2);

        $buildingEntries = collect();

        // Use IDs 6, 7, 8 for buildings so child locations (with pid 6, 7, 8) can reference them


        $b1 = new Sensor();
        $b1->pid = 2;
        $b1->name = 'Building 1';
        $b1->id = 6;
        $b1->sensor_brand = null;
        $b1->real_power = null;
        $b1->daily_consumption = $building1;
        $b1->tags = ['Building'];
        $buildingEntries->push($b1);

        $b2 = new Sensor();
        $b2->pid = 2;
        $b2->name = 'Building 2';
        $b2->id = 7;
        $b2->sensor_brand = null;
        $b2->real_power = null;
        $b2->daily_consumption = $building2;
        $b2->tags = ['Building'];
        $buildingEntries->push($b2);

        $b3 = new Sensor();
        $b3->pid = 2;
        $b3->name = 'Building 3';
        $b3->id = 8;
        $b3->sensor_brand = null;
        $b3->real_power = null;
        $b3->daily_consumption = $building3;
        $b3->tags = ['Building'];
        $buildingEntries->push($b3);

        $ems= new Sensor();
        $ems->pid = 1;
        $ems->name = 'EMS';
        $ems->id = 2;
        $ems->sensor_brand = null;
        $ems->real_power = null;
        $ems->daily_consumption = round($building1 + $building2 + $building3,2);
        $ems->tags = ['Building'];
        $buildingEntries->push($ems);   
        
        $sensors = $sensors->merge($buildingEntries);

        return Response::json($sensors);
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
