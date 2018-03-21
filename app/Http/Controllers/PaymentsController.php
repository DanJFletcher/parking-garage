<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Rate;
use App\Ticket;
use App\Http\Resources\PaymentResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class PaymentsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Ticket $ticket, Request $request)
    {
        $payment = Payment::create($request->all() + ['amount' => $ticket->amount_owing]);

        $ticket->payment()->save($payment);

        Redis::incr('available_tickets');

        return PaymentResource::make($payment);
    }
}
