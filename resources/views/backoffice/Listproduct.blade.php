@extends('layouts.layout_backoffice')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h2 class="page-header">Danh sách sản phẩm</h2>

        <p>
            <a href="{{ route('add_product') }}" class="btn btn-primary">
                + Thêm sản phẩm
            </a>
        </p>

        <style>
            .prod-thumb {
                width: 64px;
                height: 64px;
                object-fit: cover;
                border-radius: 4px;
            }
            .table td {
                vertical-align: middle;
            }
        </style>

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
                                @php
                                    $img = null;
                                    if (!empty($p->HinhAnh)) {
                                        $decoded = @json_decode($p->HinhAnh, true);
                                        $candidates = is_array($decoded)
                                            ? $decoded
                                            : (strpos($p->HinhAnh, ',') !== false
                                                ? explode(',', $p->HinhAnh)
                                                : [$p->HinhAnh]);
                                        foreach ($candidates as $c) {
                                            $c = trim($c);
                                            if ($c && file_exists(public_path($c))) {
                                                $img = $c;
                                                break;
                                            }
                                        }
                                    }
                                @endphp
                                @if ($img)
                                    <img src="{{ asset($img) }}" class="prod-thumb" alt="Ảnh sản phẩm">
                                @else
                                    <div style="width:64px;height:64px;background:#f8f9fa;border:1px solid #ddd;border-radius:4px;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:12px;">
                                        No image
                                    </div>
                                @endif
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
