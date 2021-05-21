<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;

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

Route::get('/', [HomeController::class, 'index'])->name('homePage');
/**
 * Auth
 */
Route::get('/signup', [AuthController::class, 'getSignUp'])->name('signUp');
Route::post('/signup', [AuthController::class, 'postSignUp']);
Route::get('/login', [AuthController::class, 'getLogIn'])->name('logIn');
Route::post('/login', [AuthController::class, 'postLogIn']);
Route::get('/logout', [AuthController::class, 'getLogOut'])->name('logOut');
