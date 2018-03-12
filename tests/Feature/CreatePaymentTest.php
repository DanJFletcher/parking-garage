<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class CreatePaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_payment_with_ticket_number_and_credit_card()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->json('post', "api/pay/{$ticket->id}", [
            'credit_card_number' => '4242424242424242',
            'credit_card_exp' => '09/22',
            'credit_card_csv' => '123',
            'credit_card_name' => 'Jim Bean',
            'amount' => '600',
        ]);

        $response->assertStatus(201);
    }

    /** @test */
    public function new_payment_will_add_available_space_to_garage()
    {
        Redis::set('available_tickets', 0);

        $ticket = factory(Ticket::class)->create();

        $response = $this->json('post', "api/pay/{$ticket->id}", [
            'credit_card_number' => '4242424242424242',
            'credit_card_exp' => '09/22',
            'credit_card_csv' => '123',
            'credit_card_name' => 'Jim Bean',
            'amount' => '600',
        ]);

        $response->assertStatus(201);

        $this->assertEquals(Redis::get('available_tickets'), '1');
    }
}
