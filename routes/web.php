<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController as AdminProductController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\WishlistController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products/{id}', [ShopProductController::class, 'show'])->name('products.show');

Route::middleware('redirect')->group(function () {
    Route::get('/login', [CustomerLoginController::class, 'loginForm'])->name('login');
    Route::post('/login', [CustomerLoginController::class, 'login']);

    Route::get('/register', [CustomerLoginController::class, 'registerForm'])->name('registerForm');
    Route::post('register', [CustomerLoginController::class, 'register'])->name('register');

    Route::get('/admin/login', [AdminLoginController::class, 'loginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
});

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

    // chekbox
    Route::patch('cart/select/{id}', [CartController::class, 'toggleSelect'])->name('cart.select');
    Route::patch('/cart/select-all', [CartController::class, 'selectAll'])->name('cart.selectAll');
    
    // checkout
    Route::post('checkout', [CartController::class, 'checkout'])->name('checkout');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('Wishlist.index');
    Route::post('/wishlist/add/{id}', [WishlistController::class, 'wishlistAdd'])->name('wishlist.add');
    Route::delete('/wishlist/delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist.delete');
});

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

Route::fallback(function () {
    return view('error');
});

Route::post('logout', [CustomerLoginController::class, 'logout'])->name('logout');
