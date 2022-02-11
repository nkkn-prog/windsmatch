<?php

use App\Events\MessageNotice;

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

Route::group(['middleware'=>'auth'], function(){
Route::get('/', 'UserController@welcome');
Route::get('/profile/{profile}/show', 'UserController@show');
Route::post('/profile/{profile}/show', 'UserController@show');
Route::get('/index', 'UserController@index');
Route::POST('/index/search', 'UserController@search');
Route::get('/profile/create', 'UserController@create');
Route::post('/profile/complete', 'UserController@store');
Route::get('/profile/{profile}/edit', 'UserController@edit');
Route::post('/profile/{profile}/update', 'UserController@update');
Route::post('/profile/search', 'UserController@search');
Route::get('/chat/{user}', 'ChatController@index');
// Route::get('/chat/{user}', function () {
//     event(new MessageNotice);});
Route::post('/chat/{user}', 'ChatController@store');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('login/google', 'Auth\LoginController@redirectToGoogle');
Route::get('login/google/callback', 'Auth\LoginController@handleGoogleCallback');






