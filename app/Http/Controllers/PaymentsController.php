<?php

namespace App\Http\Controllers;

use App\Payment;
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
            $amountDue = '300';
        }

        $payment = Payment::create($request->all() + ['amount' => $amountDue]);

        Redis::incr('available_tickets');

        return PaymentResource::make($payment);
    }
}
