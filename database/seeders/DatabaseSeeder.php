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
    // Créer un hôpital
    $hopital = \App\Models\Hopital::create([
        'nom' => 'Clinique Espoir',
        'adresse' => 'Quartier Latin, N°12',
        'code_unique' => 'CE-01',
    ]);

    // Créer un service dans cet hôpital
    $hopital->services()->create([
        'nom' => 'Pédiatrie',
        'prefixe' => 'PED',
    ]);
}
}
