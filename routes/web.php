<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\Auth\PasswordResetController;

use App\Http\Controllers\Admin\GameFieldsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\GameController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\AgeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MailController;

use App\Http\Controllers\Admin\SalesReportController;


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
Route::get('/home', [GameController::class, 'home'])->name('home');
Route::get('/top-sellers-chunk/{chunkIndex}', [GameController::class, 'loadChunk'])->name('top-sellers-chunk');

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

Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirect')->name('google-auth');
    Route::get('auth/google/call-back', 'callbackGoogle')->name('google-call-back');
});

// ShoppingCart
Route::controller(ShoppingCartController::class)->group(function () {
    Route::get('/cart', 'index')->name('shopping_cart');
});

Route::post('/increase_quantity', [ShoppingCartController::class, 'increaseQuantity'])->name('increase_quantity');
Route::post('/decrease_quantity', [ShoppingCartController::class, 'decreaseQuantity'])->name('decrease_quantity');

Route::post('/add_product', [ShoppingCartController::class, 'addProduct'])->name('add_product');
Route::post('/remove_product', [ShoppingCartController::class, 'removeProduct'])->name('remove_product');

// Wishlist
Route::controller(WishlistController::class)->group(function () {
    Route::get('/wishlist', 'index')->name('wishlist');
});

Route::post('/wishlist/remove', [WishlistController::class, 'removeProduct'])->name('wishlist.remove');
Route::post('/wishlist/add', [WishlistController::class, 'addProduct'])->name('wishlist.add');
Route::post('/wishlist/is_in_wishlist', [WishlistController::class, 'isInWishlist'])->name('wishlist.isInWishlist');

// Reviews
Route::post('/reviews/add', [ReviewsController::class, 'addReview'])->name('reviews.add');
Route::delete('/reviews/{id}', [ReviewsController::class, 'deleteReview'])->name('reviews.delete');
Route::post('/reviews/update', [ReviewsController::class, 'updateReview'])->name('reviews.update');
Route::post('/reviews/report', [ReviewsController::class, 'reportReview'])->name('reviews.report');
Route::post('/reviews/{review}/like', [ReviewsController::class, 'like'])->name('reviews.like');

// Checkout
Route::middleware('auth')->group(function () {
    Route::get('/checkout/payment', [CheckoutController::class, 'selectPaymentMethod'])->name('checkout.selectPaymentMethod');
    Route::post('/checkout/payment', [CheckoutController::class, 'confirmPaymentMethod'])->name('checkout.confirmPayment');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
});

// Purchase History
Route::middleware('auth')->group(function (){
    Route::get('/user/order-history', [PurchaseHistoryController::class, 'orderHistory'])->name('purchaseHistory');
    Route::get('/seller/purchases/{id}/details', [PurchaseHistoryController::class, 'purchaseDetails'])->name('seller.purchases.details');
});

// Notifications
Route::middleware('auth')->group(function (){
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/unread-count', [NotificationController::class, 'getUnreadCount'])->name('notifications.unreadCount');
    Route::delete('/notifications/{id}', [NotificationController::class, 'deleteNotification'])->name('notifications.delete');
    Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markNotificationAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/fetchNotifications', [NotificationController::class, 'fetchNotificationsJSON'])->name('notifications.fetchJSON');
});

// Redirect GET /profile/edit to /profile
Route::get('/profile/edit', function () {
    return redirect()->route('profile');
});

// Redirect GET /profile/deactivate to /profile
Route::get('/profile/deactivate', function () {
    return redirect()->route('profile');
});

// Authenticated User
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'showProfile')->name('profile');
    Route::put('/profile/edit', 'update')->name('profile.update');
    Route::put('/profile', 'updatePassword')->name('profile.updatePassword');
    Route::post('/profile/deactivate', 'deactivateUser')->name('profile.deactivate');
});

