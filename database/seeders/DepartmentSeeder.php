<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => '洋菓子製造部',
                'code' => 'western_confectionery',
                'description' => 'ケーキ、タルト、クッキーなどの洋菓子を製造',
                'is_active' => true,
            ],
            [
                'name' => 'サンドイッチ製造部',
                'code' => 'sandwich',
                'description' => 'サンドイッチ、パニーニなどを製造',
                'is_active' => true,
            ],
            [
                'name' => 'パン製造部',
                'code' => 'bread',
                'description' => '食パン、菓子パン、フランスパンなどを製造',
                'is_active' => true,
            ],
            [
                'name' => 'チーズケーキ製造部(本店)',
                'code' => 'cheesecake_main',
                'description' => '本店のチーズケーキを製造',
                'is_active' => true,
            ],
            [
                'name' => 'チーズケーキ製造部(南国店)',
                'code' => 'cheesecake_nangoku',
                'description' => '南国店のチーズケーキを製造',
                'is_active' => true,
            ],
        ];

        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
