<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExpensesController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('guard:1')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::resource('/users', UserController::class);
    Route::get('/users/reset-password/{id}', [UserController::class, 'resetPassword']);
    Route::resource('/products', ProductController::class);
    Route::resource('/expenses', ExpensesController::class);
});
