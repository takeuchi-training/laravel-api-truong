<?php

use App\Http\Controllers\AuthPassportController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ResettingPasswordController;
use App\Http\Controllers\UserController;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

// Sanctum
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::prefix('/products')
//         ->controller(ProductController::class)
//         ->name('products')
//         ->group(function() {
//     Route::get('/', 'index')->name('.index');
//     Route::get('/search/{name}', 'search')->name('.search');
//     Route::post('/', 'store')->middleware('auth:sanctum')->name('.store');

//     Route::prefix('/{product}')
//             ->name('.product')
//             ->group(function () {
//         Route::get('/', 'show')->name('.show');
//         Route::put('/', 'update')->middleware('auth:sanctum')->name('.update');
//         Route::delete('/', 'destroy')->middleware('auth:sanctum')->name('.destroy');
//     });
// });

// Route::controller(UserController::class)->group(function() {
//     Route::get('/users', 'index')->middleware('auth:sanctum')->name('.index');
//     Route::post('/register', 'register')->middleware('guest')->name('register');
//     Route::post('/login', 'login')->middleware('guest')->name('login');
//     Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('.logout');
// });

Route::post('/add-role/{userId}/{roleId}', function($userId, $roleId) {
    if (!auth()->user->tokenCan('access_all')) {
        abort(403, "Sorry! You don't have permission.'");
    }

    RoleUser::create([
        'user_id' => $userId,
        'role_id' => $roleId
    ]);

    return [
        'message' => 'Role created.'
    ];
})->middleware('auth:api');

// Email verification
Route::controller(EmailVerificationController::class)->middleware(['auth:sanctum'])->group(function() {
    Route::post('/email/verification-notification', 'sendVerificationEmail')->name('verification.send');
    Route::get('/email/verification-notification', 'verify')->name('verification.verify');
});

// Password resetting
Route::controller(ResetPasswordController::class)->middleware('guest')->group(function() {
    Route::post('/forgot-password', 'sendResetLink')->name('password.email');
    Route::post('/reset-password', 'resetPassword')->name('password.update');
});

// Test temporarySignedRoute
// Route::get('/test1', function() {
//     return [URL::temporarySignedRoute('test', now()->addMinutes(30), ['user' => 1, 'test' => 'abc'])];
// });

// Route::get('/test/{user}', function(Request $request) {
//     return [$request->hasValidSignature()];
// })->name('test');

// Passport
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('/products')
        ->controller(ProductController::class)
        ->name('products')
        ->group(function() {
    Route::get('/', 'index')->name('.index');
    Route::get('/search/{name}', 'search')->name('.search');
    Route::post('/', 'store')->middleware(['auth:api', 'scope:all,manipulate-product'])->name('.store');

    Route::prefix('/{product}')
            ->name('.product')
            ->group(function () {
        Route::get('/', 'show')->name('.show');
        Route::put('/', 'update')->middleware('auth:api')->name('.update');
        Route::delete('/', 'destroy')->middleware('auth:api')->name('.destroy');
    });
});

Route::controller(AuthPassportController::class)->group(function() {
    Route::get('/users', 'index')->middleware('auth:api')->name('.index');
    Route::post('/register', 'register')->middleware('guest')->name('register');
    Route::post('/login', 'login')->middleware('guest')->name('login');
    Route::post('/logout', 'logout')->middleware('auth:api')->name('.logout');
});