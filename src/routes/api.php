<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Checkout\CheckoutController;
use App\Http\Controllers\Api\OrdersController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Se pasa esta ruta al web.php para hacer uso del CSRF, y evitar exponer la ruta de pago sin seguridad
// https://a34c-180-200-236-215.ngrok-free.app/api/payment/update
// Route::post('/checkout/payment',[CheckoutController::class, 'payment'])->name('checkout_payment');
// Route::post('/payment', [OrdersController::class, 'payment']);
// Route::post('/payment', [CheckoutController::class, 'payment'])->name('checkout_payment');