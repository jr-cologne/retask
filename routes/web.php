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

Route::get('/task/{task}/edit', 'TaskController@edit')->name('task.edit');

Route::patch('/task/{task}', 'TaskController@update')->name('task.update');

Route::delete('/task/{task}', 'TaskController@destroy')->name('task.destroy');

Route::get('/lists', 'ListController@index')->name('list.index');

Route::get('/list/{list}', 'ListController@show')->name('list.show');

Route::post('/list', 'ListController@store')->name('list.store');

Route::delete('/list/{list}', 'ListController@destroy')->name('list.destroy');

Auth::routes([ 'verify' => true ]);

Route::group([ 'prefix' => '/account', 'namespace' => 'Account' ], function () {
    Route::get('/', 'AccountController@index')->name('account.index');

    Route::get('/edit', 'EditAccountController@index')->name('account.edit');

    Route::patch('/update', 'EditAccountController@update')->name('account.update');

    Route::get('/delete', 'DeleteAccountController@index')->name('account.delete');

    Route::delete('/destroy', 'DeleteAccountController@destroy')->name('account.destroy');
});
