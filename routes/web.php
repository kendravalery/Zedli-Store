<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController as AdminProductController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\WishlistController;

// SEARCH
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/', [HomeController::class, 'index'])->name('home');
// SHOW PRODUCT
Route::get('/products/{id}', [ShopProductController::class, 'show'])->name('products.show');

//  MIDDLEWARE REDIRECT LOGINS
Route::middleware('redirect')->group(function () {
    Route::get('/login', [CustomerLoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login']);

    Route::get('/register', [CustomerLoginController::class, 'registerForm'])->name('registerForm');
    Route::post('register', [CustomerLoginController::class, 'register'])->name('register');

    Route::get('/admin/login', [AdminLoginController::class, 'loginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
});
// ROLE CUSTOMER 
Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/customer/profil', [CustomerController::class, 'showProfile'])->name('customer.profile');

    Route::put('/customer/address/update', [CustomerController::class, 'updateAddress'])->name('customer.address.update');

    Route::put('/customer/profile/photo', [CustomerController::class, 'updatePhoto'])->name('customer.profile.update');

    Route::get('/manage-account', [CustomerController::class, 'manageAccount'])->name('customer.manage.account');

    Route::put('/manage-Address/update', [CustomerController::class, 'updateManageAccount'])->name('customer.manage.account.update');

    // Manage Address
    Route::post('/manage-account/store', [CustomerController::class, 'storeAddress'])->name('customer.Address.store');

    Route::patch('/manage-account/default/{id}', [CustomerController::class, 'defaultAddress'])->name('customer.Address.default');

    Route::delete('/manage-account/delete/{id}', [CustomerController::class, 'deleteAddress'])->name('customer.Address.delete');
    Route::put('/manage-account/update/{id}', [CustomerController::class, 'updateManageAddress'])->name('customer.Address.update');
    Route::get('/customer/address', [CustomerController::class, 'showAddress'])->name('customer.address');

    // province - city -
    Route::get('/get-cities/{provinceCode}', [CustomerController::class, 'getCities']);
    Route::get('/get-districts/{cityCode}', [CustomerController::class, 'getDistricts']);
    Route::get('/get-villages/{districtCode}', [CustomerController::class, 'getVillages']);

    // Cart
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/cart/increase/{id}', [CartController::class, 'increase'])->name('cart.increase');
    Route::patch('/cart/decrease/{id}', [CartController::class, 'decrease'])->name('cart.decrease');

    // chekbox cart
    Route::patch('cart/select/{id}', [CartController::class, 'toggleSelect'])->name('cart.select');
    Route::patch('/cart/select-all', [CartController::class, 'selectAll'])->name('cart.selectAll');

    // checkout
    Route::post('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout.back');
    // payment
    Route::post('/payment', [PaymentController::class, 'index'])->name('payment.index');
    // Tombol Pay (nanti dibuat)
    // Route::post('/payment', [PaymentController::class, 'pay'])->name('payment.pay');

    // WISHLIST
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('Wishlist.index');
    Route::delete('/wishlist/delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist.delete');
    Route::post('/wishlist/toggle/delete/{id}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
});

// FOOTER PART
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/faq', [PageController::class, 'faq'])->name('faq');

// ROLE ADMIN
Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::resource('products', AdminProductController::class);

        Route::delete('product/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.image.delete');

        // CATEGORIES
        Route::resource('categories', CategoryController::class);

        // ORDERS (biasanya cuma lihat)
        Route::resource('orders', OrderController::class)->only(['index', 'show']);

        //  REVIEWS (moderasi)
        Route::resource('reviews', ReviewController::class)->only(['index', 'update', 'destroy']);

        Route::resource('banners', BannerController::class);

        Route::patch('baners/{id}/toggle/', [BannerController::class, 'toggle'])->name('banners.toggle');
    });
// 404
Route::fallback(function () {
    return view('error');
});

Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');
Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');
