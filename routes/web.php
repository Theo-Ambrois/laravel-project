<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ChannelController@index')->name('channel-list');
Route::get('/channel/{id}', 'ChatController@index')->name('channel');
Route::get('/channel-name', 'ChannelController@getName');
Route::get('/messages', 'ChatController@fetchAllMessages');
Route::get('/users', 'ChatController@fetchAllUsers');
Route::post('/messages', 'ChatController@sendMessage');
Route::post('/add-channel', 'ChannelController@create')->name('write');
Route::get('/channel-delete/{id}', 'ChannelController@delete')->name('channel-delete');




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
