<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\KapalController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\RegisterController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

Route::get('account/verify/{token}', [RegisterController::class, 'verifyAccount'])->name('user.verify');

Route::get('success', function () {
    return view('success');
})->name('success');

Route::get('admin/verify-user', [AdminController::class, 'notificationVerifiedUser'])->name('admin.notification');
Route::get('admin/verify-kapal/{id}', [AdminController::class, 'verifyKapal']);
Route::put('admin/verify-user/{id}', [AdminController::class, 'verifiedUser'])->middleware(['role:admin', 'auth:api']);

Route::post('user/otp', [RegisterController::class, 'otp']);

Route::get('kapal', [KapalController::class, 'index'])->middleware(['role:user|admin', 'auth:api']);
Route::post('kapal', [KapalController::class, 'store'])->middleware(['role:user|admin', 'auth:api']);
Route::put('kapal/{id}', [KapalController::class, 'update'])->middleware(['role:user|admin', 'auth:api']);
Route::delete('kapal/{id}', [KapalController::class, 'destroy'])->middleware(['role:admin', 'auth:api']);



