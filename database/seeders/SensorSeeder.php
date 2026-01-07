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
            [
                "id" => 1,
                "slave_address" => 2,
                "description" => "MDP 1",
                "location_id" => 3,
                "gateway_id" => 1,
                "sensor_model_id" => 1
            ],
        ];

        foreach ($value as $item) {
            SensorModel::updateOrCreate(
                ['id' => $item['id']],
                [
                    'slave_address' => $item['slave_address'],
                    'description' => $item['description'],
                    'location_id' => $item['location_id'],
                    'gateway_id' => $item['gateway_id'],
                    'gateway_id' => $item['sensor_model_id'],
                ]
            );
        }
    }
}
