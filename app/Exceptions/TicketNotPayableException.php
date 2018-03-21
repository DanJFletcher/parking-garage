<?php

namespace App\Exceptions;

use Exception;

class TicketNotPayableException extends Exception
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render()
    {
        return response()->json([
            'errors' => [
                [
                    'title' => 'Ticket Not Payable Exception',
                    'description' =>
                        'This ticket has already been paid.'
                ],
            ],
            'status' => '409'
        ], 409);
    }
}
