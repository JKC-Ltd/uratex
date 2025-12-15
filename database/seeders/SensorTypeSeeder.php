<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SensorType;

class SensorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            ['id' => '1', 'description' => 'Single Phase Meter', 'sensor_type_code' => 'SPM', 'sensor_type_parameter' => 'voltage_ab,current_a,real_power,apparent_power,energy', 'created_at' => '2025-02-14 09:04:41', 'updated_at' => '2025-02-14 09:06:28', 'deleted_at' => NULL],
            ['id' => '2', 'description' => 'Three Phase Meter', 'sensor_type_code' => 'TPM', 'sensor_type_parameter' => 'voltage_ab,voltage_bc,voltage_ca,current_a,current_b,current_c,real_power,apparent_power,energy', 'created_at' => '2025-02-14 09:05:34', 'updated_at' => '2025-02-14 09:06:21', 'deleted_at' => NULL],
            ['id' => '3', 'description' => 'Temperature & Humidity Sensor', 'sensor_type_code' => 'THS', 'sensor_type_parameter' => 'temperature,humidity', 'created_at' => '2025-02-14 09:06:13', 'updated_at' => '2025-02-14 09:06:13', 'deleted_at' => NULL],
            ['id' => '4', 'description' => 'Flow Meter', 'sensor_type_code' => 'FVM', 'sensor_type_parameter' => 'volume,flow', 'created_at' => '2025-02-14 09:07:05', 'updated_at' => '2025-02-14 09:07:05', 'deleted_at' => NULL],
            ['id' => '5', 'description' => 'Pressure Meter Guage', 'sensor_type_code' => 'PMG', 'sensor_type_parameter' => 'pressure', 'created_at' => '2025-02-14 09:07:28', 'updated_at' => '2025-02-14 09:07:28', 'deleted_at' => NULL],
            ['id' => '6', 'description' => 'Air Quality Meter', 'sensor_type_code' => 'AQM', 'sensor_type_parameter' => 'co2,pm25_pm10,o2,nox,co,s02', 'created_at' => '2025-02-14 09:08:48', 'updated_at' => '2025-02-14 09:08:48', 'deleted_at' => NULL]
        ];

        foreach ($value as $item) {
            SensorType::updateOrCreate(
                ['id' => $item['id']],
                ['description' => $item['description'],
                'sensor_type_code' => $item['sensor_type_code'],
                'sensor_type_parameter' => $item['sensor_type_parameter'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
                'deleted_at' => $item['deleted_at']
                ]                
            );
        }
    }
}
