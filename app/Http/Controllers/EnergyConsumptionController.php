<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Gateway;
use App\Models\Sensor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class EnergyConsumptionController extends Controller
{
    public function index(Request $request)
    {
        /** @var User|null $user */
        $user = Auth::user();
        $isAdmin = $user && $user->userType && $user->userType->name === 'Admin';
        $isUserTypeUser = $user && $user->userType && $user->userType->name === 'User';
        $userBranches = $isAdmin ? Branch::orderBy('name')->get() : $user->branches()->orderBy('name')->get();
        $canBrowseAllBranches = !$isAdmin && $isUserTypeUser && $userBranches->isEmpty();
        $branches = ($isAdmin || $canBrowseAllBranches) ? Branch::orderBy('name')->get() : $userBranches;
        $isMultiBranch = $isAdmin || $branches->count() > 1 || $canBrowseAllBranches;
        $selectedBranchId = $isMultiBranch ? $request->branch_id : $branches->first()?->id;

        if (!$isAdmin && $selectedBranchId && !$branches->pluck('id')->contains((int) $selectedBranchId)) {
            $selectedBranchId = null;
        }

        return view('pages.energy-consumption')
            ->with('branches', $branches)
            ->with('isAdmin', $isAdmin)
            ->with('isMultiBranch', $isMultiBranch)
            ->with('selectedBranchId', $selectedBranchId);
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

        if ($request->branch_id) {
            $query->where('locations.branch_id', $request->branch_id);
        }

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
