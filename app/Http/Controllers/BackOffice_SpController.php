<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    protected $SanPham;

    public function __construct(SanPham $products)
    {
        $this->SanPham = $products;
    }

    // Trang danh sách sản phẩm
    public function index(Request $request)
    {
        $dsSanPham = $this->SanPham->getAll();

        $latestProducts = $this->SanPham->getLatestProducts(20); // Lấy 10 sản phẩm mới nhất

        $topSellers = $this->SanPham->topseller(3);

        // Lấy danh sách sản phẩm đã xem gần đây
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        $recentProducts = [];
        foreach ($recentlyViewed as $MaSanPham) {
            $sp = $this->SanPham->find($MaSanPham);
            if ($sp) {
                $recentProducts[] = $sp;
            }
        }
        $recentProducts = array_slice($recentProducts, 0, 3);

        return view('user.home', [
            'dsSanPham' => $dsSanPham,
            'latestProducts' => $latestProducts,
            'topseller'      => $topSellers,
            'recentProducts' => $recentProducts,
        ]);
        
    }

    // Trang chi tiết sản phẩm (Được dùng để khi ấn vô xem chi tiết thì sẽ hiển thị danh sách sản phẩm đã xem gần đây)
    public function show(Request $request, $MaSanPham)
    {
        $sp = $this->SanPham->find($MaSanPham);
        if (!$sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        // Cập nhật danh sách sản phẩm đã xem
        // Lấy danh sách sản phẩm đã xem từ session (Nếu chưa có thì trả về mảng rỗng)
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        // Xóa sản phẩm hiện tại khỏi danh sách cũ
        $recentlyViewed = array_diff($recentlyViewed, [$MaSanPham]);
        
        // Thêm sản phẩm mới xem vào đầu danh sách
        array_unshift($recentlyViewed, $MaSanPham);
        
        // Thêm sản phẩm mới vào đầu danh sách
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);

        // Lưu danh sách cập nhật vào session
        $request->session()->put('recently_viewed', $recentlyViewed);
        
        return view('user.single-product', ['sp' => $sp]);
    }

    public function recentlyViewed(Request $request)
    {
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        $recentProducts = [];
        foreach ($recentlyViewed as $MaSanPham) {
            $sp = $this->SanPham->find($MaSanPham);
            if ($sp) {
                $recentProducts[] = $sp;
            }
        }
        return view('user.recently-viewed', [
            'recentProducts' => $recentProducts
        ]);
    }
    public function allTopSeller()
    {
        $topseller = $this->SanPham->topseller(50); // Không truyền limit => lấy toàn bộ
        return view('user.TopSeller', compact('topseller'));
    }
}

