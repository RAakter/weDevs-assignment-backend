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

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('order', 'OrderController')->except('update');
    Route::post('logout',  [UserController::class, 'logout']);

    Route::apiResource('/products', 'ProductController')->except(['index','show','update']);
    Route::post('products/update/{product}', [ProductController::class,'update']);

    Route::post('order/update/{order}', [OrderController::class, 'update']);
    Route::post('order/status/{order}', [OrderController::class, 'statusUpdate']);
    Route::post('order/list', [UserController::class, 'index']);

    Route::get('users', [UserController::class, 'show']);

    Route::get('filter/products', [ProductController::class,'filterProduct']);
    Route::get('filter/orders', [OrderController::class,'filterOrder']);


});
});
