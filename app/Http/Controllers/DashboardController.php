<?php

namespace App\Http\Controllers;

use App\Exports\SensorDataExport;
use App\Models\Branch;
use App\Models\Gateway;
use App\Models\Sensor;
use App\Models\User;
use App\Services\EnergyConsumptionService;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class DashboardController extends Controller
{
    public function indexV2(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->userType && $user->userType->name === 'Admin';
        $branches = $isAdmin ? Branch::orderBy('name')->get() : $user->branches()->orderBy('name')->get();
        $isMultiBranch = $isAdmin || $branches->count() > 1;
        $selectedBranchId = $isMultiBranch ? $request->branch_id : $branches->first()?->id;

        return view('pages.dashboardv2', compact('branches', 'isAdmin', 'isMultiBranch', 'selectedBranchId'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user && $user->userType && $user->userType->name === 'Admin';
        $userBranches = $isAdmin ? Branch::orderBy('name')->get() : $user->branches()->orderBy('name')->get();
        $isMultiBranch = $isAdmin || $userBranches->count() > 1;
        $selectedBranchId = $isMultiBranch ? $request->branch_id : $userBranches->first()?->id;

        $gateways = Gateway::all();
        $sensors = Sensor::all();
        $area = Sensor::groupBy('location_id')->where('id', '!=', 15)->get();
        $users = User::all();

        return view('pages.dashboard')
            ->with('gateways', $gateways)
            ->with('sensors', $sensors)
            ->with('area', $area)
            ->with('users', $users)
            ->with('branches', $userBranches)
            ->with('isAdmin', $isAdmin)
            ->with('isMultiBranch', $isMultiBranch)
            ->with('selectedBranchId', $selectedBranchId);
    }

    /**
     * Restrict a request's branch scope to what the authenticated user is allowed to see.
     * Admins are unrestricted. Non-admins are always scoped to their assigned branches.
     */
    private function applyBranchRestrictions(Request $request): Request
    {
        $user = Auth::user();
        if (!$user) {
            return $request;
        }
        $isAdmin = $user->userType && $user->userType->name === 'Admin';
        if ($isAdmin) {
            return $request;
        }

        $userBranchIds = $user->branches->pluck('id')->toArray();

        if ($request->branch_id && in_array((int) $request->branch_id, $userBranchIds)) {
            // Specific allowed branch selected – keep as-is
            return $request;
        }

        // No branch selected (or an invalid one) – scope to all user branches
        $request->merge(['branch_id' => null, 'branch_ids' => $userBranchIds]);
        return $request;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function exportCSV(Request $request)
    {

        $processUrl = $request->input('processUrl');
        $requestPayload = new Request($request->input('requestPayload'));

        $data = $this->$processUrl($requestPayload);

        $dataResponse = $this->$processUrl($requestPayload);

        if ($dataResponse instanceof JsonResponse) {
            $original = $dataResponse->getData(true); // `true` returns associative array

            // Assuming your data is inside a `data` key (update if different)
            $data = $original['data'] ?? $original;
        } else {
            $data = $dataResponse;
        }

        $headers = array_keys($data[0] ?? []);


        return Excel::download(new SensorDataExport($data, $headers), 'sensor_data.csv');
    }

    public function getDailyEnergyConsumption(Request $request)
    {

        $now = Carbon::now();
        $today7AM = $now->copy()->startOfDay()->addHours(7);
        $tomorrow7AM = $today7AM->copy()->addDay();

        if ($now->greaterThanOrEqualTo($today7AM)) {
            $startDate = Carbon::now()
                ->subDay()
                ->startOfDay()
                ->addHours(7)
                ->toDateTimeString(); // Yesterday's date

            $endDate = $tomorrow7AM->toDateTimeString();
        } else {
            $startDate = Carbon::now()
                ->subDays(2)
                ->startOfDay()
                ->addHours(7)
                ->toDateTimeString(); // Yesterday's date

            $endDate = $today7AM->toDateTimeString();
        }

        $request->startDate = $startDate;
        $request->endDate = $endDate;

        $request = $this->applyBranchRestrictions($request);
        $energyConsumptionService = (new EnergyConsumptionService)->get($request);

        $dailyEnergy = $energyConsumptionService->get();

        return Response::json($dailyEnergy);
    }

    public function getEnergyConsumptionPerBuilding(Request $request)
    {
        // // Align time window with dashboard's 7AM-based day window (same as getDailyEnergyConsumption)
        // $now = Carbon::now();
        // $today7AM = $now->copy()->startOfDay()->addHours(7);
        // $tomorrow7AM = $today7AM->copy()->addDay();

        // if ($now->greaterThanOrEqualTo($today7AM)) {
        //     $startDate = Carbon::now()
        //         ->subDay()
        //         ->startOfDay()
        //         ->addHours(7)
        //         ->toDateTimeString();

        //     $endDate = $tomorrow7AM->toDateTimeString();
        // } else {
        //     $startDate = Carbon::now()
        //         ->subDays(2)
        //         ->startOfDay()
        //         ->addHours(7)
        //         ->toDateTimeString();

        //     $endDate = $today7AM->toDateTimeString();
        // }

        // dd($startDate, $endDate);

        // $request->startDate = "2025-11-30 20:00:00";
        // $request->endDate = "2025-11-30 21:00:00";
        
        $request = $this->applyBranchRestrictions($request);
        $dailyEnergyPerBuilding = (new EnergyConsumptionService)->getPerBuilding($request);
        
        return Response::json($dailyEnergyPerBuilding);
    }

    public function getEnergyConsumption(Request $request)
    {
        $request = $this->applyBranchRestrictions($request);
        $energyConsumptionService = (new EnergyConsumptionService)->get($request);

        $dailyEnergy = $energyConsumptionService->get();

        return Response::json($dailyEnergy);
        
    }

    public function getPower(Request $request)
    {
        $request = $this->applyBranchRestrictions($request);
        $energyConsumptionService = (new EnergyConsumptionService)->getPower($request);

        $dailyEnergy = $energyConsumptionService->get();

        return Response::json($dailyEnergy);
    }
}
