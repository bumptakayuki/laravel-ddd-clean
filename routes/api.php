<?php
// use Packages\UserContext\User\Adapter\Controller\UserController;
use Packages\OrderContext\Order\Adapter\Controller\OrderController;

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
