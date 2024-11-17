<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GameController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/home');

Route::get('/home', function () {
    return view('pages/home');
})->name('home');

Route::get('/explore', function () {
    return view('pages/explore');
})->name('explore');

// Cards
Route::controller(CardController::class)->group(function () {
    Route::get('/cards', 'list')->name('cards');
    Route::get('/cards/{id}', 'show');
});


// API
Route::controller(CardController::class)->group(function () {
    Route::put('/api/cards', 'create');
    Route::delete('/api/cards/{card_id}', 'delete');
});

Route::controller(ItemController::class)->group(function () {
    Route::put('/api/cards/{card_id}', 'create');
    Route::post('/api/item/{id}', 'update');
    Route::delete('/api/item/{id}', 'delete');
});


// Authentication
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegistrationForm')->name('register');
    Route::post('/register', 'register');
});

// Authenticated User
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'showProfile')->name('profile');
    Route::put('/profile/edit', 'update')->name('profile.update');
    Route::put('/profile', 'updatePassword')->name('profile.updatePassword');
});

Route::prefix('admin')->middleware('auth:admin')->controller(UserController::class)->group(function () {
    Route::get('/users/search', 'searchUsers')->name('admin.users.search');
    Route::get('/users/{id}', 'viewProfile')->name('admin.users.profile');
    Route::get('/all-users', 'listBuyersAndSellers')->name('admin.users.all');
    Route::post('/users/{id}/change-username', 'changeUsername')->name('admin.users.changeUsername');
    Route::post('/users/{id}/change-name', 'changeName')->name('admin.users.changeName');
    //Route::get('/users/buyers', 'listBuyers')->name('admin.users.buyers');
    //Route::get('/users/sellers', 'listSellers')->name('admin.users.sellers');
});

Route::get('/explore', [GameController::class, 'index']);

Route::get('/explore', [GameController::class, 'explore'])->name('explore');

Route::get('/game/{id}', [GameController::class, 'show'])->name('game.details');
