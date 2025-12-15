<?php

use App\Http\Controllers\ActivePowerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LocationDashboardController;
use App\Http\Controllers\EnergyConsumptionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SensorModelController;
use App\Http\Controllers\SensorTypeController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\SensorRegisterController;
use App\Http\Controllers\VoltageCurrentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

function registerCommonRoutes()
{
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('locationDashboard', LocationDashboardController::class);
    Route::resource('energyConsumption', EnergyConsumptionController::class);
    Route::resource('activePower', ActivePowerController::class);
    Route::resource('voltageCurrent', VoltageCurrentController::class);

    Route::get('/getSensorType/{id}', [SensorModelController::class, 'getSensorType']);
    Route::get('/getSensorModel/{id}', [SensorModelController::class, 'getSensorModel']);

    Route::get('/getLocationChart', [LocationController::class, 'getLocationChart']);
    Route::get('/getSensorChart', [SensorController::class, 'getSensorChart']);
    Route::get('/getSensor', [LocationDashboardController::class, 'getSensor']);
    Route::get('/getDailyEnergyConsumption', [DashboardController::class, 'getDailyEnergyConsumption']);
    Route::get('/getEnergyConsumptionPerBuilding', [DashboardController::class, 'getEnergyConsumptionPerBuilding']);
    Route::get('/getEnergyConsumption', [DashboardController::class, 'getEnergyConsumption']);
    Route::get('/getPower', [DashboardController::class, 'getPower']);
    Route::get('/exportCSV', [DashboardController::class, 'exportCSV']);

    // Route::get('/getEnergyConsumption', [EnergyConsumptionController::class, 'getEnergyConsumption']);
    // Route::get('/getEnergyConsumptionBasedOnDate', [DashboardController::class, 'getEnergyConsumptionBasedOnDate']);
    // Route::get('/getEnergyConsumptionBasedOnHours', [DashboardController::class, 'getEnergyConsumptionBasedOnHours']);
    // Route::get('/getActivePowerProfile', [ActivePowerController::class, 'getActivePowerProfile']);
    // Route::get('/getVoltageCurrentProfile', [VoltageCurrentController::class, 'getVoltageCurrentProfile']);
    // Route::get('/getDailyEnergyConsumptionPerMeter', [DashboardController::class, 'getDailyEnergyConsumptionPerMeter']);
}

Route::middleware(['auth', 'admin:Admin'])->group(function () {
    Route::resource('locations', LocationController::class);
    Route::resource('sensorModels', SensorModelController::class);
    Route::resource('sensorTypes', SensorTypeController::class);
    Route::resource('sensorRegisters', SensorRegisterController::class);
    Route::resource('sensors', SensorController::class);
    Route::resource('gateways', GatewayController::class);
    Route::resource('users', UserController::class);

    registerCommonRoutes();
});

Route::middleware(['auth'])->group(function () {
    registerCommonRoutes();
});

require __DIR__ . '/auth.php';
