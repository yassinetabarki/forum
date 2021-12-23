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

//Route::resource('threads','ThreadsController');
Route::get('threads','ThreadsController@index');
Route::get('threads/{channel}/{thread}','ThreadsController@show');
Route::get('threads/create','ThreadsController@create');
Route::post('threads','ThreadsController@store');
Route::get('threads/{channel}','ThreadsController@index');
Route::delete('threads/{channel}/{thread}','ThreadsController@destroy');
Route::post('/threads/{channel}/{thread}/replies','ReplysController@store');

Route::get('/threads/{channel}/{thread}/replies','ReplysController@index');

Route::patch('/replies/{reply}','ReplysController@update');
Route::delete('/replies/{reply}','ReplysController@destroy');
Route::post('/replies/{reply}/favorites','FavoritesController@store');
Route::delete('/replies/{reply}/favorites','FavoritesController@destroy');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}','ProfilesController@show');
