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

// Route::get('/', function () {
//     return view('forms-view');
// });
Route::get('/', 'FormController@view');
Route::get('forms/view/{id}', 'FormController@viewFormDetail');

Route::group(['prefix' => 'admin/forms'], function () {
    Route::get('/', 'FormController@index');
    Route::get('/add', 'FormController@add');
    Route::post('/create', 'FormController@createForm');
    Route::get('/edit/{id}', 'FormController@editForm');
    Route::delete('/delete/{id}', 'FormController@deleteForm');
    Route::delete('/controls/delete/{id}', 'FormController@deleteFormControl');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
