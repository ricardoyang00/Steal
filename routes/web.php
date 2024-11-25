<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\StaticPagesController;
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

// ShoppingCart
Route::controller(ShoppingCartController::class)->group(function () {
    Route::get('/cart', 'index')->name('shopping_cart');
});

Route::post('/increase_quantity', [ShoppingCartController::class, 'increaseQuantity'])->name('increase_quantity');
Route::post('/decrease_quantity', [ShoppingCartController::class, 'decreaseQuantity'])->name('decrease_quantity');

Route::post('/add_product', [ShoppingCartController::class, 'addProduct'])->name('add_product');
Route::post('/remove_product', [ShoppingCartController::class, 'removeProduct'])->name('remove_product');
Route::get('/add_test_products', [ShoppingCartController::class, 'addTestProducts'])->name('add_test_products');

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout/payment', [CheckoutController::class, 'selectPaymentMethod'])->name('checkout.selectPaymentMethod');
    Route::post('/checkout/payment', [CheckoutController::class, 'confirmPaymentMethod'])->name('checkout.confirmPayment');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

// Purchase History
Route::middleware('auth')->group(function (){
    Route::get('/user/{id}/order-history', [PurchaseHistoryController::class, 'orderHistory'])->name('purchaseHistory');
});

// Redirect GET /profile/edit to /profile
Route::get('/profile/edit', function () {
    return redirect()->route('profile');
});

// Authenticated User
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'showProfile')->name('profile');
    Route::put('/profile/edit', 'update')->name('profile.update');
    Route::put('/profile', 'updatePassword')->name('profile.updatePassword');
});

// Admin
Route::prefix('admin')->middleware('auth:admin')->controller(UserController::class)->group(function () {
    Route::get('/users/search', 'searchUsers')->name('admin.users.search');
    Route::get('/users/{id}', 'viewProfile')->name('admin.users.profile');
    Route::get('/all-users', 'listBuyersAndSellers')->name('admin.users.all');
    Route::post('/users/{id}/change-username', 'changeUsername')->name('admin.users.changeUsername');
    Route::post('/users/{id}/change-name', 'changeName')->name('admin.users.changeName');
    Route::post('/users/{id}/change-coins', 'changeCoins')->name('admin.users.changeCoins');
});

// Explore Games
Route::get('/explore', [GameController::class, 'index']);
Route::get('/explore', [GameController::class, 'explore'])->name('explore');
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.details');

// Static Pages
Route::controller(StaticPagesController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/faqs', 'faqs')->name('faqs');
});
