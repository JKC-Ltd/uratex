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
            ["id" => "1", "location_id" => "3", "customer_code" => "Uratex", "gateway" => "1", "gateway_code" => "GAT-01", "description" => "Gateway on Admin Building"],
            ["id" => "2", "location_id" => "4", "customer_code" => "Uratex", "gateway" => "2", "gateway_code" => "GAT-02", "description" => "Gateway on Building No. 18"],
            ["id" => "3", "location_id" => "5", "customer_code" => "Uratex", "gateway" => "3", "gateway_code" => "GAT-03", "description" => "Gateway on Building No. 12"],
            ["id" => "4", "location_id" => "6", "customer_code" => "Uratex", "gateway" => "4", "gateway_code" => "GAT-04", "description" => "Gateway on Building No. 13"],
            ["id" => "5", "location_id" => "7", "customer_code" => "Uratex", "gateway" => "5", "gateway_code" => "GAT-05", "description" => "Gateway on Building No. 11"],
            ["id" => "6", "location_id" => "8", "customer_code" => "Uratex", "gateway" => "6", "gateway_code" => "GAT-06", "description" => "Gateway on Building No. 9"],
            ["id" => "7", "location_id" => "9", "customer_code" => "Uratex", "gateway" => "7", "gateway_code" => "GAT-07", "description" => "Gateway on Building No. 17"],
            ["id" => "8", "location_id" => "11", "customer_code" => "Uratex", "gateway" => "8", "gateway_code" => "GAT-08", "description" => "Gateway on Powerhouse 1"],
            ["id" => "9", "location_id" => "12", "customer_code" => "Uratex", "gateway" => "9", "gateway_code" => "GAT-09", "description" => "Gateway on Powerhouse 2"],
            ["id" => "10", "location_id" => "13", "customer_code" => "Uratex", "gateway" => "10", "gateway_code" => "GAT-10", "description" => "Gateway on Powerhouse 3"],
            ["id" => "11", "location_id" => "14", "customer_code" => "Uratex", "gateway" => "11", "gateway_code" => "GAT-11", "description" => "Gateway on Powerhouse 4"],
            ["id" => "12", "location_id" => "15", "customer_code" => "Uratex", "gateway" => "12", "gateway_code" => "GAT-12", "description" => "Gateway on Powerhouse 5"],
            ["id" => "13", "location_id" => "17", "customer_code" => "Uratex", "gateway" => "13", "gateway_code" => "GAT-13", "description" => "Gateway on Powerhouse 1"],
            ["id" => "14", "location_id" => "18", "customer_code" => "Uratex", "gateway" => "14", "gateway_code" => "GAT-14", "description" => "Gateway on Powerhouse 2"],
            ["id" => "15", "location_id" => "19", "customer_code" => "Uratex", "gateway" => "15", "gateway_code" => "GAT-15", "description" => "Gateway on Powerhouse 3"],
            ["id" => "16", "location_id" => "20", "customer_code" => "Uratex", "gateway" => "16", "gateway_code" => "GAT-16", "description" => "Gateway on Powerhouse 4"],
        ];

        foreach ($value as $item) {
            Gateway::updateOrCreate(
                ['id' => $item['id']],
                [
                    'location_id' => $item['location_id'],
                    'customer_code' => $item['customer_code'],
                    'gateway' => $item['gateway'],
                    'gateway_code' => $item['gateway_code'],
                    'description' => $item['description'],
                ]
            );
        }
    }
}
