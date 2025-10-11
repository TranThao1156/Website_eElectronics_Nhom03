@extends('layouts.layout_backoffice')

@section('css')
    <link rel="stylesheet" href="/admin/css/add_products.css">
@endsection

@section('content')
	
<div class="container">
    <h2>Thêm sản phẩm mới</h2>
    <form action="/sanpham/them" method="POST">
        <!-- Nếu dùng Laravel, nhớ thêm: @csrf -->

        <label for="ten">Tên sản phẩm</label>
        <input type="text" id="ten" name="Ten" placeholder="Nhập tên sản phẩm" required>

        <label for="soluong">Số lượng</label>
        <input type="number" id="soluong" name="SoLuong" placeholder="Nhập số lượng" min="1" required>

        <label for="nha_cung_cap">Tên nhà cung cấp</label>
        <select id="nha_cung_cap" name="MaNhaCungCap" required>
            <option value="">-- Chọn nhà cung cấp --</option>
            <option value="1">Công ty TNHH ABC</option>
            <option value="2">Công ty Điện tử Việt</option>
            <option value="3">Công ty Công nghệ Toàn Cầu</option>
        </select>

        <label for="gia_nhap">Giá nhập (VNĐ)</label>
        <input type="number" id="gia_nhap" name="GiaNhap" placeholder="Nhập giá nhập" required>

        <label for="gia_sau_giam">Giá sau giảm (VNĐ)</label>
        <input type="number" id="gia_sau_giam" name="GiaSauGiam" placeholder="Nhập giá sau giảm">

        <label for="mo_ta">Mô tả sản phẩm</label>
        <textarea id="mo_ta" name="MoTa" placeholder="Nhập mô tả chi tiết sản phẩm"></textarea>


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

        <button type="submit">Thêm sản phẩm</button>
    </form>
</div>
@endsection
