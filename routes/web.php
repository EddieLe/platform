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

Route::get('bbin/login', function () {
    return view('login');
});

Route::get('bbin/register', function () {
    return view('register');
});

Route::post('/user/login', 'LoginController@login');
Route::get('/platform', 'LoginController@platform')->name('platform')->middleware('login');
Route::post('/transfer', 'LoginController@transferPoint')->middleware('login');
Route::get('/bbin/logout', 'LoginController@logout');
//Route::get('/create', 'LoginController@createPaltformUser')->middleware('login');
Route::post('/createUser', 'LoginController@createUser');
