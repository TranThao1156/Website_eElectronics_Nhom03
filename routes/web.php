<?php

use App\Http\Controllers\LienHeController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\CaiDatController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Service\CaiDatService;


//Trang chủ
Route::get('/', [SanPhamController::class, 'index'])->name('home');

//hóa đơn
Route::get('/checkout', function () {
    return view('user.checkout');
})->name('checkout');

//Danh sách
Route::get('/shop', function () {
    return view('user.shop');
})->name('shop');

// Chi tiết
Route::get('/single-product', function () {
    return view('user.single-product');
})->name('single-product');
//Giỏ hàng
Route::get('/cart', function () {
    return view('user.cart');
})->name('cart');

//Liên hệ
// Hiển thị form
Route::get('/contact', [LienHeController::class, 'index'])->name('contact');

// Lưu dữ liệu từ form
Route::post('/contact', [LienHeController::class, 'store'])->name('contact.store');

// Trang danh sách sản phẩm
Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');

//Danh sách sản phẩm đã xem gần đây
Route::get('/recently-viewed', [SanPhamController::class, 'recentlyViewed'])->name('recently.viewed');

// Trang chi tiết sản phẩm
Route::get('/product/{id}', [SanPhamController::class, 'show'])->name('product.show');
//Danh sách TopSeller
Route::get('/TopSeller', [SanPhamController::class, 'allTopSeller'])->name('TopSeller');
//...
Route::get('/san-pham/{id}', [SanPhamController::class, 'show'])->name('product.vietnamese');
//Giả lập thêm sản phẩm vào recently views

Route::get('/test-add-view/{id}', function (Request $request, $id) {
    $recentlyViewed = $request->session()->get('recently_viewed', []);

    // Xóa trùng và thêm sản phẩm mới nhất lên đầu
    $recentlyViewed = array_diff($recentlyViewed, [$id]);
    array_unshift($recentlyViewed, $id);

    // Giới hạn 5 sản phẩm
    $recentlyViewed = array_slice($recentlyViewed, 0, 5);

    $request->session()->put('recently_viewed', $recentlyViewed);

    return redirect()->route('home')
        ->with('success', "Đã thêm sản phẩm ID {$id} vào Recently Viewed!");
});

Route::get('/footer', function (CaiDatService $caiDatService) {
    $socialLinks = $caiDatService->getSocialLinks();
    return view('layouts.footer', compact('socialLinks'));
});

//Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
// Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/resetpassword', [AuthController::class, 'showResetPassword'])->name('resetpassword');
Route::post('/resetpassword', [AuthController::class, 'resetPassword'])->name('resetpassword.post');


Route::get('/resetpassword', function () {
    return view('auth.resetpassword');
})->name('resetpassword');

// Nhúng thêm routes backoffice
require __DIR__.'/backoffice.php';