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
        // Création d'un hôpital de démonstration + services/guichets
        $hopital = \App\Models\Hopital::create([
            'nom' => 'Hôpital Central',
            'adresse' => '1 Rue de la Santé',
            'code_unique' => 'hopital-central',
            'configuration' => json_encode(['announce' => true]),
        ]);

        $ped = \App\Models\Service::create(['hopital_id' => $hopital->id, 'nom' => 'Pédiatrie', 'prefixe' => 'PED']);
        $oph = \App\Models\Service::create(['hopital_id' => $hopital->id, 'nom' => 'Ophtalmologie', 'prefixe' => 'OPH']);

        \App\Models\Guichet::create(['hopital_id' => $hopital->id, 'nom' => 'Guichet A', 'est_ouvert' => true]);
        \App\Models\Guichet::create(['hopital_id' => $hopital->id, 'nom' => 'Guichet B', 'est_ouvert' => false]);

        // Utilisateurs de démonstration
        \App\Models\User::factory()->create([
            'name' => 'Admin Global',
            'email' => 'admin@example.com',
            'role' => 'admin_global',
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Resp. Hôpital',
            'email' => 'adminhop@example.com',
            'role' => 'admin_hopital',
            'hopital_id' => $hopital->id,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Dr. Pierre',
            'email' => 'medecin@example.com',
            'role' => 'medecin',
            'hopital_id' => $hopital->id,
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Réceptionniste',
            'email' => 'reception@example.com',
            'role' => 'receptionniste',
            'hopital_id' => $hopital->id,
        ]);

        // Tickets exemples
        \App\Models\Ticket::create([
            'hopital_id' => $hopital->id,
            'service_id' => $ped->id,
            'numero_ticket' => \App\Models\Ticket::generateNumeroForService($ped),
            'priorite' => 0,
            'statut' => 'en_attente',
        ]);

        \App\Models\Ticket::create([
            'hopital_id' => $hopital->id,
            'service_id' => $oph->id,
            'numero_ticket' => \App\Models\Ticket::generateNumeroForService($oph),
            'priorite' => 1,
            'statut' => 'en_attente',
        ]);
    }
}
