@extends('layouts.layout_backoffice')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/listProduct.css') }}">

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Danh sách sản phẩm</h2>

        <p>
            <a href="{{ route('add_product.index') }}" class="btn btn-primary">
                + Thêm sản phẩm
            </a>
        </p>


        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Ảnh</th>
                        <th>#</th>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th>Giá nhập</th>
                        <th>Giá sau giảm</th>
                        <th>Danh mục</th>
                        <th>Nhà cung cấp</th>
                        <th>Ngày cập nhật</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($dsSanPham as $index => $p)
                        <tr>
                            {{-- Ảnh --}}
                            <td class="text-center">
                                <img src="{{ asset('img/products/' . $p->HinhAnh) }}" 
                                                alt="{{ $p->Ten}}" 
                                                class="fixed-product-image">
                            </td>

                            {{-- STT --}}
                            <td class="text-center">{{ $index + 1 }}</td>

                            {{-- Tên sản phẩm --}}
                            <td>{{ $p->Ten }}</td>

                            {{-- Số lượng --}}
                            <td class="text-center">{{ $p->SoLuong }}</td>

                            {{-- Giá nhập & Giá sau giảm --}}
                            <td>{{ number_format($p->GiaNhap, 0, ',', '.') }} đ</td>
                            <td>{{ $p->GiaSauGiam ? number_format($p->GiaSauGiam, 0, ',', '.') . ' đ' : '-' }}</td>

                            {{-- Danh mục & NCC --}}
                            <td>{{ $p->MaDanhMuc ?? '-' }}</td>
                            <td>{{ $p->MaNhaCungCap ?? '-' }}</td>

                            {{-- Ngày cập nhật --}}
                            <td>{{ $p->NgayCapNhat ? date('d/m/Y H:i', strtotime($p->NgayCapNhat)) : '-' }}</td>

                            {{-- Trạng thái --}}
                            <td class="text-center">
                                @if ($p->TrangThai == 1)
                                    <span class="badge bg-success">Hoạt động</span>
                                @else
                                    <span class="badge bg-secondary">Ẩn</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">
                                Không có sản phẩm nào.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
