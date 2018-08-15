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
})->name('welcome');

Route::get('/tasks', 'TaskController@index')->name('task.index');

Route::post('/task', 'TaskController@store')->name('task.store');

Route::delete('/task/{task}', 'TaskController@destroy')->name('task.destroy');

Route::get('/lists', 'ListController@index')->name('list.index');

Route::get('/list/{list}', 'ListController@show')->name('list.show');

Route::post('/list', 'ListController@store')->name('list.store');

Route::delete('/list/{list}', 'ListController@destroy')->name('list.destroy');

Auth::routes();

Route::get('/auth/activate', 'Auth\ActivationController@activate')->name('auth.activate');

Route::get('/auth/activate/resend', 'Auth\ActivationResendController@showResendForm')->name('auth.activate.resend');

Route::post('/auth/activate/resend', 'Auth\ActivationResendController@resend')->name('auth.activate.resend');
