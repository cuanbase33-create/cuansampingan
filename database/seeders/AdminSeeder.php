<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'admin@cuanbase.com'],
            [
                'name' => 'Admin cuansampingan',
                'password' => Hash::make('password123'),
                'two_factor_secret' => null,
                'two_factor_confirmed_at' => null,
            ]
        );
    }
}
