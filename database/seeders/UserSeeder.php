<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $value = [
            [
                'id'        => 1,
                'firstname' => 'Admin',
                'lastname'  => 'Admin',
                'email'     => 'admin@smartpowerph.com',
                'password'  =>  Hash::make('SmartPower123'),
                'user_type_id' => 1
            ],
        ];

        foreach ($value as $item) {
            User::updateOrCreate(
                ['id' => $item['id']],
                [
                    'firstname' => $item['firstname'],
                    'lastname'  => $item['lastname'],
                    'email'     => $item['email'],
                    'password'  => $item['password'],
                    'user_type_id' => $item['user_type_id']
                ]

            );
        }
      
    }
}
