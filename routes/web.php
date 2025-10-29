<?php


use App\Http\Controllers\LienHeController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\CaiDatController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BackOffice_SpController;
use App\Http\Controllers\DanhMucController;
use App\Http\Controllers\NguoiDungController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;
use App\Models\CaiDat;

// -------------------------
// TRANG NGƯỜI DÙNG

// Trang chủ
Route::get('/', [SanPhamController::class, 'index'])->name('home');

// Danh sách sản phẩm
Route::get('/shop', fn() => view('user.shop'))->name('shop');

// Chi tiết sản phẩm (demo)
Route::get('/single-product', fn() => view('user.single-product'))->name('single-product');

// Liên hệ
Route::get('/contact', [LienHeController::class, 'index'])->name('contact');
Route::post('/contact', [LienHeController::class, 'store'])->name('contact.store');

// Danh sách sản phẩm
Route::get('/products', [SanPhamController::class, 'index'])->name('products.index');

// Đã xem gần đây
Route::get('/recently-viewed', [SanPhamController::class, 'recentlyViewed'])->name('recently.viewed');

// Chi tiết sản phẩm
Route::get('/product/{id}', [SanPhamController::class, 'show'])->name('product.show');

// Top Seller
Route::get('/TopSeller', [SanPhamController::class, 'allTopSeller'])->name('TopSeller');

// Sản phẩm tiếng Việt
Route::get('/san-pham/{id}', [SanPhamController::class, 'show'])->name('product.vietnamese');

// Footer động
Route::get('/footer', function (CaiDat $caiDatService) {
    $socialLinks = $caiDatService->getSocialLinks();
    return view('layouts.footer', compact('socialLinks'));
});

// -------------------------
// (ĐĂNG NHẬP / ĐĂNG KÝ)

Route::get('/login', [NguoiDungController::class, 'showLogin'])->name('login');
Route::post('/login', [NguoiDungController::class, 'login'])->name('login.post');
Route::get('/register', [NguoiDungController::class, 'showRegister'])->name('register');
Route::post('/register', [NguoiDungController::class, 'register'])->name('register.post');

// Reset mật khẩu
Route::get('/resetpassword', [NguoiDungController::class, 'showResetPassword'])->name('resetpassword');
Route::post('/resetpassword', [NguoiDungController::class, 'resetPassword'])->name('resetpassword.post');

// -------------------------
//  ROUTE YÊU CẦU ĐĂNG NHẬP

Route::middleware([AuthMiddleware::class])->group(function () {

    // Giỏ hàng
    Route::get('/cart', fn() => view('user.cart'))->name('cart');

    // Thanh toán
    Route::get('/checkout', fn() => view('user.checkout'))->name('checkout');

    // Dashboard backoffice
    Route::get('/backoffice/dashboard', fn() => view('backoffice.dashboard'))->name('dashboard');

    // Sản phẩm admin
    Route::get('/sanpham', [BackOffice_SpController::class, 'listProducts'])->name('admin.sanpham');
    Route::get('/add_product', [BackOffice_SpController::class, 'index'])->name('add_product.index');
    Route::post('/sanpham/them', [BackOffice_SpController::class, 'store'])->name('add_product.store');

    if (file_exists(__DIR__ . '/backoffice.php')) {
        require __DIR__ . '/backoffice.php';
    }
});



Route::post('/api/category/add', [DanhMucController::class, 'ajaxAdd'])->name('category.ajaxAdd');
