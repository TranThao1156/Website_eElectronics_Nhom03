<?php

use App\Http\Controllers\BackOffice_SpController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::prefix('backoffice')
    ->middleware(['web'])
    ->group(function () {
        
    Route::get('/dashboard', function () {
        return view ('backoffice.dashboard');
    })->name('dashboard');


    Route::get('/admin/sanpham', [BackOffice_SpController::class, 'listProducts'])->name('admin.sanpham');

    Route::get('/add_product', [BackOffice_SpController::class, 'index'])->name('add_product.index');

    Route::post('/sanpham/them', [BackOffice_SpController::class, 'store'])->name('add_product.store');

    });

