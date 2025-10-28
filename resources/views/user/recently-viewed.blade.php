@extends('layouts.layout_user')

@section('css')
<link rel="stylesheet" href="{{ asset('css/recently_viewed.css') }}">
@endsection

@section('content')
<div class="container">
    <h2 class="section-title">Sản phẩm đã xem gần đây</h2>

    <div class="row">
        @if (!empty($recentProducts) && count($recentProducts) > 0)
            @foreach ($recentProducts as $sp)
                <div class="col-md-3">
                    <div class="single-product">
                        <div class="product-f-image">
                            <img src="{{ asset('img/products/' . $sp->HinhAnh) }}" alt="{{ $sp->Ten }}">
                            <div class="product-hover">
                                <a href="#" class="add-to-cart-link"><i class="fa fa-shopping-cart"></i> Add to cart</a>
                                <a href="{{ url('/san-pham/'.$sp->id) }}" class="view-details-link"><i class="fa fa-link"></i> See details</a>
                            </div>
                        </div>
                       <h2><a href="{{ url('/san-pham/' . $sp->id) }}">{{ $sp->Ten }}</a></h2>
                        <div class="product-carousel-price">
                            <ins>${{ number_format($sp->GiaSauGiam, 2) }}</ins>
                            <del>${{ number_format($sp->GiaNhap, 2) }}</del>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>Bạn chưa xem sản phẩm nào gần đây.</p>
        @endif
    </div>
</div>
@endsection
