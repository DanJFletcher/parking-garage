<?php

namespace Tests\Feature;

use App\Payment;
use App\Rate;
use App\Ticket;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use Illuminate\Foundation\Testing\TestResponse;

class CreatePaymentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_create_payment_with_ticket_number_and_credit_card()
    {
        $this->withoutExceptionHandling();
        $ticket = factory(Ticket::class)->create();

        $response = $this->payTicket($ticket);

        $response->assertStatus(201);
    }

    /** @test */
    public function new_payment_belongs_to_ticket()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->payTicket($ticket);

        $response->assertStatus(201);

        $this->assertEquals($ticket->id, Payment::find($ticket->id)->ticket_id);
    }

    /** @test */
    public function new_payment_will_add_available_space_to_garage()
    {
        Redis::set('available_tickets', 0);

        $ticket = factory(Ticket::class)->create();

        $response = $this->payTicket($ticket);

        $response->assertStatus(201);

        $this->assertEquals(Redis::get('available_tickets'), '1');
    }

    /** @test */
    public function ticket_that_is_less_than_one_hour_costs_starting_rate()
    {
        $ticket = factory(Ticket::class)->create();

        $response = $this->payTicket($ticket);

        $response->assertStatus(201)
            ->assertJson(['data' => ['amount' => Rate::ONE_HOUR]]);
    }

    /** @test */
    public function ticket_that_is_between_one_hour_and_three_hours_costs_three_hour_rate()
    {
        $ticket = factory(Ticket::class)->create([
            'created_at' => Carbon::now()->subHours(3)
        ]);

        $response = $this->payTicket($ticket);

        $response->assertStatus(201)
            ->assertJson(['data' => ['amount' => Rate::THREE_HOUR]]);
    }

    /** @test */
    public function ticket_that_is_between_three_hour_and_six_hours_costs_six_hour_rate()
    {
        $ticket = factory(Ticket::class)->create([
            'created_at' => Carbon::now()->subHours(6)
        ]);

        $response = $this->payTicket($ticket);

        $response->assertStatus(201)
            ->assertJson(['data' => ['amount' => Rate::SIX_HOUR]]);
    }

    /** @test */
    public function ticket_that_is_more_than_six_hours_costs_all_day_rate()
    {
        $ticket = factory(Ticket::class)->create([
            'created_at' => Carbon::now()->subHours(7)
        ]);

        $response = $this->payTicket($ticket);

        $response->assertStatus(201)
            ->assertJson(['data' => ['amount' => Rate::ALL_DAY]]);
    }

    /** @test */
    public function ticket_cant_be_charged_more_than_once()
    {
        $ticket = factory(Ticket::class)->create([
            'created_at' => Carbon::now()->subHours(6),
        ]);

        $payment = factory(Payment::class)->make($this->fakeCreditCardData());

        $ticket->payment()->save($payment);

        $response = $this->payTicket($ticket);

        $response->assertStatus(409)
            ->assertJsonStructure(['errors', 'status']);
    }

    private function fakeCreditCardData() : array
    {
        return [
            'credit_card_number' => '4242424242424242',
            'credit_card_exp' => '09/22',
            'credit_card_csv' => '123',
            'credit_card_name' => 'Jim Bean',
        ];
    }

    private function payTicket(Ticket $ticket) : TestResponse
    {
        return $this->json(
            'post',
            route('tickets.payments.store', $ticket),
            $this->fakeCreditCardData()
        );
    }
}
