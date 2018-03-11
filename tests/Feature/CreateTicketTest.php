<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTicketTest extends TestCase
{
    /** @test */
    public function creating_customer_returns_ticket_number()
    {
        $response = $this->json('post', 'api/customers');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['id']);
    }
}
