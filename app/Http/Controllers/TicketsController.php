<?php

namespace App\Http\Controllers;

use App\Ticket;
use App\Http\Resources\TicketResource;
use App\Exceptions\TicketUnavailableException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class TicketsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Redis::get('available_tickets') === '0') {
            throw new TicketUnavailableException;
        }

        $ticket = Ticket::create();

        Redis::decr('available_tickets');

        return new TicketResource($ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }
}
