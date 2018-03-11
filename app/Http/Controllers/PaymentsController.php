<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Request;

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

        return new PaymentResource($payment);
    }
}
