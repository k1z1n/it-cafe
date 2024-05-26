<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

Route::middleware(['CheckVisit', 'RecordVisit'])->group(function () {
    Route::get('/', [MainController::class, 'index'])->name('index');
});

Route::middleware(['CheckAuth'])->group(function () {
   Route::get('/cart', [CartItemController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartItemController::class, 'addToCart'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartItemController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartItemController::class, 'destroy'])->name('cart.destroy');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/edit', [ProfileController::class, 'updateUser'])->name('user.update');

    Route::post('/address/add', [DeliveryController::class, 'addDelivery'])->name('address.add');

    Route::post('/address/update-active-address', [DeliveryController::class, 'updateActiveAddress'])->name('address.update.active');

    Route::post('/update-payment-method', [CartItemController::class, 'updatePaymentMethod'])->name('update.payment.method');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'main'])->name('admin.main');

    Route::get('/products', [AdminController::class, 'showProducts'])->name('admin.product.index');
    Route::get('/products/search', [AdminController::class, 'searchProducts'])->name('admin.product.search');
    Route::post('/products', [AdminController::class, 'addProduct'])->name('admin.product.store');
    Route::get('/products/add', [AdminController::class, 'choiceCategory'])->name('admin.product.create');
    Route::get('/products/{id}/edit', [AdminController::class, 'editProduct'])->name('admin.product.edit');
    Route::put('/products/{id}', [AdminController::class, 'updateProduct'])->name('admin.product.update');
    Route::get('/products/{id}', [AdminController::class, 'showOneProduct'])->name('admin.product.show'); // Changed the route to singular 'product'
    Route::delete('/products/{id}', [AdminController::class, 'destroyProduct'])->name('admin.product.destroy'); // Added a leading slash before 'products'

    Route::get('/categories', [AdminController::class, 'showCategories'])->name('admin.category.index');
    Route::get('/categories/search', [AdminController::class, 'searchCategories'])->name('admin.category.search');
    Route::get('/categories/add', [AdminController::class, 'createCategory'])->name('admin.category.create'); // Changed the route to 'createCategory'
    Route::post('/categories', [AdminController::class, 'addCategory'])->name('admin.category.store');
    Route::get('/categories/{id}/edit', [AdminController::class, 'editCategory'])->name('admin.category.edit');
    Route::put('/categories/{id}', [AdminController::class, 'updateCategory'])->name('admin.category.update');
    Route::get('/categories/{id}', [AdminController::class, 'showOneCategory'])->name('admin.category.show'); // Changed the route to singular 'category'
    Route::delete('/categories/{id}', [AdminController::class, 'destroyCategory'])->name('admin.category.destroy'); // Added a leading slash before 'categories'

    Route::get('/users', [AdminController::class, 'showUsers'])->name('admin.user.index');
    Route::get('/users/search', [AdminController::class, 'searchUsers'])->name('admin.user.search');
    Route::post('/users/{user}/update-role', [AdminController::class, 'updateRole'])->name('admin.user.update-role'); // Changed the route to 'admin.user.update-role'
    Route::post('/users/{user}/update-status', [AdminController::class, 'updateStatus'])->name('admin.user.update-status');

    Route::get('/orders', [AdminController::class, 'showOrders'])->name('admin.order.index');

    Route::get('/carts', [AdminController::class, 'showCarts'])->name('admin.cart.index');

    Route::get('/statistic/users', [AdminController::class, 'userStat'])->name('admin.statistic.users');
    Route::get('/statistic/orders', [AdminController::class, 'ordersStat'])->name('admin.statistic.orders');
});


Route::get('/auth', [AuthController::class, 'showAuthForm'])->name('auth.form');
Route::post('/api/auth', [AuthController::class, 'sendAuthCode'])->name('auth.send');
Route::get('/auth/verify', [AuthController::class, 'showVerifyForm'])->name('auth.verify');
Route::post('/auth/verify-code', [AuthController::class, 'verify'])->name('auth.verify-code');
