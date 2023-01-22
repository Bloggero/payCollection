<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CollectionController;


Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::get('/dashboard', [CollectionController::class, 'index']);

Route::post('/dashboard/request', [CollectionController::class, 'index']);


Route::get('/statistics', [StatisticController::class, 'index']);

