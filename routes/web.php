<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\StatusController;

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
Route::get('/signup', [AuthController::class, 'getSignUp'])->middleware('guest')->name('signUp');
Route::post('/signup', [AuthController::class, 'postSignUp'])->middleware('guest');
Route::get('/login', [AuthController::class, 'getLogIn'])->middleware('guest')->name('logIn');
Route::post('/login', [AuthController::class, 'postLogIn'])->middleware('guest');
Route::get('/logout', [AuthController::class, 'getLogOut'])->name('logOut');

/**
 * Search
 */
Route::get('/search', [SearchController::class, 'getResult'])->name('search');

/**
 * Profiles
 */
Route::get('/user/profile/{username}', [ProfileController::class, 'showProfile'])->name('showProfile');
Route::get('/profile/edit', [ProfileController::class, 'getEditProfile'])->middleware('auth')->name('editProfile');
Route::post('/profile/edit', [ProfileController::class, 'postEditProfile'])->middleware('auth')->name('editProfile');
Route::post('/profile/upload_avatar/{username}', [ProfileController::class, 'uploadAvatar'])->name('uploadAvatar');

/**
 * Friends
 */
Route::get('/friends', [FriendController::class, 'showFriend'])->middleware('auth')->name('showFriend');
Route::get('/friends/all_requests', [FriendController::class, 'showRequest'])->middleware('auth')->name('allRequests');
Route::get('/friends/add/{username}', [FriendController::class, 'addToFriend'])->middleware('auth')->name('add');
Route::get('/friends/accept/{username}', [FriendController::class, 'acceptFriendRequest'])->middleware('auth')->name('accept');
Route::post('/friends/delete/{username}', [FriendController::class, 'deleteFriend'])->middleware('auth')->name('deleteFriend');

/**
 * Feed
 */
Route::post('/feed', [StatusController::class, 'createPost'])->middleware('auth')->name('createPost');
Route::post('/feed/{feedId}/reply', [StatusController::class, 'reply'])->middleware('auth')->name('reply');
