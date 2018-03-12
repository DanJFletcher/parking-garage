<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Resources\PaymentResource;
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
    public function store(Request $request)
    {
        $payment = Payment::create($request->all());

        Redis::incr('available_tickets');

        return PaymentResource::make($payment);
    }
}
