<?php

namespace Tests\Feature;

use App\Ticket;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;

class IndexTicketsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_see_all_tickets()
    {
        $this->withoutExceptionHandling();

        $tickets = factory(Ticket::class, 10)->create();

        Redis::set('available_tickets', 50);

        $response = $this->json('get', "api/tickets");

        $response->assertStatus(200);
    }
}
