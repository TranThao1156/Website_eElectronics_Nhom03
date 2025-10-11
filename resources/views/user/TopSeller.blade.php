@extends('layouts.layout_user')
@section('css')
<link rel="stylesheet" href="{{ asset('css/TopSeller.css') }}">
@endsection
@section('content')

<div class="container">
    <h2 class="section-title">Top Seller</h2>

    <div class="row">
        @if (!empty($topseller) && count($topseller) > 0)
            @foreach ($topseller as $product)
                <div class="col-md-4 col-sm-6 col-12 mb-4"> {{-- 4 sản phẩm / hàng trên desktop --}}
                    <div class="single-product">
                        <div class="product-f-image">
                            <img src="{{ asset('img/products/' . $product->HinhAnh) }}" alt="{{ $product->TenSanPham }}">
                            <div class="product-hover">
                                <a href="#" class="add-to-cart-link">
                                    <i class="fa fa-shopping-cart"></i> Add to cart
                                </a>
                                <a href="{{ route('product.show', ['id' => $product->id]) }}" class="view-details-link">
                                    <i class="fa fa-link"></i> See details
                                </a>
                            </div>
                        </div>

                        <h2>
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                {{ $product->TenSanPham }}
                            </a>
                        </h2>
                        <div class="product-wid-rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>

                        <div class="product-carousel-price">
                            <ins>{{ number_format($product->GiaNhap ?? 0, 0, ',', '.') }} VNĐ</ins>
                            @if(!empty($product->GiaSauGiam))
                                <del>{{ number_format($product->GiaSauGiam, 0, ',', '.') }} VNĐ</del>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center">Chưa có sản phẩm nào để hiển thị.</p>
        @endif
    </div>
</div>
@endsection