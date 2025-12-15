<?php

namespace App\Http\Controllers;

use App\Exports\SensorDataExport;
use App\Models\Gateway;
use App\Models\Sensor;
use App\Models\User;
use App\Services\EnergyConsumptionService;
use Carbon\Carbon;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gateways = Gateway::all();
        $sensors = Sensor::all();
        $area = Sensor::groupBy('location_id')->where('id', "!=", 15)->get();
        $users = User::all();

        return view('pages.dashboard')
            ->with('gateways', $gateways)
            ->with('sensors', $sensors)
            ->with('area', $area)
            ->with('users', $users);

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

        $dailyEnergyPerBuilding = (new EnergyConsumptionService)->getPerBuilding($request);

        return Response::json($dailyEnergyPerBuilding);
    }

    public function getEnergyConsumption(Request $request)
    {

        $energyConsumptionService = (new EnergyConsumptionService)->get($request);

        $dailyEnergy = $energyConsumptionService->get();

        return Response::json($dailyEnergy);
    }

    public function getPower(Request $request)
    {

        $energyConsumptionService = (new EnergyConsumptionService)->getPower($request);

        $dailyEnergy = $energyConsumptionService->get();

        return Response::json($dailyEnergy);
    }
}
