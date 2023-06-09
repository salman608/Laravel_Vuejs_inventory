<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\PosController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\SalaryController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});
// Route::apiResource('/employee', [EmployeeController::class]);
Route::apiResource('employee', EmployeeController::class);
Route::apiResource('supplier', SupplierController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('product', ProductController::class);
Route::apiResource('expense', ExpenseController::class);

//===Salary Route
Route::post('salary/paid/{id}', [SalaryController::class, 'paid']);
Route::get('salary', [SalaryController::class, 'AllSalary']);
Route::get('salary/view/{id}', [SalaryController::class, 'ViewSalary']);
Route::get('edit/salary/{id}', [SalaryController::class, 'EditSalary']);
Route::post('salary/update/{id}', [SalaryController::class, 'UpdateSalary']);

//===stock Route
Route::post('stock/update/{id}', [ProductController::class, 'stockUpdate']);

//===Customer Route
Route::apiResource('customer', CustomerController::class);

Route::get('getting/product/{id}', [PosController::class, 'getProduct']);

//===Cart Route
Route::Get('/addToCart/{id}', [CartController::class, 'AddToCart']);
Route::Get('/cart/product', [CartController::class, 'CartProduct']);
Route::Get('/remove/cart/{id}', [CartController::class, 'removeCart']);
Route::Get('/increment/{id}', [CartController::class, 'Increment']);
Route::Get('/decrement/{id}', [CartController::class, 'Decrement']);

//===Vat route
Route::Get('/vats', [CartController::class, 'VatS']);

//===Order Route

Route::Post('/order/complete', [PosController::class, 'OrderComplete']);
Route::Get('/orders', [OrderController::class, 'TodayOrder']);
Route::Get('/orders/details/{id}', [OrderController::class, 'OrderDetails']);
Route::Get('/order/orderdetails/{id}', [OrderController::class, 'OrderDetailsAll']);
Route::Post('/search/order', [OrderController::class, 'SearchOrder']);

//===Admin Dashboard Route
Route::Get('/today/sell/', [PosController::class, 'TodaySell']);
Route::Get('/today/income/', [PosController::class, 'TodayIncome']);
Route::Get('/today/due/', [PosController::class, 'TodayDue']);
Route::Get('/today/expense/', [PosController::class, 'TodayExpense']);
Route::Get('/today/stockout/', [PosController::class, 'TodayStockout']);
