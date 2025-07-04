<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(['verify' => true]);





Route::get('/about', [HomeController::class, 'about'])->name('home.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
    Route::get('/', [HomeController::class, 'index'])->name('home.index');


#lezem ykoun aaamel auth w verification bech ykoun 3andou access
Route::middleware(['auth' , 'verified'])->group(function () {
    Route::get('/account-dashboard', [UserController::class, 'index'])->name('user.index');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/cart',[CartController::class, 'index'])->name('cart.index');
Route::get('/shop/checkout',[CartController::class, 'checkout'])->name('cart.checkout');


Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])
    ->name('order.confirmation');
Route::get('/shop/product/{id}', [ShopController::class, 'product_detail'])->name('shop.product.detail');


});
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');




Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::post('/submit-order', [OrderController::class, 'submitOrder'])->name(('order.submit'));

Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::get('/order/confirmation/{id}', [OrderController::class, 'confirmation'])->name('order.confirmation');

Route::post('/update-cart', [CartController::class ,'update'])->name('cart.update');
Route::post('/remove-from-cart', [CartController::class ,'remove'])->name('cart.remove');




Route::middleware(['auth', AuthAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::get('/admin/category/add', [AdminController::class, 'add_category'])->name('admin.category.add');
    Route::post('/admin/category/store', [AdminController::class, 'store_category'])->name('admin.category.store');
    Route::get('/admin/category/edit/{id}', [AdminController::class, 'edit_category'])->name('admin.category.edit');
    Route::put('/admin/category/update/{id}', [AdminController::class, 'update_category'])->name('admin.category.update');
    Route::delete('/admin/category/delete/{id}', [AdminController::class, 'delete_category'])->name('admin.category.delete');
    Route::get('/admin/products', [AdminController::class, 'products'])->name('admin.products');
    Route::get('/admin/product/add', [AdminController::class, 'add_product'])->name('admin.product.add');
    Route::post('/admin/product/store', [AdminController::class, 'store_product'])->name('admin.product.store');
    Route::get('/admin/product/edit/{id}', [AdminController::class, 'edit_product'])->name('admin.product.edit');
    Route::put('/admin/product/update/{id}', [AdminController::class, 'update_product'])->name('admin.product.update');
    Route::delete('/admin/product/delete/{id}', [AdminController::class, 'delete_product'])->name('admin.product.delete');

    Route::get('/admin/orders', [AdminController::class, 'showOrders'])->name('admin.orders');


    
});