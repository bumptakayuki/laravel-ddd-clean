<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders', function () {
    return view('orders');
});

Route::get('/box-lunches', function () {
    return view('box-lunches');
});

