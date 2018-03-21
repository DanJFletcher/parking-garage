<?php

namespace App;

use App\Rate;
use App\Payment;
use Carbon\Carbon;
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

    public function getAmountOwingAttribute()
    {
        if ($this->created_at->diffInHours(Carbon::Now()) <= 1) {
            return Rate::ONE_HOUR;
        }

        if (
            $this->created_at->diffInHours(Carbon::Now()) > 1 &&
            $this->created_at->diffInHours(Carbon::Now()) <= 3
        ) {
            return Rate::THREE_HOUR;
        }

        if (
            $this->created_at->diffInHours(Carbon::Now()) > 3 &&
            $this->created_at->diffInHours(Carbon::Now()) <= 6
        ) {
            return Rate::SIX_HOUR;
        }

        return Rate::ALL_DAY;
    }
}
