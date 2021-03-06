<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('tickets', 'TicketsController@store')->name('tickets.store');

Route::get('tickets/{ticket}', 'TicketsController@show');
Route::get('tickets', 'TicketsController@index');

Route::post('tickets/{ticket}/payments', 'TicketPaymentsController@store')->name('tickets.payments.store');
