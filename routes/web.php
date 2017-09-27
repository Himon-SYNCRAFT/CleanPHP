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

Route::get('/', 'DashboardController@indexAction');

// Customers
Route::get('/customers', 'CustomersController@indexAction');
Route::match(
	['get', 'post'],
	'/customers/new',
	'CustomersController@newOrEditAction'
);
Route::match(
	['get', 'post'],
	'/customers/edit/{id}',
	'CustomersController@newOrEditAction'
);

// Orders
Route::get('/orders', 'OrdersController@indexAction');
Route::match(
	['get', 'post'],
	'/orders/new',
	'OrdersController@newAction'
);
Route::get('/orders/view/{id}', 'OrdersController@viewAction');

// Invoices
Route::get('/invoices', 'InvoicesController@indexAction');
Route::get('/invoices/view/{id}', 'InvoicesController@viewAction');
Route::get('/invoices/new', 'InvoicesController@newAction');
Route::post('/invoices/generate', 'InvoicesController@generateAction');
