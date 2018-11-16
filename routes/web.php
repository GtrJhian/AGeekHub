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
Route::get('/sin/{x}/{n}/{d}','MaclaurinSeriesController@sin');
Route::get('/cos/{x}/{n}/{d}','MaclaurinSeriesController@cos');
Route::get('/ln_x_plus_1/{x}/{n}/{d}','MaclaurinSeriesController@ln_x_plus_1');
