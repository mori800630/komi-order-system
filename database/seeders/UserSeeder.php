<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = Department::all()->keyBy('code');

        $users = [
            [
                'name' => 'システム管理者',
                'email' => 'admin@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'department_id' => null,
            ],
            [
                'name' => '店舗担当者',
                'email' => 'store@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'store',
                'department_id' => null,
            ],
            [
                'name' => '洋菓子製造担当',
                'email' => 'western@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturing',
                'department_id' => $departments['western_confectionery']->id ?? null,
            ],
            [
                'name' => 'サンドイッチ製造担当',
                'email' => 'sandwich@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturing',
                'department_id' => $departments['sandwich']->id ?? null,
            ],
            [
                'name' => 'パン製造担当',
                'email' => 'bread@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturing',
                'department_id' => $departments['bread']->id ?? null,
            ],
            [
                'name' => 'チーズケーキ製造担当(本店)',
                'email' => 'cheesecake_main@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturing',
                'department_id' => $departments['cheesecake_main']->id ?? null,
            ],
            [
                'name' => 'チーズケーキ製造担当(南国店)',
                'email' => 'cheesecake_nangoku@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'manufacturing',
                'department_id' => $departments['cheesecake_nangoku']->id ?? null,
            ],
            [
                'name' => '運送担当',
                'email' => 'logistics@komi-bakery.com',
                'password' => Hash::make('password'),
                'role' => 'logistics',
                'department_id' => null,
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
