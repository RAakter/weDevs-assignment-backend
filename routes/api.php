<?php

use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ProductController;
use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "Api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductController::class,'index']);
    Route::get('/products/{product}', [ProductController::class,'show']);
    Route::post('register', [UserController::class, 'register']);
    Route::post('login', [UserController::class, 'login']);

    Route::post('order/list', [UserController::class, 'index']);
    Route::post('users', [UserController::class, 'show']);
    Route::post('orders', [UserController::class, 'showOrders']);

    route::apiResource('order', 'OrderController')->except('update');
    route::post('order/update/{order}', [OrderController::class, 'update']);
    route::post('order/status/{order}', [OrderController::class, 'statusUpdate']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout',  [UserController::class, 'logout']);
        Route::apiResource('/products', 'ProductController')->except(['index','show','update']);
        Route::post('products/update/{product}', [ProductController::class,'update']);



    });
});
