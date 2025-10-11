<?php

use App\Http\Controllers\LienHeController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\CaiDatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Service\CaiDatService;
use App\Http\Controllers\AdminAuthController;

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


Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/resetpassword', function () {
    return view('auth.resetpassword');
})->name('resetpassword');

// Kiểm tra đăng nhập quản trị (Bài tập 3)
// Trang đăng nhập (test tên đăng nhập: user4, mật khẩu: 123456)
Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');

// Gửi form đăng nhập
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');

// Đăng xuất
Route::get('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Trang chính sau khi đăng nhập
Route::get('/admin/dashboard', function () {
    return view('backoffice.dashboard');
})->name('admin.dashboard');


// Nhúng thêm routes backoffice
require __DIR__.'/backoffice.php';