// Admin
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/users/search', 'searchUsers')->name('admin.users.search');
        Route::get('/users/{id}', 'viewProfile')->name('admin.users.profile');
        Route::put('/users/{id}/reset-picture', 'resetPicture')->name('admin.users.resetPicture');
        Route::post('/users/{id}/change-username', 'changeUsername')->name('admin.users.changeUsername');
        Route::post('/users/{id}/change-name', 'changeName')->name('admin.users.changeName');
        Route::post('/users/{id}/change-coins', 'changeCoins')->name('admin.users.changeCoins');
        Route::post('/users/{id}/block', 'blockUser')->name('admin.users.block');
        Route::post('/users/{id}/unblock', 'unblockUser')->name('admin.users.unblock');
        Route::post('/users/{id}/deactivate', 'adminDeactivateUser')->name('admin.users.deactivate');
    });

    Route::controller(GameFieldsController::class)->group(function () {
        Route::post('/games/store-game-field', 'store')->name('admin.storeGameField');
        Route::get('/games/index-game-field', 'index')->name('admin.indexGameField');
        Route::get('/games/edit-game-field/{type}/{id}', 'edit')->name('admin.editGameField');
        Route::post('/games/update-game-field/{type}/{id}', 'update')->name('admin.updateGameField');
        Route::delete('/games/destroy-game-field/{type}/{id}', 'destroy')->name('admin.destroyGameField');
    });

    Route::controller(ProductController::class)->group(function () {
        Route::post('/games/{id}/block', 'block')->name('admin.games.block');
        Route::post('/games/{id}/unblock', 'unblock')->name('admin.games.unblock');
        Route::get('/games/blocked', 'listBlockedGames')->name('admin.games.blocked-games');
    });
});

// Redirect GET /admin/games/store-game-field to /admin/games/index-game-field
Route::get('/admin/games/store-game-field', function () {
    return redirect()->route('admin.games.index-game-field');
});


// Explore Games
Route::get('/explore', function () {
    return view('pages/explore');
})->name('explore');

Route::get('/explore', [GameController::class, 'index']);
Route::get('/explore', [GameController::class, 'explore'])->name('explore');
Route::get('/game/{id}', [GameController::class, 'show'])->name('game.details');

// Seller
Route::prefix('seller')->middleware(['auth:web', 'check.seller'])->group(function () {
    Route::get('/products', [GameController::class, 'listProducts'])->name('seller.products');
    Route::get('/games/{id}/edit', [GameController::class, 'edit'])->name('games.edit');
    Route::put('/games/{id}/update', [GameController::class, 'update'])->name('games.update');
    Route::get('/games/create', [GameController::class, 'create'])->name('games.create');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::get('/games/{id}/cdks', [GameController::class, 'showCdks'])->name('games.cdks');
    Route::post('/games/{id}/cdks/add', [GameController::class, 'addCdks'])->name('games.cdks.add');
    Route::get('/games/{id}/purchasehistory', [GameController::class, 'purchaseHistory'])->name('games.history');
});

// Static Pages
Route::controller(StaticPagesController::class)->group(function () {
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/faqs', 'faqs')->name('faqs');
});

Route::get('/age/{id}', [AgeController::class, 'show'])->name('age.show');

// Mail
Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [MailController::class, 'showRequestForm'])->name('password.request');
    Route::post('/forgot-password', [MailController::class, 'sendPasswordReset'])->name('password.email');

    // Reset password
    Route::get('/password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('/sales-report', [SalesReportController::class, 'index'])->name('admin.salesReport');
    Route::get('/sales-report/daily', [SalesReportController::class, 'daily'])->name('admin.salesReport.daily');
    Route::get('/sales-report/weekly', [SalesReportController::class, 'weekly'])->name('admin.salesReport.weekly');
    Route::get('/sales-report/monthly', [SalesReportController::class, 'monthly'])->name('admin.salesReport.monthly');
    Route::get('/sales-report/custom', [SalesReportController::class, 'custom'])->name('admin.salesReport.custom');
    
    Route::get('/sales-report/daily-content', [SalesReportController::class, 'dailyContent'])->name('admin.salesReport.dailyContent');
    Route::get('/sales-report/weekly-content', [SalesReportController::class, 'weeklyContent'])->name('admin.salesReport.weeklyContent');
    Route::get('/sales-report/monthly-content', [SalesReportController::class, 'monthlyContent'])->name('admin.salesReport.monthlyContent');
    Route::get('/sales-report/custom-content', [SalesReportController::class, 'customContent'])->name('admin.salesReport.customContent');
    
    Route::get('/purchases/{id}/details', [PurchaseHistoryController::class, 'purchaseDetails'])->name('admin.purchases.details');
});