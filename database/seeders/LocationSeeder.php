<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value =
            [
                ["id" => "1", "location_code" => "SEP", "location_name" => "SEP", "pid" => null, "created_at" => "2025-03-02 09:26:56", "updated_at" => "2025-03-02 09:26:56", "deleted_at" => null],
                ["id" => "2", "location_code" => "EMS", "location_name" => "EMS", "pid" => "1", "created_at" => "2025-03-02 09:28:08", "updated_at" => "2025-03-02 09:28:08", "deleted_at" => null],
                ["id" => "3", "location_code" => "Injection", "location_name" => "Injection", "pid" => "1", "created_at" => "2025-03-02 09:28:59", "updated_at" => "2025-03-02 09:28:59", "deleted_at" => null],
                ["id" => "4", "location_code" => "CIP2", "location_name" => "CIP2", "pid" => "1", "created_at" => "2025-03-02 09:29:11", "updated_at" => "2025-03-02 09:29:11", "deleted_at" => null],
                ["id" => "5", "location_code" => "Building 4", "location_name" => "Building 4", "pid" => "1", "created_at" => "2025-03-02 09:30:20", "updated_at" => "2025-03-02 09:30:20", "deleted_at" => null],
                ["id" => "6", "location_code" => "Building 1", "location_name" => "Building 1", "pid" => "2", "created_at" => "2025-03-02 09:30:32", "updated_at" => "2025-03-02 09:30:32", "deleted_at" => null],
                ["id" => "7", "location_code" => "Building 2", "location_name" => "Building 2", "pid" => "2", "created_at" => "2025-03-02 09:31:51", "updated_at" => "2025-03-02 09:31:51", "deleted_at" => null],
                ["id" => "8", "location_code" => "Building 3", "location_name" => "Building 3", "pid" => "2", "created_at" => "2025-03-02 09:32:04", "updated_at" => "2025-03-02 09:32:04", "deleted_at" => null],
                ["id" => "9", "location_code" => "1st Floor", "location_name" => "1st Floor", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "10", "location_code" => "2nd Floor", "location_name" => "2nd Floor", "pid" => "3", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "11", "location_code" => "1st Floor", "location_name" => "1st Floor", "pid" => "6", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "12", "location_code" => "2nd Floor", "location_name" => "2nd Floor", "pid" => "6", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "13", "location_code" => "1st Floor", "location_name" => "1st Floor", "pid" => "7", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "14", "location_code" => "2nd Floor", "location_name" => "2nd Floor", "pid" => "7", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "15", "location_code" => "1st Floor", "location_name" => "1st Floor", "pid" => "8", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "16", "location_code" => "2nd Floor", "location_name" => "2nd Floor", "pid" => "8", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "17", "location_code" => "IIDA line", "location_name" => "IIDA line", "pid" => "11", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "18", "location_code" => "IIDA Office", "location_name" => "IIDA Office", "pid" => "11", "created_at" => "2025-03-02 09:32:49", "updated_at" => "2025-03-02 09:32:49", "deleted_at" => null],
                ["id" => "19", "location_code" => "Canteen", "location_name" => "Canteen", "pid" => "12", "created_at" => null, "updated_at" => null, "deleted_at" => null],
                ["id" => "20", "location_code" => "General Office", "location_name" => "General Office", "pid" => "12", "created_at" => null, "updated_at" => null, "deleted_at" => null],
                ["id" => "21", "location_code" => "SMT Area", "location_name" => "SMT Area", "pid" => "13", "created_at" => null, "updated_at" => null, "deleted_at" => null],
                ["id" => "22", "location_code" => "A1 reflow", "location_name" => "A1 reflow", "pid" => "21", "created_at" => null, "updated_at" => null, "deleted_at" => null],
                ["id" => "23", "location_code" => "B5 reflow", "location_name" => "B5 reflow", "pid" => "21", "created_at" => null, "updated_at" => null, "deleted_at" => null],
                ["id" => "24", "location_code" => "EOL", "location_name" => "EOL", "pid" => "13", "created_at" => null, "updated_at" => null, "deleted_at" => null]

            ];

        foreach ($value as $item) {
            Location::updateOrCreate(
                ['id' => $item['id']],
                [
                    'location_code' => $item['location_code'],
                    'location_name' => $item['location_name'],
                    'pid' => $item['pid'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                    'deleted_at' => $item['deleted_at']
                ]
            );
        }

    }
}
