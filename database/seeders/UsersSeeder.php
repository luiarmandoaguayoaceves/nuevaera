<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'  => 'Admin Nueva Era',
                'email' => 'admin@nuevaera.test',
                'password' => 'password123',
            ],
            [
                'name'  => 'Editor Galería',
                'email' => 'editor@nuevaera.test',
                'password' => 'password123',
            ],
            [
                'name'  => 'Invitado',
                'email' => 'invitado@nuevaera.test',
                'password' => 'password123',
            ],
        ];

        foreach ($users as $u) {
            User::updateOrCreate(
                ['email' => $u['email']],
                [
                    'name'              => $u['name'],
                    'email_verified_at' => now(),
                    'password'          => Hash::make($u['password']),
                    'remember_token'    => Str::random(10),
                    // Si tienes un campo is_admin o role, puedes setearlo aquí.
                ]
            );
        }
    }
}
