<?php

use App\Http\Controllers\LienHeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\CaiDatController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
// Route::get('/', function () {
//     return view('user.home');
// })->name('home');

// Admin routes: protect all routes starting with /admin
Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
    // Trang chủ admin
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Trang danh sách sản phẩm (admin) - load trực tiếp từ DB và trả view admin.product
    Route::get('/products', function (Request $request) {
        // Paginate 10 per page
        $products = DB::table('sanpham')->where('TrangThai', 1)->paginate(10);
        return view('admin.product', ['products' => $products]);
    })->name('admin.products');

    // Trang thêm sản phẩm
    Route::get('/add_product', function () {
        return view('admin.add_product');
    })->name('add_product');

    // Lưu sản phẩm (form add product) — xử lý trực tiếp từ route (không qua Controller)
    Route::post('/add_product', function (Request $request) {
    $validated = $request->validate([
        'Ten' => 'required|string|max:255',
        'Gia' => 'required|numeric|min:0.01',
        'Loai' => 'nullable|string|max:100',
        'MoTa' => 'nullable|string',
        'HinhAnh' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048'
    ]);

    $data = [
        'Ten' => $validated['Ten'],
        'Gia' => $validated['Gia'],
        'DanhMuc' => $validated['Loai'] ?? null,
        'MoTa' => $validated['MoTa'] ?? null,
        'TrangThai' => 1
    ];

    // Xử lý file upload nếu có
    if ($request->hasFile('HinhAnh') && $request->file('HinhAnh')->isValid()) {
        $file = $request->file('HinhAnh');
        $ext = $file->getClientOriginalExtension();
        $filename = time() . '_' . preg_replace('/[^A-Za-z0-9\-_.]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $ext;
        $dest = public_path('uploads');
        if (!file_exists($dest)) {
            mkdir($dest, 0755, true);
        }
        $file->move($dest, $filename);
        $data['HinhAnh'] = 'uploads/' . $filename;
    }

        DB::table('sanpham')->insert($data);

        return redirect()->route('products.index')->with('success', 'Thêm sản phẩm thành công');
    })->name('add_product.store');
});

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

// Route::get('/san-pham/{id}', [SanPhamController::class, 'show'])->name('product.vietnamese');

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



// Nhúng thêm routes backoffice
require __DIR__.'/backoffice.php';