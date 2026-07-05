<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Branch;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $value = [
            [
                'id'        => 1,
                'name' => 'Alabang',
                'branch_code'  => 'ALB',
            ],
             [
                'id'        => 2,
                'name' => 'Plaridel',
                'branch_code'  => 'PLR',
            ],
             [
                'id'        => 3,
                'name' => 'Valenzuela',
                'branch_code'  => 'VLZ',
            ],
        ];

        foreach ($value as $item) {
            Branch::updateOrCreate(
                ['id' => $item['id']],
                [
                    'name' => $item['name'],
                    'branch_code' => $item['branch_code']
                ]

            );
        }
    }
}
