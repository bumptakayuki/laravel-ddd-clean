<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('box-lunches');
});

Route::get('/orders', function () {
    return view('orders');
});

Route::get('/box-lunches', function () {
    return view('box-lunches');
});

Route::get('/areas', function () {
    return view('areas');
});

Route::get('/purchases', function () {
    return view('purchases');
});

Route::get('/stores', function () {
    return view('stores');
});

