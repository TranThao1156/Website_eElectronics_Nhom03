<?php

namespace App\Http\Controllers;

use App\Service\SanPhamService;
use Illuminate\Http\Request;

class SanPhamController extends Controller
{
    protected $SanPhamService;

    public function __construct(SanPhamService $products)
    {
        $this->SanPhamService = $products;
    }
    // Thảo - Trang sản phẩm
    public function index(Request $request)
    {
        $dsSanPham = $this->SanPhamService->getAll();
        // Khanh - Lấy danh sách sản phẩm mới nhất
        $latestProducts = $this->SanPhamService->getLatestProducts(20); // Lấy 20 sản phẩm mới nhất
        // Khôi - Lấy danh sách TopSeller
        $topSellers = $this->SanPhamService->topseller(3);
        // Thảo - Lấy danh sách sản phẩm đã xem gần đây
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentProducts = [];
        foreach ($recentlyViewed as $MaSanPham) {
            $sp = $this->SanPhamService->find($MaSanPham);
            if ($sp) {
                $recentProducts[] = $sp;
            }
        }
        $recentProducts = array_slice($recentProducts, 0, 3);
        // Trâm - Lấy danh sách sản phẩm mới (top new)
        $topNew = $this->SanPhamService->topNew(3);
        return view('user.home', [
            'dsSanPham' => $dsSanPham,
            'latestProducts' => $latestProducts,
            'topseller'      => $topSellers,
            'recentProducts' => $recentProducts,
            'topNew'         => $topNew
        ]);
        
    }

    // Thi - Trang chi tiết sản phẩm
    public function show(Request $request, $MaSanPham)
    {
        $sp = $this->SanPhamService->find($MaSanPham);
        if (!$sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        // Thảo - Cập nhật danh sách sản phẩm đã xem
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$MaSanPham]);
        array_unshift($recentlyViewed, $MaSanPham);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        $request->session()->put('recently_viewed', $recentlyViewed);
        
        return view('user.single-product', ['sp' => $sp]);
    }
    // Thảo - Lưu danh sách sản phẩm đã xem gần đây vào session 
    public function recentlyViewed(Request $request)
    {
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        $recentProducts = [];
        foreach ($recentlyViewed as $MaSanPham) {
            $sp = $this->SanPhamService->find($MaSanPham);
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
        $topseller = $this->SanPhamService->topseller(50); // Không truyền limit => lấy toàn bộ
        return view('user.TopSeller', compact('topseller'));
    }
}

