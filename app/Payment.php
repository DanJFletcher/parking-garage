<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ticket;

class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'credit_card_number',
        'credit_card_exp',
        'credit_card_csv',
        'credit_card_name',
        'amount',
    ];

    /**
     * Payment belongs to ticket.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
