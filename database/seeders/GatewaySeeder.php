<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gateway;

class GatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            [
                "id" => 1,
                "location_id" => 3,
                "customer_code" => "Uratex",
                "gateway_code" => "GAT-01",
                "description" => "Gateway on Admin Building"
            ],
        ];

        foreach ($value as $item) {
            Gateway::updateOrCreate(
                ['id' => $item['id']],
                [
                    'location_id' => $item['location_id'],
                    'customer_code' => $item['customer_code'],
                    'gateway_code' => $item['gateway_code'],
                    'description' => $item['description'],
                ]
            );
        }
    }
}
