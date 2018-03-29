<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class CreateTicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function creating_customer_returns_ticket_number()
    {
        Redis::set('available_tickets', 50);

        $response = $this->json('post', route('tickets.store'));

        $response
            ->assertStatus(201)
            ->assertJsonStructure(['*' => ['ticket_number']])
            ->assertJson(['data' => ['available_tickets' => '49']]);
    }

    /** @test */
    public function status_409_is_returned_if_no_parking_spaces_are_available()
    {
        Redis::set('available_tickets', 0);

        $response = $this->json('post', route('tickets.store'));

        $response
            ->assertStatus(409)
            ->assertJsonStructure(['errors']);
    }
}
