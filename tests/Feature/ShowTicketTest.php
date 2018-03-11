<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class ShowTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_show_ticket_if_exists()
    {
        $ticket = factory(Ticket::class)->create();

        Redis::set('available_tickets', 50);

        $response = $this->json('get', "api/tickets/{$ticket->id}");

        $response->assertStatus(200)
            ->assertJsonStructure(['*' => ['ticket_number', 'created_at']])
            ->assertJson(['data' => ['ticket_number' => $ticket->id]]);
    }

    /** @test */
    public function see_404_not_found_if_not_exists()
    {
        $response = $this->json('get', "api/tickets/1000");

        $response->assertStatus(404)
            ->assertJson(['status' => '404']);
    }
}
