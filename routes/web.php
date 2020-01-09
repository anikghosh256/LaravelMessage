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
Route::get('/messenger', 'HomeController@messenger')->name('messenger');
Route::get('/contacts', 'MessageController@getContact')->name('contacts');
Route::get('/getMessages/{id}', 'MessageController@getMessages')->name('getMessages');
Route::post('/message/send', 'MessageController@sendMess')->name('sendMess');


Route::get('/chagnePassword', 'UserController@chagnePassword')->name('chagnePassword');
Route::post('/updatePassword', 'UserController@updatePassword')->name('updatePassword');
Route::get('editDetails', 'UserController@editUserDetails')->name('editDetails');
Route::post('updateDetails', 'UserController@updateDetails')->name('updateDetails');
