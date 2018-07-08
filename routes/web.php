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

Route::get('/tasks', 'TaskController@index')->name('tasks.index');

Route::post('/task', 'TaskController@store')->name('tasks.store');

Route::delete('/task/{task}', 'TaskController@destroy')->name('tasks.destroy');

Auth::routes();
