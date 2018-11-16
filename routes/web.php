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
Route::get('/Maclaurin/sin/{x}/{n}/{d}/{a?}','MaclaurinSeriesController@sin');
Route::get('/Maclaurin/cos/{x}/{n}/{d}/{a?}','MaclaurinSeriesController@cos');
Route::get('/Maclaurin/ln_x_plus_1/{x}/{n}/{d}/{a?}','MaclaurinSeriesController@ln_x_plus_1');
Route::get('/desmos',function(){
    return view('desmos');
});