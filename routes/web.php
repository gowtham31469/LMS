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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/check-in', 'HomeController@checkIn')->name('home');
Route::post('/search-books', 'SearchController@index');
Route::post('/search-book-loans', 'SearchController@searchBookLoans');
Route::post('/check-out-books', 'SearchController@checkOut');
Route::post('/check-in-books', 'SearchController@checkIn');
