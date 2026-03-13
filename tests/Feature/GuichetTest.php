<?php

namespace Tests\Feature;

use App\Models\Guichet;
use App\Models\Hopital;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuichetTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_hopital_can_create_guichet(): void
    {
        $hopital = Hopital::create(['nom' => 'Hôpital test', 'adresse' => 'xxx', 'code_unique' => 'TEST-1', 'configuration' => []]);
        $service = Service::create(['hopital_id' => $hopital->id, 'nom' => 'Service test', 'prefixe' => 'TST']);
        $user = User::factory()->create([
            'role' => 'admin_hopital',
            'hopital_id' => $hopital->id,
        ]);

        $response = $this->actingAs($user)->post(route('guichets.store'), [
            'hopital_id' => $hopital->id,
            'service_id' => $service->id,
            'nom' => 'Guichet A',
            'est_ouvert' => 1,
        ]);

        $response->assertRedirect(route('guichets.index'));
        $this->assertDatabaseHas('guichets', ['nom' => 'Guichet A', 'hopital_id' => $hopital->id]);
    }

    public function test_medecin_can_create_guichet_for_own_service(): void
    {
        $hopital = Hopital::create(['nom' => 'Hôpital test', 'adresse' => 'yyy', 'code_unique' => 'TEST-2', 'configuration' => []]);
        $service = Service::create(['hopital_id' => $hopital->id, 'nom' => 'Service test 2', 'prefixe' => 'TS2']);
        $user = User::factory()->create([
            'role' => 'medecin',
            'hopital_id' => $hopital->id,
            'service_id' => $service->id,
        ]);

        $response = $this->actingAs($user)->post(route('guichets.store'), [
            'nom' => 'Guichet B',
            'est_ouvert' => 0,
        ]);

        $response->assertRedirect(route('guichets.index'));
        $this->assertDatabaseHas('guichets', ['nom' => 'Guichet B', 'service_id' => $service->id]);
    }
}
