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
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // creation des hopitaux
        \App\Models\Hopital::create([
        'nom' => 'Hôpital Général de Référence',
        'code_unique' => 'HGR-01',
        'adresse' => 'Avenue de la Paix'
    ]);
    }
}
