<?php

namespace Tests\Unit;

use App\Rate;
use App\Ticket;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_amount_owing_from_ticket()
    {
        $ticket = factory(Ticket::class)->make();

        $this->assertTrue($ticket->amount_owing !== null);
    }

    /** @test */
    public function amount_owing_equals_one_hour_rate()
    {
        $ticket = factory(Ticket::class)->make();

        $this->assertEquals($ticket->amount_owing, Rate::ONE_HOUR);
    }

    /** @test */
    public function amount_owing_equals_three_hour_rate()
    {
        $ticket = factory(Ticket::class)->make([
            'created_at' => Carbon::now()->subHours(3)
        ]);

        $this->assertEquals($ticket->amount_owing, Rate::THREE_HOUR);
    }

    /** @test */
    public function amount_owing_equals_six_hour_rate()
    {
        $ticket = factory(Ticket::class)->make([
            'created_at' => Carbon::now()->subHours(6)
        ]);

        $this->assertEquals($ticket->amount_owing, Rate::SIX_HOUR);
    }

    /** @test */
    public function amount_owing_equals_all_day_hour_rate()
    {
        $ticket = factory(Ticket::class)->make([
            'created_at' => Carbon::now()->subHours(7)
        ]);

        $this->assertEquals($ticket->amount_owing, Rate::ALL_DAY);
    }
}
