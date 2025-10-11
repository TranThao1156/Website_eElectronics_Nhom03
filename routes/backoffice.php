<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::prefix('backoffice')
    ->middleware(['web'])
    ->group(function () {
        
    Route::get('/dashboard', function () {
        return view ('backoffice.dashboard');
    })->name('dashboard');

    // Trang thêm sản phẩm
    Route::get('/add_product', function () {
        return view('backoffice.add_product');
    })->name('add_product');

    // Trang danh sách sản phẩm (admin) - load trực tiếp từ DB và trả view admin.product
    Route::get('/products', function (Request $request) {
        // Paginate 10 per page
        $products = DB::table('sanpham')->where('TrangThai', 1)->paginate(10);
        return view('backoffice.product', ['products' => $products]);
    })->name('backoffice.products');

    });

