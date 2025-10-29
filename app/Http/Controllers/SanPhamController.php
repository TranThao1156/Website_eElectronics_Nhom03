<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        // $dsSanPham = $this->SanPham->getAll();
         // Lấy danh sách sản phẩm đang hoạt động
        $dsSanPham = SanPham::where('TrangThai', 1)->get();

        // $latestProducts = $this->SanPham->getLatestProducts(20); // Lấy 10 sản phẩm mới nhất
        // Lấy 20 sản phẩm mới nhất
        $latestProducts = SanPham::select('MaSanPham', 'Ten as TenSanPham', 
            DB::raw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh'),
            'GiaSauGiam as Gia'
        )
        ->orderByDesc('MaSanPham')
        ->limit(20)
        ->get();

        // $topSellers = $this->SanPham->topseller(3);
         $topSellers = SanPham::select('MaSanPham', 'Ten as TenSanPham', 
            DB::raw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh'),
            'GiaSauGiam as Gia'
        )
            ->orderByDesc('MaSanPham')
            ->limit(3)
            ->get();

        // Lấy danh sách sản phẩm đã xem gần đây
        // Lấy danh sách sản phẩm đã xem gần đây
        $recentlyViewed = $request->session()->get('recently_viewed', []);

        $recentProducts = SanPham::whereIn('MaSanPham', $recentlyViewed)
            ->take(3)
            ->get()
            ->map(function ($sp) {
            // Lấy ảnh đầu tiên
            $sp->HinhAnh = explode(',', $sp->HinhAnh)[0] ?? null;
            return $sp;
            });

        return view('user.home', [
                        'dsSanPham' => $dsSanPham,
                        'latestProducts' => $latestProducts,
                        'topseller' => $topSellers,
                        'recentProducts' => $recentProducts,
        ]);
        
    }

    // Trang chi tiết sản phẩm
    public function show(Request $request, $MaSanPham)
    {
        $sp = SanPham::find($MaSanPham);
        if (!$sp) {
            abort(404, 'Không tìm thấy sản phẩm');
        }

         // Cập nhật danh sách đã xem
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$MaSanPham]);
        array_unshift($recentlyViewed, $MaSanPham);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        $request->session()->put('recently_viewed', $recentlyViewed);
        
        return view('user.single-product', compact('sp'));
    }

    // Trang sản phẩm đã xem gần đây
    public function recentlyViewed(Request $request)
    {
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentProducts = SanPham::whereIn('MaSanPham', $recentlyViewed)->get();

        return view('user.recently-viewed', compact('recentProducts'));
    }
    public function allTopSeller()
    {
        $topseller = SanPham::where('TrangThai', 1)
            ->orderByDesc('MaSanPham')
            ->limit(50)
            ->get();

        return view('user.TopSeller', compact('topseller'));
    }
}

