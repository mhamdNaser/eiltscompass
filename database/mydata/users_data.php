<?php

use Illuminate\Support\Facades\Hash;

return [
    [
        'first_name' => 'Muhammed',
        'last_name' => 'Nasser',
        'email' => 'naser@simulat.com',
        'country' => 'Eygpt',
        'password' => Hash::make('Naser?2023'),
        'image' => 'user.png',
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
        'role' => 'super admin',
        'status' => 'active',
        'is_activated' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ]
];
