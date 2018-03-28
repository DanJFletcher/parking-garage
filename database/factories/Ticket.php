<?php

use App\Ticket;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
        'created_at' => Carbon::now()
    ];
});
