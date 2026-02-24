<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Test routes for third-party integrations (Postman)
Route::get('/ping', function () {
    return response()->json(['message' => 'pong']);
});

// ----------------------------------------------------------------------
// Mirrored Routes from web.php for API Testing
// ----------------------------------------------------------------------

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('api.home');
Route::get('/products', [ProductController::class, 'index'])->name('api.products.index');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('api.products.show');
Route::get('/compare', [\App\Http\Controllers\CompareController::class, 'index'])->name('api.compare.index');
Route::get('/sell', [\App\Http\Controllers\SellController::class, 'index'])->name('api.sell');

// PayU Response (Public to handle callbacks without session)
Route::post('/payment/payu/response', [CheckoutController::class, 'payuResponse'])->name('api.payment.payu.response');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('api.login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('api.register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout')->middleware('auth:sanctum');

// Cart routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('api.cart.index');
    Route::post('/cart', [CartController::class, 'store'])->name('api.cart.store');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('api.cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'destroy'])->name('api.cart.destroy');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('api.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('api.checkout.store');

    // Address routes
    Route::post('/addresses', [AddressController::class, 'store'])->name('api.addresses.store');
    
    Route::post('/payment/payu/initiate', [CheckoutController::class, 'payuInitiate'])->name('api.payment.payu.initiate');
    
    // Order routes
    Route::get('/orders', [OrderController::class, 'index'])->name('api.orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('api.orders.show');
    Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('api.orders.cancel');

    // Wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('api.wishlist.index');
    Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('api.wishlist.toggle');
});

// Admin Dashboard Routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::apiResource('products', \App\Http\Controllers\Admin\ProductController::class);
    Route::apiResource('brands', \App\Http\Controllers\Admin\BrandController::class);
    Route::delete('product-images/{productImage}', [\App\Http\Controllers\Admin\ProductController::class, 'destroyImage'])->name('product-images.destroy');
    Route::apiResource('products.variants', \App\Http\Controllers\Admin\ProductVariantController::class)->except(['show']);
    Route::apiResource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::post('orders/{order}/mark-payment-received', [\App\Http\Controllers\Admin\OrderController::class, 'markPaymentReceived'])->name('orders.mark-payment-received');

    Route::apiResource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'show', 'update', 'destroy']);
    Route::get('reports', [\App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
    Route::apiResource('reviews', \App\Http\Controllers\Admin\ReviewController::class)->only(['index', 'update', 'destroy']);
});

// Profile Routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('api.profile.edit');
    Route::put('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('api.profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('api.profile.password');
    Route::post('/profile/address', [\App\Http\Controllers\ProfileController::class, 'storeAddress'])->name('api.profile.address.store');
    Route::delete('/profile/address/{address}', [\App\Http\Controllers\ProfileController::class, 'destroyAddress'])->name('api.profile.address.destroy');
    
    // Reviews
    Route::post('/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('api.reviews.store');
    Route::put('/reviews/{review}', [\App\Http\Controllers\ReviewController::class, 'update'])->name('api.reviews.update');
});
