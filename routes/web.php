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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function(){
    return view('landing.index');
});


Route::get('login','HomeController@login');
Route::get('dataOrder', 'HomeController@users');
Route::get('loginPost', 'HomeController@loginPost');
Route::get('home','HomeController@index');
Route::get('pendingOrder','HomeController@pending');
Route::get('history','HomeController@history');
Route::get('report','HomeController@report');
Route::get('reportDetail','HomeController@reportDetail');

Route::get('logout','HomeController@logout');


