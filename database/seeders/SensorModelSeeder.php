<?php

namespace Database\Seeders;

use App\Models\SensorModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SensorModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            [
                "id" => 1,
                "sensor_model" => "CVM-C10",
                "sensor_brand" => "Circutor",
                "sensor_type_id" => 2,
                "sensor_reg_address" => "62,64,66,2,18,34,48,54,220"
            ],
        ];

        foreach ($value as $item) {
            SensorModel::updateOrCreate(
                ['id' => $item['id']],
                [
                    'sensor_model' => $item['sensor_model'],
                    'sensor_brand' => $item['sensor_brand'],
                    'sensor_type_id' => $item['sensor_type_id'],
                    'sensor_reg_address' => $item['sensor_reg_address'],
                ]
            );
        }
    }
}
