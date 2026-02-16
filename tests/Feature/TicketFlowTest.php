<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TicketFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_tickets()
    {
        $response = $this->get(route('tickets.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_receptionniste_can_create_ticket()
    {
        $user = User::factory()->create(['role' => 'receptionniste']);
        $hopital = \App\Models\Hopital::create(['nom' => 'H Test', 'adresse' => 'Rue', 'code_unique' => 'h-test']);
        $service = Service::create(['hopital_id' => $hopital->id, 'nom' => 'Test Service', 'prefixe' => 'TST']);

        $response = $this->actingAs($user)->post(route('tickets.store'), [
            'service_id' => $service->id,
            'priorite' => 0,
        ]);

        $response->assertRedirect(route('tickets.index'));
        $this->assertDatabaseCount('tickets', 1);
        $this->assertDatabaseHas('tickets', ['service_id' => $service->id]);
    }

    public function test_medecin_can_start_and_finish_ticket()
    {
        $med = User::factory()->create(['role' => 'medecin']);
        $hopital = \App\Models\Hopital::create(['nom' => 'H Test', 'adresse' => 'Rue', 'code_unique' => 'h-test']);
        $service = Service::create(['hopital_id' => $hopital->id, 'nom' => 'Test Service', 'prefixe' => 'TST']);

        $ticket = Ticket::create([
            'hopital_id' => $hopital->id,
            'service_id' => $service->id,
            'numero_ticket' => 'TST-001',
            'statut' => 'en_attente',
        ]);

        $this->actingAs($med)->post(route('tickets.start', $ticket));
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'statut' => 'en_consultation']);

        $this->actingAs($med)->post(route('tickets.finish', $ticket));
        $this->assertDatabaseHas('tickets', ['id' => $ticket->id, 'statut' => 'terminé']);
    }
}
