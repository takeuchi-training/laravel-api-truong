<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/products')
        ->controller(ProductController::class)
        ->name('products')
        ->group(function() {
    Route::get('/', 'index')->name('.index');
    Route::get('/search/{name}', 'search')->name('.search');
    Route::post('/', 'store')->middleware('auth:sanctum')->name('.store');

    Route::prefix('/{product}')
            ->name('.product')
            ->group(function () {
        Route::get('/', 'show')->name('.show');
        Route::put('/', 'update')->middleware('auth:sanctum')->name('.update');
        Route::delete('/', 'destroy')->middleware('auth:sanctum')->name('.destroy');
    });
});

Route::controller(UserController::class)->group(function() {
    Route::post('/register', 'register')->middleware('guest')->name('register');
    Route::post('/login', 'login')->middleware('guest')->name('login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('.logout');
});