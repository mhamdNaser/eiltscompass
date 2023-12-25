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
        $users = [
            [
                'first_name' => 'Muhammed',
                'last_name' => 'Nasser',
                'email' => 'naser@simulat.com',
                'country' => 'Eygpt',
                'password' => Hash::make('Naser?2023'),
                'image' => 'user.png',
                'phone' => '0777777777',
                'role' => 'developer',
                'status' => 'active',
                'is_activated' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'ahmad@simulat.com',
                'country' => 'Eygpt',
                'password' => Hash::make('Naser?2023'),
                'image' => 'user.png',
                'phone' => '0777777777',
                'role' => 'super admin',
                'status' => 'active',
                'is_activated' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Ahmad',
                'last_name' => 'Salem',
                'email' => 'ahmad.salem@simulat.com',
                'country' => 'Eygpt',
                'password' => Hash::make('Salem?2023'),
                'image' => 'user.png',
                'phone' => '0777777777',
                'role' => 'super admin',
                'status' => 'active',
                'is_activated' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach($users as $user) {
            User::create($user);
        }
    }
}
