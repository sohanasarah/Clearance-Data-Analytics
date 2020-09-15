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

Route::get('/', 'Master\DashboardController@index')->name('dashboard');

Route::resource('manufacturer','Master\ManufacturerController');
Route::resource('segment','Master\SegmentController');
Route::resource('brand','Master\BrandController');
Route::resource('calendar','Master\CalendarController');
Route::resource('item','Master\ItemController');
Route::resource('deposit','Master\DepositController');
Route::resource('clearance','Master\ClearanceController');
Route::post('clearance/import', 'Master\ClearanceController@import')->name('clearance.import');
Route::post('deposit/import', 'Master\DepositController@import')->name('deposit.import');
Route::post('item/import', 'Master\ItemController@import')->name('item.import');

Route::get('segment_chart', 'Charts\SegmentChartsController@index')->name('charts.segments');
