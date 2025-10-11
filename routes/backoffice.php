<?php

use App\Http\Controllers\ChucNang_Add_ProducController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::prefix('backoffice')
    ->middleware(['web', \App\Http\Middleware\AdminAuth::class])
    ->group(function () {
        
    Route::get('/dashboard', function () {
        return view ('backoffice.dashboard');
    })->name('dashboard');

    Route::get('/add_product', [ChucNang_Add_ProducController::class, 'index'])->name('add_product.index');

    Route::post('/sanpham/them', [ChucNang_Add_ProducController::class, 'store'])->name('add_product.store');

    // Trang danh sách sản phẩm (admin) - load trực tiếp từ DB và trả view admin.product
    Route::get('/products', function (Request $request) {
        // Paginate 10 per page
        $products = DB::table('sanpham')->where('TrangThai', 1)->paginate(10);
        return view('backoffice.product', ['products' => $products]);
    })->name('backoffice.products');

    });

