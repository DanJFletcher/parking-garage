<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShowTicketTest extends TestCase
{
    /** @test */
    public function can_show_ticket_if_exists()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->json('post', "tickets/{$ticket->id}");

        $response->assertStatus(200);
    }
}
