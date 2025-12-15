<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserType;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            ['id' => 1, 'name' => 'Admin'],
            ['id' => 2, 'name' => 'User']
        ];

        foreach ($value as $item) {
            UserType::updateOrCreate(
                ['id' => $item['id']],
                ['name' => $item['name']]
            );
        }
    }
}
