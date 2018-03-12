<?php

namespace App;

use Ticket;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'credit_card_number',
        'credit_card_exp',
        'credit_card_csv',
        'credit_card_name',
        'amount',
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
