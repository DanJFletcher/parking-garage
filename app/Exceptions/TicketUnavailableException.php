<?php

namespace App\Exceptions;

use Exception;

class TicketUnavailableException extends Exception
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
                    'title' => 'Ticket Unavailable Exception',
                    'description' =>
                        'A ticket could not be issued because there are no parking spaces available in the garage.'
                ],
            ],
            'status' => '409'
        ], 409);
    }
}
