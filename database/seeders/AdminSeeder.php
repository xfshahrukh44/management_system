<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Admin
        User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@82solutions.com',
            'password' => Hash::make('temp'),
            'type' => 'Admin'
        ]);
    }
}
