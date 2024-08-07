<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);
        $admin->assignRole('admin');

        $cashier = User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@example.com',
        ]);
        $cashier->assignRole('cashier');

        $owner = User::factory()->create([
            'name' => 'Pemilik',
            'email' => 'pemilik@example.com',
        ]);
        $owner->assignRole('owner');
    }
}
