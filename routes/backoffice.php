<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::prefix('backoffice')
    ->middleware(['web'])
    ->group(function () {
        
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

    Route::get('/dashboard', function () {
        return view ('admin.dashboard');
    })->name('dashboard');

    // Trang thêm sản phẩm
    Route::get('/add_product', function () {
        return view('admin.add_product');
    })->name('add_product');

    // Trang danh sách sản phẩm (admin) - load trực tiếp từ DB và trả view admin.product
    Route::get('/products', function (Request $request) {
        // Paginate 10 per page
        $products = DB::table('sanpham')->where('TrangThai', 1)->paginate(10);
        return view('admin.product', ['products' => $products]);
    })->name('admin.products');

    });

