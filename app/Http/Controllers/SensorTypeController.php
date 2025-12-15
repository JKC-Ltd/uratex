<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\SensorType;
use App\Services\SensorOfflineService;
use DB;
use Illuminate\Http\Request;
use Response;
use Illuminate\Validation\Rule;

class SensorTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sensorTypes = SensorType::all();

        return view('pages.configurations.sensorTypes.index')
            ->with('sensorTypes', $sensorTypes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $getColumn = \Schema::getColumnListing('sensor_logs');
        // dd($sensorLogs);
        $sensorLogs = array_diff($getColumn, ['id','gateway_id', 'sensor_id','datetime_created', 'created_at', 'updated_at']);
        return view('pages.configurations.sensorTypes.form',compact('sensorLogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $sensorTypeArray = implode(',', $request->sensor_type_parameter);

        $request->validate(self::formRule(), self::errorMessage(), self::changeAttributes());
        
        DB::enableQueryLog();
        
        $sensorType = new SensorType($request->all());
        $sensorType->sensor_type_parameter = $sensorTypeArray;
        $sensorType->save();

        $gateways = Gateway::all();

        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id, 'sensor_type_code');
        }

        return redirect()->route('sensorTypes.index')->with('success', 'Sensor Type created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SensorType $sensorType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SensorType $sensorType)
    {
        $getColumn = \Schema::getColumnListing('sensor_logs');
        // dd($sensorLogs);
        $sensorLogs = array_diff($getColumn, ['id','gateway_id', 'sensor_id','datetime_created', 'created_at', 'updated_at']);
        return view('pages.configurations.sensorTypes.form', compact('sensorType','sensorLogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SensorType $sensorType)
    {
        
        $request->validate(self::formRule($sensorType->id), self::errorMessage(), self::changeAttributes());

        $sensorTypeArray = implode(',', $request->sensor_type_parameter);
        $sensorType->sensor_type_parameter = $sensorTypeArray;
        $requestData = $request->all();
        $requestData['sensor_type_parameter'] = $sensorTypeArray;
        
        DB::enableQueryLog();

        $sensorType->update($requestData);

        $gateways = Gateway::all();
        
        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->update(DB::getQueryLog(), $gateway->id);
        }


        return redirect()->route('sensorTypes.index')->with('success', 'Location updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        DB::enableQueryLog();

        $id = $request->id;
        $sensorType = $sensorType = SensorType::findOrFail($id);
        $sensorType->save();
        $sensorType->delete();
        
        $gateways = Gateway::all();
        
        foreach ($gateways as $key => $gateway) {
            (new SensorOfflineService())->delete(DB::getQueryLog(), $gateway->id);
        }


        return Response::json($sensorType);
    }
    public function formRule($id = false)
    {
        return [
            'sensor_type_code' => ['required', 'string', Rule::unique('sensor_types')->ignore($id ? $id : "")],
            'sensor_type_parameter' => ['required'],
            'description' => ['required', 'string', 'min:3', 'max:200'],

        ];
    }
    public function errorMessage()
    {
        return [
            'sensor_type_code.required' => 'Sensor Type Code is required',
            'sensor_type_parameter.required' => 'Sensor Type Parameter is required',
            'description.required' => 'Description is required',
        ];
    }
    public function changeAttributes()
    {
        return [
            'sensor_type_code' => 'Sensor Type Code',
            'sensor_type_parameter' => 'Sensor Type Parameter',
            'description' => 'Description'
        ];
    }
}
