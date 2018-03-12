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
        $amountDue = '0';

        if ($ticket->created_at->diffInHours(Carbon::Now()) < 1) {
            $amountDue = Rate::ONE_HOUR;
        } elseif (
            $ticket->created_at->diffInHours(Carbon::Now()) >= 1 &&
            $ticket->created_at->diffInHours(Carbon::Now()) < 3
        ) {
            $amountDue = Rate::THREE_HOUR;
        } elseif (
            $ticket->created_at->diffInHours(Carbon::Now()) >= 3 &&
            $ticket->created_at->diffInHours(Carbon::Now()) < 6
        ) {
            $amountDue = Rate::SIX_HOUR;
        }

        $payment = Payment::create($request->all() + ['amount' => $amountDue]);

        $ticket->payment()->save($payment);

        Redis::incr('available_tickets');

        return PaymentResource::make($payment);
    }
}
