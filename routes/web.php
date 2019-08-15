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

Route::get('/', 'TaskController@index');
Route::get('/all', 'TaskController@all');
Route::get('/create', 'TaskController@create');
Route::get('/tasks/{task}', 'TaskController@show');

// add a job
Route::post('/tasks', 'TaskController@store');
//edit a job
Route::get('/tasks/{task}/edit', 'TaskController@edit');
//update a job
Route::patch('/tasks/{task}', 'TaskController@update');

Auth::routes();
