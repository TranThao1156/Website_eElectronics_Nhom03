<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SanPhamController extends Controller
{
    protected $SanPham;

    public function __construct(SanPham $products)
    {
        $this->SanPham = $products;
    }

    // Lấy tất cả sản phẩm đang hoạt động
    public function getAll()
    {
        return SanPham::where('TrangThai', 1)->get();
    }

    // Tìm sản phẩm theo mã
    public function find($MaSanPham)
    {
        return SanPham::select('MaSanPham', 'Ten', 'GiaNhap', 'GiaSauGiam', 'MoTa', 'MaDanhMuc')
            ->selectRaw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh')
            ->where('MaSanPham', $MaSanPham)
            ->first();
    }

    // Lấy sản phẩm mới nhất
    public function getLatestProducts(int $limit = 50)
    {
        return SanPham::select('MaSanPham', 'Ten as TenSanPham', 'GiaSauGiam as Gia')
            ->selectRaw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh')
            ->orderByDesc('MaSanPham')
            ->limit($limit)
            ->get();
    }

    // Top seller
    public function topseller(int $limit = 0)
    {
        return SanPham::select('MaSanPham', 'Ten as TenSanPham', 'GiaNhap', 'GiaSauGiam')
            ->selectRaw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh')
            ->where('TrangThai', 1)
            ->orderByDesc('MaSanPham')
            ->limit($limit)
            ->get();
    }

    // Lấy top sản phẩm theo ngày cập nhật hoặc ID
    public function getTop(int $limit = 3)
    {
        $orderBy = Schema::hasColumn('sanpham', 'NgayCapNhat') ? 'NgayCapNhat' : 'MaSanPham';

        return SanPham::select('MaSanPham', 'Ten', 'GiaNhap', 'GiaSauGiam', 'NgayCapNhat')
            ->selectRaw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh')
            ->where('TrangThai', 1)
            ->orderByDesc($orderBy)
            ->limit($limit)
            ->get();
    }

    // Trang danh sách sản phẩm
    public function index(Request $request)
    {
        $dsSanPham = $this->getAll();
        $latestProducts = $this->getLatestProducts(20);
        $topSellers = $this->topseller(3);
        $topNew = $this->getTop(3);

        // Lấy danh sách sản phẩm đã xem gần đây từ session
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentProducts = SanPham::select(
            'MaSanPham',
            'Ten',
            'GiaNhap',
            'GiaSauGiam',
            \DB::raw('SUBSTRING_INDEX(HinhAnh, ",", 1) as HinhAnh')
        )
            ->whereIn('MaSanPham', $recentlyViewed)
            ->take(3)
            ->get();


        return view('user.home', [
            'dsSanPham' => $dsSanPham,
            'latestProducts' => $latestProducts,
            'topseller' => $topSellers,
            'recentProducts' => $recentProducts,
            'topNew' => $topNew,
        ]);
    }

    // Trang chi tiết sản phẩm
    public function show(Request $request, $MaSanPham)
    {
        $sp = $this->find($MaSanPham);
        if (!$sp) abort(404, 'Không tìm thấy sản phẩm');

        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentlyViewed = array_diff($recentlyViewed, [$MaSanPham]);
        array_unshift($recentlyViewed, $MaSanPham);
        $recentlyViewed = array_slice($recentlyViewed, 0, 10);
        $request->session()->put('recently_viewed', $recentlyViewed);

        return view('user.single-product', ['sp' => $sp]);
    }

    // Trang sản phẩm đã xem gần đây
    public function recentlyViewed(Request $request)
    {
        $recentlyViewed = $request->session()->get('recently_viewed', []);
        $recentProducts = SanPham::whereIn('MaSanPham', $recentlyViewed)->get();

        return view('user.recently-viewed', ['recentProducts' => $recentProducts]);
    }

    // Trang Top Seller toàn bộ
    public function allTopSeller()
    {
        $topseller = $this->topseller(50);
        return view('user.TopSeller', compact('topseller'));
    }
}
