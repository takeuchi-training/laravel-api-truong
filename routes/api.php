<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    Route::get('/users', 'index')->middleware('auth:sanctum')->name('.index');
    Route::post('/register', 'register')->middleware('guest')->name('register');
    Route::post('/login', 'login')->middleware('guest')->name('login');
    Route::post('/logout', 'logout')->middleware('auth:sanctum')->name('.logout');
});

Route::post('/add-role/{userId}/{roleId}', function($userId, $roleId) {
    RoleUser::create([
        'user_id' => $userId,
        'role_id' => $roleId
    ]);

    return [
        'message' => 'Role created.'
    ];
});

// Email verification
// Route::post('/email/verification-notification', function (Request $request) {
//     $email = $request->validate([
//         'email' => 'required|email'
//     ]);

//     if (!User::where('email', 'ilike', $email)->first()) {
//         return [
//             'error' => "Sorry! We can't find your email."
//         ];
//     }

//     $request->user()->sendEmailVerificationNotification();
 
//     return [
//         'message' => 'Verification link sent!'
//     ];
// })->middleware(['auth:sanctum', 'throttle:6,1'])->name('verification.send');

// Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
//     $request->fulfill();
 
//     return [
//         'message' => 'Email verified!'
//     ];
// })->middleware(['auth', 'signed'])->name('verification.verify');

Route::controller(EmailVerificationController::class)->middleware('auth:sanctum')->group(function() {
    Route::post('/email/verification-notification', 'sendVerificationEmail')->name('verification.send');
    Route::get('/email/verification-notification', 'verify')->name('verification.verify');
});