<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\SensorRegister;
use App\Models\SensorType;
use App\Models\SensorModel;
use App\Services\SensorOfflineService;
use DB;
use Illuminate\Http\Request;
use Response;
use Illuminate\Validation\Rule;

class SensorRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensorRegisters = SensorRegister::all();

        return view('pages.configurations.sensorRegisters.index', compact('sensorRegisters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sensorTypes = SensorType::all();
        $sensorModels = SensorModel::all();

        return view('pages.configurations.sensorRegisters.form', compact('sensorTypes', 'sensorModels'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $sensorRegister = new SensorRegister($request->all());

        $sensorRegister->save();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->update(DB::getQueryLog(), $gateway->id);
        }

        return redirect()->route('sensorRegisters.index')->with('success', 'Sensor Register created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SensorRegister $sensorRegister)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SensorRegister $sensorRegister)
    {
        $sensorTypes = SensorType::all();
        $sensorModels = SensorModel::all();

        return view('pages.configurations.sensorRegisters.form', compact('sensorRegister', 'sensorTypes', 'sensorModels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SensorRegister $sensorRegister)
    {
        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());

        DB::enableQueryLog();

        $sensorRegister->update($request->all());

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id);
        }

        return redirect()->route('sensorRegisters.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        // DB::enableQueryLog();

        $id = $request->id;
        $sensorRegister = $sensorRegister = SensorRegister::findOrFail($id);
        $sensorRegister->save();
        $sensorRegister->delete();

        // $gateways = Gateway::all();

        // foreach ($gateways as $key => $gateway) {
        //     (new SensorOfflineService())->delete(DB::getQueryLog(), $gateway->id);
        // }


        return Response::json($sensorRegister);
    }
    public function formRule()
    {
        return [
            'sensor_model_id' => 'required',
            'sensor_type_id' => 'required',
            'sensor_reg_address' => 'required|string',
        ];
    }

    public function errorMessage()
    {
        return [
            'sensor_model_id.required' => 'Sensor Model is required',
            'sensor_type_id.required' => 'Sensor Type is required',
            'sensor_reg_address.required' => 'Sensor Register Address is required',
        ];
    }
    public function changeAttributes()
    {
        return [
            'sensor_model_id' => 'Sensor Model',
            'sensor_type_id' => 'Sensor Type',
            'sensor_reg_address' => 'Sensor Register Address',
        ];
    }
}
