<?php
// use Packages\UserContext\User\Adapter\Controller\UserController;
use Packages\OrderContext\Order\Adapter\Controller\OrderController;
use Packages\BoxLunchContext\BoxLunch\Adapter\Controller\BoxLunchController;

// User関連のルーティングは一旦コメントアウト
// Route::prefix('users')->group(function () {
//     Route::get('/', [UserController::class, 'index']);
//     Route::post('/', [UserController::class, 'store']);
//     Route::put('{id}', [UserController::class, 'update']);
//     Route::delete('{id}', [UserController::class, 'destroy']);
// });

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::post('{orderId}/payment', [OrderController::class, 'createPayment']);
    Route::post('{orderId}/acceptance', [OrderController::class, 'createAcceptance']);
    Route::post('{orderId}/purchase', [OrderController::class, 'createPurchase']);
});

Route::prefix('box-lunches')->group(function () {
    Route::get('/', [BoxLunchController::class, 'index']);
    Route::get('{boxLunchId}', [BoxLunchController::class, 'show']);
    Route::post('configuration', [BoxLunchController::class, 'createConfiguration']);
});
