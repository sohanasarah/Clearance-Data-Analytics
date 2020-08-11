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

Auth::routes();

Route::get('/', 'Users\DashboardController@index')->name('dashboard');

Route::resource('manufacturer','Users\ManufacturerController');
Route::resource('segment','Users\SegmentController');
Route::resource('brand','Users\BrandController');
Route::resource('calendar','Users\CalendarController');
Route::resource('item','Users\ItemController');
Route::resource('deposit','Users\DepositController');
Route::resource('clearance','Users\ClearanceController');

//ImportExportController
Route::get('import', 'Users\ImportExportController@importExportView');
Route::post('import', 'Users\ImportExportController@import')->name('import');