<?php
use App\Http\Controllers\NguoiDungController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Middleware\AuthMiddleware;
use App\Models\SanPham;

Route::middleware('web')->group(function () {

    // --- LOGIN & REGISTER ---
    Route::middleware('guest')->group(function () {
    Route::get('/login', [NguoiDungController::class, 'showLogin'])->name('login');
    Route::post('/login', [NguoiDungController::class, 'login'])->name('login.post');
    Route::get('/register', [NguoiDungController::class, 'showRegister'])->name('register');
    Route::post('/register', [NguoiDungController::class, 'register'])->name('register.post');
    
    });

    // Truy cập vào http://localhost:8000/check-slug để được check slug
    Route::get('/check-slug', function () {
        $products = (new SanPham())->getAllProducts();

        foreach ($products as $product) {
            $slug = Str::slug($product->Ten) . '-' . $product->MaSanPham;
            echo "Sản phẩm: {$product->Ten} | Slug: {$slug} <br>";
        }
    });

    // --- BACKOFFICE (cần login) ---
    Route::middleware([AuthMiddleware::class])->group(function () {
        Route::get('/backoffice/dashboard', function () {
            return view('backoffice.dashboard');
        });
        
        Route::get('/logout', [NguoiDungController::class, 'logout'])->name('logout');
    });
});
