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
                ["id" => "1", "location_code" => "Uratex", "location_name" => "Uratex", "pid" => null, "created_at" => "2025-03-02 09:26:56", "updated_at" => "2025-03-02 09:26:56", "deleted_at" => null],
                ["id" => "2", "location_code" => "Valenzuela", "location_name" => "Valenzuela", "pid" => "1", "created_at" => "2025-03-02 09:28:08", "updated_at" => "2025-03-02 09:28:08", "deleted_at" => null],
                ["id" => "3", "location_code" => "Admin Building", "location_name" => "Admin Building", "pid" => "2", "created_at" => "2025-03-02 09:28:59", "updated_at" => "2025-03-02 09:28:59", "deleted_at" => null],
                ["id" => "4", "location_code" => "Building No. 18", "location_name" => "Building No. 18", "pid" => "2", "created_at" => "2025-03-02 09:29:11", "updated_at" => "2025-03-02 09:29:11", "deleted_at" => null],
                ["id" => "5", "location_code" => "Building No. 12", "location_name" => "Building No. 12", "pid" => "2", "created_at" => "2025-03-02 09:30:20", "updated_at" => "2025-03-02 09:30:20", "deleted_at" => null],
                ["id" => "6", "location_code" => "Building No. 13", "location_name" => "Building No. 13", "pid" => "2", "created_at" => "2025-03-02 09:30:32", "updated_at" => "2025-03-02 09:30:32", "deleted_at" => null],
                ["id" => "7", "location_code" => "Building No. 11", "location_name" => "Building No. 11", "pid" => "2", "created_at" => "2025-03-02 09:31:51", "updated_at" => "2025-03-02 09:31:51", "deleted_at" => null],
                ["id" => "8", "location_code" => "Building No. 9", "location_name" => "Building No. 9", "pid" => "2", "created_at" => "2025-03-02 09:32:04", "updated_at" => "2025-03-02 09:32:04", "deleted_at" => null],
                ["id" => "9", "location_code" => "Building No. 17", "location_name" => "Building No. 17", "pid" => "2", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "10", "location_code" => "Alabang", "location_name" => "Alabang", "pid" => "1", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "11", "location_code" => "Powerhouse 1", "location_name" => "Powerhouse 1", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "12", "location_code" => "Powerhouse 2", "location_name" => "Powerhouse 2", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "13", "location_code" => "Powerhouse 3", "location_name" => "Powerhouse 3", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "14", "location_code" => "Powerhouse 4", "location_name" => "Powerhouse 4", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],
                ["id" => "15", "location_code" => "Powerhouse 5", "location_name" => "Powerhouse 5", "pid" => "3", "created_at" => "2025-03-02 09:32:30", "updated_at" => "2025-03-02 09:32:30", "deleted_at" => null],


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
