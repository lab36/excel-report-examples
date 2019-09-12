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

Route::get('/daily-construction','Controller@exportDailyConstruction')->name('daily-construction.export');
Route::get('/job-estimate','Controller@exportJobEstimate')->name('job-estimate.export');
Route::get('/sales','Controller@exportSales')->name('sales.export');
Route::get('/orders','Controller@exportOrders')->name('orders.export');
Route::get('/monthly-sales.export','Controller@exportMonthlySales')->name('monthly-sales.export');
