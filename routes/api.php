<?php

use App\Http\Controllers\Frontend\CheckoutController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| RajaOngkir API Routes
|--------------------------------------------------------------------------
*/
Route::get('/cities/{provinceId}', [CheckoutController::class, 'getCities'])->name('api.cities');
Route::post('/shipping-cost', [CheckoutController::class, 'getShippingCost'])->name('api.shipping-cost');
