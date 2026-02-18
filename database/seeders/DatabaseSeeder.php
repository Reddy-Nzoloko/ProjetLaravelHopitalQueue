<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
  public function run(): void
{
    // 1. Créer un hôpital de test
    $hopital = \App\Models\Hopital::create([
        'nom' => 'Hôpital Général',
        'code_unique' => 'HG-001',
        'adresse' => 'Butembo, RDC'
    ]);

    // 2. Créer un Admin pour cet hôpital
    \App\Models\User::create([
        'name' => 'Admin Hopital',
        'email' => 'admin@hopital.com',
        'password' => bcrypt('password'),
        'role' => 'admin_hopital',
        'hopital_id' => $hopital->id,
    ]);

    // 3. Créer un Super Admin
    \App\Models\User::create([
        'name' => 'Super Admin',
        'email' => 'super@system.com',
        'password' => bcrypt('password'),
        'role' => 'super_admin',
        'hopital_id' => null,
    ]);
}
}
