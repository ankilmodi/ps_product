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


Route::get('/','HomeController@index')->name('home');


/*Address Book route start */

Route::resource('/user','UserController');

Route::post('/user-datatable','UserController@userDatatable')->name('userDatatable');
Route::post('/city-list','UserController@cityList')->name('cityList');

/*Address Book route end */



