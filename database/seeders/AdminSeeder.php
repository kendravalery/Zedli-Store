<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleadmin = Role::where('name', 'admin')->first();

        if (!$roleadmin) {
            return;
        }

        User::firstOrCreate(
            [
                'email' => 'admin@gmail.com',
            ],
            [
                'name' => 'penjual utama',
                'password' => Hash::make('123'),
                'role_id' => $roleadmin->id,
            ],
        );
    }
}
