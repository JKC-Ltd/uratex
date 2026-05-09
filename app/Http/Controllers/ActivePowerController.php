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

class ActivePowerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->userType && $user->userType->name === 'Admin';
        $userBranches = $isAdmin ? Branch::orderBy('name')->get() : $user->branches()->orderBy('name')->get();
        $isMultiBranch = $isAdmin || $userBranches->count() > 1;
        $selectedBranchId = $isMultiBranch ? $request->branch_id : $userBranches->first()?->id;

        // For non-admin, ensure the selected branch is within their allowed branches
        if (!$isAdmin && $selectedBranchId && !$userBranches->pluck('id')->contains((int) $selectedBranchId)) {
            $selectedBranchId = null;
        }

        $sensorsQuery = Sensor::query();

        if ($selectedBranchId) {
            $sensorsQuery->whereHas('location', function ($query) use ($selectedBranchId) {
                $query->where('branch_id', $selectedBranchId);
            });
        } elseif ($isMultiBranch && !$isAdmin) {
            // Multi-branch user with no specific branch – show all their branches
            $branchIds = $userBranches->pluck('id');
            $sensorsQuery->whereHas('location', function ($query) use ($branchIds) {
                $query->whereIn('branch_id', $branchIds);
            });
        } elseif (!$isAdmin) {
            $sensorsQuery->whereRaw('1 = 0');
        }
        // Admin with no branch selected: no filter (show all)

        $sensors = $sensorsQuery->get();
        $latestLogAt = null;

        if ($sensors->isNotEmpty()) {
            $latestLogAt = DB::table('sensor_logs')
                ->whereIn('sensor_id', $sensors->pluck('id'))
                ->max('datetime_created');
        }

        $lastUpdate = $latestLogAt ? Carbon::parse($latestLogAt)->format('M j, Y h:i A') : 'N/A';
        $branches = $userBranches;

        return view('pages.active-power')
            ->with('sensors', $sensors)
            ->with('branches', $branches)
            ->with('selectedBranchId', $selectedBranchId)
            ->with('isAdmin', $isAdmin)
            ->with('isMultiBranch', $isMultiBranch)
            ->with('lastUpdate', $lastUpdate);
    }

    public function getActivePowerProfile(Request $request)
    {
        $query = Sensor::with(['location', 'gateway'])
            ->select(
                'sensors.*',
                'locations.location_name as location_name',
                'gateways.gateway_code',
                'sensor_logs.energy',
                'sensor_logs.voltage_ab',
                'sensor_logs.voltage_bc',
                'sensor_logs.voltage_ca',
                'sensor_logs.current_a',
                'sensor_logs.current_b',
                'sensor_logs.current_c',
                'sensor_logs.real_power',
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
            // ->where('sensor_logs.datetime_created', '>=', Carbon::now()->subDays(20));
            ->whereRaw('HOUR(sensor_logs.datetime_created) = 9');

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
