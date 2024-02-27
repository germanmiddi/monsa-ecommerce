<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

use App\Http\Controllers\Web\Home\HomeController;
use App\Http\Controllers\Web\Store\StoreController;
use App\Http\Controllers\Web\Product\ProductController;
use App\Http\Controllers\Web\Cart\CartController;
use App\Http\Controllers\Web\Checkout\CheckoutController;
use App\Http\Controllers\Web\Blog\BlogController;

use App\Http\Controllers\Manager\Dashboard\DashboardController;
use App\Http\Controllers\Manager\Blog\PostController;




/* Frontoffice */
Route::get('/',[HomeController::class, 'index'])->name('home');

Route::get('/blog',[BlogController::class, 'list'])->name('blog.list');
Route::get('/blog/{slug}',[BlogController::class, 'single'])->name('blog.single');

Route::get('/tienda',[StoreController::class, 'index'])->name('store');
Route::get('/product/{product}',[ProductController::class, 'index'])->name('product');
Route::get('/cart',[CartController::class, 'index'])->name('cart');

Route::get('/checkout',[CheckoutController::class, 'index'])->name('checkout');
Route::get('/checkout/confirmation',[CheckoutController::class, 'confirmation'])->name('checkout.confirmation');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout_process');
/*Backoffice */

Route::middleware(['auth'])->group(function () {
    Route::prefix('manager')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/novedades', [PostController::class, 'index'])->name('posts.list');
        Route::get('/novedades/create', [PostController::class, 'create'])->name('posts.create');
        Route::get('/novedades/{id}/edit',   [PostController::class, 'edit'])->name('posts.edit');
        Route::post('/novedades/store', [PostController::class, 'store'])->name('posts.store');
        Route::post('/novedades/update/{post}', [PostController::class, 'update'])->name('posts.update');
    });
});


