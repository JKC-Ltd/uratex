<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserTypeLocation;

class UserTypeLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            ['id' => 1, 'user_type_id' => '1','locations_list' => '1'],
            ['id' => 2, 'user_type_id' => '2','locations_list' => '1'],
        ];

        foreach ($value as $item) {
            UserTypeLocation::updateOrCreate(
                ['id' => $item['id']],
                ['user_type_id' => $item['user_type_id'],
                'locations_list' => $item['locations_list']]
            );
        }
    }
}
