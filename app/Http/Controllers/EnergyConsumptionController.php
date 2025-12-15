<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Sensor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class EnergyConsumptionController extends Controller
{
    public function index()
    {
        return view('pages.energy-consumption');
    }

    public function getEnergyConsumption(Request $request)
    {
        $query = Sensor::with(['location', 'gateway'])
            ->select(
                'sensors.*',
                'locations.location_name as location_name',
                'gateways.gateway_code',
                'sensor_logs.energy',
                'sensor_logs.datetime_created',
                DB::raw("ROUND(sensor_logs.energy - LAG(sensor_logs.energy) OVER(
                    PARTITION BY sensors.id 
                    ORDER BY sensor_logs.datetime_created
                ), 2) AS energy_difference"),
                DB::raw('DATE(sensor_logs.datetime_created) AS date_created')
            )
            ->leftJoin('locations', 'locations.id', '=', 'sensors.location_id')
            ->leftJoin('gateways', 'gateways.id', '=', 'sensors.gateway_id')
            ->leftJoin('sensor_logs', 'sensor_logs.sensor_id', '=', 'sensors.id')
            ->whereRaw('HOUR(sensor_logs.datetime_created) = 9'); // Get the date on the 9th hour of the day
        // ->where('sensor_logs.datetime_created', '>=', Carbon::now()->subDays(31)); 

        if ($request->sensor_id) {
            $query->where('sensors.id', $request->sensor_id);
        }

        $energyConsumption = $query->groupBy('sensors.description', 'date_created')
            ->orderBy('sensors.id')
            ->orderBy('sensor_logs.datetime_created')
            ->get();

        return Response::json($energyConsumption);
    }
}
