<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database. Création de l'espace patient
     */
public function run(): void
{
    \App\Models\User::create([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => bcrypt('admin'), // Ton mot de passe sera 'password'
        'role' => 'admin_global',        // Très important pour ton ServiceController
    ]);
}
}
