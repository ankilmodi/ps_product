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

/*Categaory Route Start */

Route::get('/category-list','CategoryController@index')->name('categoryList');
Route::get('/category-create','CategoryController@create')->name('categoryCreate');
Route::post('/category-create','CategoryController@store')->name('categoryStore');
Route::post('/category-datatable', 'CategoryController@categoryDatatable')->name('categoryDatatable');
Route::get('/category-edit/{id}','CategoryController@edit')->name('categoryEdit');
Route::post('/category-update/{id}','CategoryController@update')->name('categoryUpdate');
Route::get('/category-delete/{id}','CategoryController@destroy')->name('categoryDelete');

/*Categaory Route End */

/*Product Route Start */

Route::get('/product-list','ProductController@index')->name('productList');
Route::get('/product-create','ProductController@create')->name('productCreate');
Route::post('/product-create','ProductController@store')->name('productStore');
Route::post('/product-datatable', 'ProductController@productDatatable')->name('productDatatable');
Route::get('/product-edit/{id}','ProductController@edit')->name('productEdit');
Route::post('/product-update/{id}','ProductController@update')->name('productUpdate');
Route::get('/product-delete/{id}','ProductController@destroy')->name('productDelete');

/*Product Route End */

/*Report 1 Route Start */

Route::get('/report-product-count','ReportController@index')->name('reportProductCount');
Route::post('/report-product-coun-datatable','ReportController@reportProductCountDatatable')->name('reportProductCountDatatable');

/*Report 1 Route End */

/*Report 2 Route Start */

Route::get('/report-product-max-price','ReportController@indexMaxPrice')->name('reportProductMaxPrice');
Route::post('/report-product-max-price-datatable','ReportController@reportProductMaxPriceDatatable')->name('reportProductMaxPriceDatatable');

/*Report 2 Route End */


