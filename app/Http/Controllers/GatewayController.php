<?php

namespace App\Http\Controllers;

use App\Models\Gateway;
use App\Models\Location;
use App\Services\SensorOfflineService;
use DB;
use Illuminate\Http\Request;
use Response;
use Illuminate\Validation\Rule;

class GatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $gateways = Gateway::all() ?? collect();
        
        return view('pages.configurations.gateways.index', compact('gateways'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $locations = Location::all();
        // dd($locations);
        return view('pages.configurations.gateways.form', compact('locations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( self::formRule(),self::errorMessage(), self::changeAttributes());
        
        DB::enableQueryLog();

        $gateway = new Gateway($request->all());
        $gateway->save();
        
        (new SensorOfflineService())->store(DB::getQueryLog(), $gateway->id, 'gateway_code');

        return redirect()->route('gateways.index')->with('success', 'Gateway created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Gateway $gateway)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Gateway $gateway)
    {
        $locations = Location::all();
        return view('pages.configurations.gateways.form', compact('gateway'), compact('locations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Gateway $gateway)
    {
        $request->validate( self::formRule($gateway->id),self::errorMessage(), self::changeAttributes());
        
        DB::enableQueryLog();

        $gateway->update($request->all());
        
        (new SensorOfflineService())->update(DB::getQueryLog(), $gateway->id, 'gateway_code');

        return redirect()->route('gateways.index')->with('success', 'Gateway updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       
        DB::enableQueryLog();

        $id                     = $request->id;
        $gateway                = $gateway = Gateway::findOrFail($id);       
        $gateway->save();
        $gateway->delete();
        
        (new SensorOfflineService())->delete(DB::getQueryLog(), $gateway->id);
        
        return Response::json($gateway);
    }

    public function formRule($id = false)
    {
        return [
            'location_id' => ['required','exists:locations,id'],
            'gateway_code' => ['required','string',Rule::unique('gateways')->ignore($id ? $id : "")],
            'customer_code' => ['required'],
            'gateway' => ['required','string'],
            'description' => ['required','string','max:500'],
        ];
    }
    public function errorMessage()
    {
        return [
            'location_id.required' => 'Location is required',
            'location_id.exists' => 'Location does not exist',
            'gateway_code.required' => 'Gateway code is required',
            'gateway_code.unique' => 'Gateway code already exists',
            'customer_code.required' => 'Customer code is required',
            'gateway.required' => 'Gateway is required',
            'description.max' => 'Description is too long',
            
        ];
    }
    public function changeAttributes()
    {
        return [
            'location_id' => 'Location',
            'gateway_code' => 'Gateway Code',
            'customer_code' => 'Customer Code',
            'gateway' => 'Gateway',
            'description' => 'Description',
        ];
    }
}
