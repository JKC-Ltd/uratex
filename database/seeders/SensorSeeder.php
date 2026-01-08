<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sensor;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            ["id" => 1, "slave_address" => "2", "description" => "MDP 1", "location_id" => 3, "gateway_id" => 1, "sensor_model_id" => 1],
            ["id" => 2, "slave_address" => "3", "description" => "MDP 2", "location_id" => 4, "gateway_id" => 2, "sensor_model_id" => 1],
            ["id" => 3, "slave_address" => "4", "description" => "MDP 3", "location_id" => 5, "gateway_id" => 3, "sensor_model_id" => 1],
            ["id" => 4, "slave_address" => "5", "description" => "MDP 4", "location_id" => 6, "gateway_id" => 4, "sensor_model_id" => 1],
            ["id" => 5, "slave_address" => "6", "description" => "MDP 5", "location_id" => 7, "gateway_id" => 5, "sensor_model_id" => 1],
            ["id" => 6, "slave_address" => "7", "description" => "MDP 6 230V", "location_id" => 8, "gateway_id" => 6, "sensor_model_id" => 1],
            ["id" => 7, "slave_address" => "8", "description" => "MDP 7 400V", "location_id" => 8, "gateway_id" => 6, "sensor_model_id" => 1],
            ["id" => 8, "slave_address" => "9", "description" => "MDP 8", "location_id" => 9, "gateway_id" => 7, "sensor_model_id" => 1],
            
            ["id" => 9, "slave_address" => "2", "description" => "MDP Main", "location_id" => 11, "gateway_id" => 8, "sensor_model_id" => 1],
            ["id" => 10, "slave_address" => "3", "description" => "MDP Main", "location_id" => 12, "gateway_id" => 9, "sensor_model_id" => 1],
            ["id" => 11, "slave_address" => "4", "description" => "MDP Main 230 V", "location_id" => 13, "gateway_id" => 10, "sensor_model_id" => 1],
            ["id" => 12, "slave_address" => "5", "description" => "MDP Main 400 V", "location_id" => 13, "gateway_id" => 10, "sensor_model_id" => 1],
            ["id" => 13, "slave_address" => "6", "description" => "MDP Main", "location_id" => 14, "gateway_id" => 11, "sensor_model_id" => 1],
            ["id" => 14, "slave_address" => "7", "description" => "MDP Main", "location_id" => 15, "gateway_id" => 12, "sensor_model_id" => 1],
            ["id" => 15, "slave_address" => "8", "description" => "MDP Main", "location_id" => 15, "gateway_id" => 12, "sensor_model_id" => 1],
            ["id" => 16, "slave_address" => "9", "description" => "MDP Main", "location_id" => 15, "gateway_id" => 12, "sensor_model_id" => 1],

            ["id" => 17, "slave_address" => "2", "description" => "MDP 440 V", "location_id" => 17, "gateway_id" => 13, "sensor_model_id" => 1],
            ["id" => 18, "slave_address" => "3", "description" => "MDP 230 V", "location_id" => 17, "gateway_id" => 13, "sensor_model_id" => 1],
            ["id" => 19, "slave_address" => "4", "description" => "MDP Main", "location_id" => 18, "gateway_id" => 14, "sensor_model_id" => 1],
            ["id" => 20, "slave_address" => "5", "description" => "MDP Main", "location_id" => 18, "gateway_id" => 14, "sensor_model_id" => 1],
            ["id" => 21, "slave_address" => "6", "description" => "MDP Main", "location_id" => 19, "gateway_id" => 15, "sensor_model_id" => 1],
            ["id" => 22, "slave_address" => "7", "description" => "MDP Main", "location_id" => 20, "gateway_id" => 16, "sensor_model_id" => 1],
            ["id" => 23, "slave_address" => "8", "description" => "MDP Main", "location_id" => 20, "gateway_id" => 16, "sensor_model_id" => 1],

        ];

        foreach ($value as $item) {
            Sensor::updateOrCreate(
                ['id' => $item['id']],
                [
                    'slave_address' => $item['slave_address'],
                    'description' => $item['description'],
                    'location_id' => $item['location_id'],
                    'gateway_id' => $item['gateway_id'],
                    'sensor_model_id' => $item['sensor_model_id'],
                ]
            );
        }
    }
}
