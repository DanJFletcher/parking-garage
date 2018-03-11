<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreatePaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_payment_with_ticket_number_and_credit_card()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->json('post', "api/pay{$ticket->id}");

        $response->assertStatus(201);
    }
}
