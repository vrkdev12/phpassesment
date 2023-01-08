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


// route to show router page
Route::get('/router', 'RouterController@index')->name('router.index');
Route::post('/router', 'RouterController@store')->name('router.store');

// upload bulk into database
Route::post('/router-store-all', 'RouterController@storeAll')->name('router.store.all');