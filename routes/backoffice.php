<?php

use App\Http\Controllers\BackOffice_SpController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

Route::prefix('backoffice')
    ->middleware(['web'])
    ->group(function () {

        // Trang dashboard
        Route::get('/dashboard', function () {
            return view('backoffice.dashboard');
        })->name('dashboard');

        // 👉 Trang thêm sản phẩm
        Route::get('/add_product', [BackOffice_SpController::class, 'index'])
            ->name('add_product.index');

        // 👉 Xử lý thêm sản phẩm
        Route::post('/sanpham/them', [BackOffice_SpController::class, 'store'])
            ->name('add_product.store');

        // 👉 Trang danh sách sản phẩm
        Route::get('/products', function (Request $request) {
            $products = DB::table('sanpham')->where('TrangThai', 1)->paginate(10);
            return view('backoffice.product', ['products' => $products]);
        })->name('backoffice.products');
    });
