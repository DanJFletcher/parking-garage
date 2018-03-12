<?php

namespace App;

use App\Payment;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /**
     * Ticket has one payment.
     *
     * @return \Illuinate\Database\Eloquent\Relations\HasOne
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
