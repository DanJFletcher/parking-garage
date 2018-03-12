<?php

namespace App;

use App\Payment;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
