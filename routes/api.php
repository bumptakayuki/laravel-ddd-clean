<?php
// use Packages\UserContext\User\Adapter\Controller\UserController;
use Packages\OrderContext\Order\Adapter\Controller\OrderController;
use Packages\BoxLunchContext\BoxLunch\Adapter\Controller\BoxLunchController;
use Packages\AreaContext\Area\Adapter\Controller\AreaController;
use Packages\PurchaseContext\Purchase\Adapter\Controller\PurchaseController;
use Packages\StoreContext\Store\Adapter\Controller\StoreController;

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

Route::prefix('areas')->group(function () {
    Route::get('/', [AreaController::class, 'index']);
    Route::get('{areaId}', [AreaController::class, 'show']);
});

Route::prefix('purchases')->group(function () {
    Route::get('/', [PurchaseController::class, 'index']);
    Route::post('/confirm', [PurchaseController::class, 'confirm']);
    Route::get('{purchaseId}', [PurchaseController::class, 'show']);
});

Route::prefix('stores')->group(function () {
    Route::get('/', [StoreController::class, 'index']);
    Route::post('/', [StoreController::class, 'store']);
    Route::get('{storeId}', [StoreController::class, 'show']);
    Route::put('{storeId}', [StoreController::class, 'update']);
    Route::post('{storeId}/store-box-lunch', [StoreController::class, 'createStoreBoxLunch']);
    Route::put('{storeId}/store-box-lunch/{boxLunchId}', [StoreController::class, 'updateStoreBoxLunch']);
    Route::post('{storeId}/store-area', [StoreController::class, 'createStoreArea']);
    Route::put('{storeId}/store-area/{areaId}', [StoreController::class, 'updateStoreArea']);
});
