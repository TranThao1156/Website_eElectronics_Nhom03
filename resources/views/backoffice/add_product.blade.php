@extends('layouts.layout_backoffice')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/add_products.css') }}">
@endsection





@section('content')

<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="/sanpham/them" method="POST" enctype="multipart/form-data">
        @csrf
		<!-- Ảnh sản phẩm -->
        <label for="images">Ảnh sản phẩm</label>
		<div class="image-upload-wrapper">
			<input type="file" id="images" name="HinhAnh[]" accept="image/*" multiple required>
			<div class="image-preview-container" id="imagePreview"></div>
		</div>
		<!-- Tên sản phẩm -->
        <label for="ten">Tên sản phẩm</label>
        <input type="text" id="ten" name="Ten" placeholder="Nhập tên sản phẩm" required>
        {{-- required sẽ tự kiểm tra nếu người dùng không nhập sẽ báo --}}
		<!-- Số lượng -->
		<label for="soluong">Số lượng</label>
        <input type="number" id="soluong" name="SoLuong" placeholder="Nhập số lượng" min="1" required>

        <label for="nha_cung_cap" class="form-label">Nhà cung cấp</label>
            <div class="custom-datalist">
                <input 
                    list="nhacungcap_list" 
                    id="nha_cung_cap" 
                    name="MaNhaCungCap" 
                    placeholder="Chọn hoặc nhập nhà cung cấp" 
                    required
                    class="datalist-input"
                >
                <datalist id="nhacungcap_list">
                    @foreach($dsNhaCungCap as $ncc)
                        <option value="{{ $ncc->Ten }}"></option>
                    @endforeach
                </datalist>
            </div>


        <label for="gia_nhap">Giá nhập (VNĐ)</label>
        <input type="number" id="gia_nhap" name="GiaNhap" placeholder="Nhập giá nhập" required min="1000" max="1000000000">

        <label for="gia_sau_giam">Giá sau giảm (VNĐ)</label>
        <input type="number" id="gia_sau_giam" name="GiaSauGiam" placeholder="Nhập giá sau giảm" min="1000" max="1000000000">
		<!-- Mô tả sản phẩm -->
        <label for="mo_ta">Mô tả sản phẩm</label>
        <textarea id="mo_ta" name="MoTa" placeholder="Nhập mô tả chi tiết sản phẩm" required></textarea>
		<!-- Danh mục và tags -->
        <label for="danh_muc" class="form-label">Danh mục</label>
        <div class="custom-datalist">
            <input 
                list="danhmuc_list" 
                id="danh_muc" 
                name="MaDanhMuc" 
                placeholder="Chọn hoặc nhập danh mục" 
                required
                class="datalist-input"
            >
            <datalist id="danhmuc_list">
                @foreach($dsDanhMuc as $dm)
                    <option value="{{ $dm->Ten }}"></option>
                @endforeach
            </datalist>
        </div>

        <label for="tags">Tags (phân cách bằng dấu phẩy)</label>
        <input type="text" id="tags" name="Tags" placeholder="Ví dụ: công nghệ, giảm giá, hot">
		
		<!-- Nút thêm sản phẩm -->
        <button type="submit">Thêm sản phẩm</button>
    </form>
</div>

@endsection

@section('script')
<script src="/admin/js/addProduct.js"></script>
@endsection
