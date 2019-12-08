<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//

Route::get('/searchFlights', function () {return view('search');});
Route::get('/addFlights', function () {return view('addFlights');});
Route::get('/booking', function () {return view('booking');});
Route::get('/transactions', function () {return view('transactions');});
Route::get('/tracking', function () {return view('tracking');});
