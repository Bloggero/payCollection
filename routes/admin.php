<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CollectionController;


Route::get('/', function () {
    return redirect('/admin/dashboard');
});

Route::get('/dashboard', function () {return view('admin.dashboard');});

Route::post('/dashboard/request', [CollectionController::class, 'index']);
