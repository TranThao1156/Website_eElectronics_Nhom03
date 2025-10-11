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

    // Trang danh sách sản phẩm
    public function index(Request $request)
    {
        $dsSanPham = $this->SanPhamService->getAll();

        $latestProducts = $this->SanPhamService->getLatestProducts(20); // Lấy 10 sản phẩm mới nhất

        $topSellers = $this->SanPhamService->topseller();

        // Lấy danh sách sản phẩm đã xem gần đây
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        $recentProducts = [];
        foreach ($recentlyViewed as $MaSanPham) {
            $sp = $this->SanPhamService->find($MaSanPham);
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

    // Trang chi tiết sản phẩm
    public function show(Request $request, $MaSanPham)
    {
        $sp = $this->SanPhamService->find($MaSanPham);
        if (!$sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

        // Cập nhật danh sách sản phẩm đã xem
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$MaSanPham]);
        array_unshift($recentlyViewed, $MaSanPham);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        $request->session()->put('recently_viewed', $recentlyViewed);
        
        return view('user.single-product', ['sp' => $sp]);
    }

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
    
    

}

