<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1 fixed admin
        User::factory()->create([
            'name' => 'System Admin',
            'email' => 'admin@example.com',
            'phone' => '09123456789',
            'role' => UserRole::Admin,
            'password' => Hash::make('Userpass@pmslocal'),
        ]);

        // Remaining: 2 admins, 3 managers, 5 users
        User::factory()->count(2)->admin()->create();
        User::factory()->count(3)->manager()->create();
        User::factory()->count(5)->user()->create();
    }
}
