@extends('layouts.layout_backoffice')

@section('content')
<style>
	/* Small local styles for add product page */
	.admin-card { background: #fff; padding: 20px; border-radius: 4px; box-shadow: 0 1px 2px rgba(0,0,0,0.05); }
	.admin-card .page-header { margin-top: 0; }
	@media (max-width: 768px) { .col-lg-8 { width:100%; } }
</style>

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-8">
			<div class="admin-card">
				 <h2 class="page-header text-center text-primary fw-bold"> Thêm sản phẩm</h2>

			{{-- Hiển thị lỗi validation --}}
			@if ($errors->any())
				<div class="alert alert-danger">
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif

			<form action="{{ route('add_product.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
				@csrf

				<div class="form-group">
					<label for="MaSanPham" class="col-sm-2 control-label">Mã sản phẩm <span style="color:red">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="MaSanPham" id="MaSanPham" value="{{ old('MaSanPham') }}" class="form-control" placeholder="Mã sản phẩm (bắt buộc, duy nhất)" required>
						@if ($errors->has('MaSanPham')) <p class="text-danger">{{ $errors->first('MaSanPham') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="Ten" class="col-sm-2 control-label">Tên sản phẩm <span style="color:red">*</span></label>
					<div class="col-sm-10">
						<input type="text" name="Ten" id="Ten" value="{{ old('Ten') }}" class="form-control" placeholder="Nhập tên sản phẩm" required>
						@if ($errors->has('Ten')) <p class="text-danger">{{ $errors->first('Ten') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="HinhAnh" class="col-sm-2 control-label">Hình ảnh</label>
					<div class="col-sm-10">
						<input type="file" name="HinhAnh[]" id="HinhAnh" class="form-control" multiple accept="image/*">
						<p class="help-block">(Tùy chọn) Tải lên tối đa 5 ảnh (jpg, png). Mỗi ảnh tối đa 2MB. Chọn nhiều ảnh bằng Ctrl/Shift.</p>
					</div>
				</div>

                
				<div class="form-group">

				<div class="form-group">
					<label for="SoLuong" class="col-sm-2 control-label">Số lượng</label>
					<div class="col-sm-10">
						<input type="number" step="1" min="0" name="SoLuong" id="SoLuong" value="{{ old('SoLuong', 0) }}" class="form-control" placeholder="Số lượng (số nguyên >= 0)">
						@if ($errors->has('SoLuong')) <p class="text-danger">{{ $errors->first('SoLuong') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="MaNhaCungCap" class="col-sm-2 control-label">Mã nhà cung cấp</label>
					<div class="col-sm-10">
						<input type="text" name="MaNhaCungCap" id="MaNhaCungCap" value="{{ old('MaNhaCungCap') }}" class="form-control" placeholder="Mã nhà cung cấp">
						@if ($errors->has('MaNhaCungCap')) <p class="text-danger">{{ $errors->first('MaNhaCungCap') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="GiaNhap" class="col-sm-2 control-label">Giá nhập <span style="color:red">*</span></label>
					<div class="col-sm-10">
						<input type="number" step="0.01" min="0.01" name="GiaNhap" id="GiaNhap" value="{{ old('GiaNhap') }}" class="form-control" placeholder="Giá nhập (lớn hơn 0)" required>
						@if ($errors->has('GiaNhap')) <p class="text-danger">{{ $errors->first('GiaNhap') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="GiaSauGiam" class="col-sm-2 control-label">Giá sau giảm</label>
					<div class="col-sm-10">
						<input type="number" step="0.01" min="0" name="GiaSauGiam" id="GiaSauGiam" value="{{ old('GiaSauGiam') }}" class="form-control" placeholder="Giá sau giảm (>=0 và <= Giá nhập)">
						@if ($errors->has('GiaSauGiam')) <p class="text-danger">{{ $errors->first('GiaSauGiam') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="NgayCapNhat" class="col-sm-2 control-label">Ngày cập nhật</label>
					<div class="col-sm-10">
						<input type="date" name="NgayCapNhat" id="NgayCapNhat" value="{{ old('NgayCapNhat') }}" class="form-control">
						@if ($errors->has('NgayCapNhat')) <p class="text-danger">{{ $errors->first('NgayCapNhat') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="TrangThai" class="col-sm-2 control-label">Trạng thái</label>
					<div class="col-sm-10">
						<select name="TrangThai" id="TrangThai" class="form-control">
							<option value="2" {{ old('TrangThai')=='2' ? 'selected' : '' }}>Còn hàng</option>
							<option value="1" {{ old('TrangThai')=='1' ? 'selected' : '' }}>Hết hàng</option>
							<option value="0" {{ old('TrangThai')=='0' ? 'selected' : '' }}>Hết bán</option>

						</select>
						@if ($errors->has('TrangThai')) <p class="text-danger">{{ $errors->first('TrangThai') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="Loai" class="col-sm-2 control-label">Loại sản phẩm</label>
					<div class="col-sm-10">
						<select name="Loai" id="Loai" class="form-control">
							<option value="">-- Chọn loại --</option>
							<option value="dien-thoai" {{ old('Loai')=='dien-thoai' ? 'selected' : '' }}>Điện thoại</option>
							<option value="may-tinh" {{ old('Loai')=='may-tinh' ? 'selected' : '' }}>Máy tính</option>
							<option value="phu-kien" {{ old('Loai')=='phu-kien' ? 'selected' : '' }}>Phụ kiện</option>
						</select>
						@if ($errors->has('Loai')) <p class="text-danger">{{ $errors->first('Loai') }}</p> @endif
					</div>
				</div>

				<div class="form-group">
					<label for="Loai" class="col-sm-2 control-label">Loại sản phẩm</label>
					<div class="col-sm-10">
						<select name="Loai" id="Loai" class="form-control">
							<option value="">-- Chọn loại --</option>
							<option value="dien-thoai" {{ old('Loai')=='dien-thoai' ? 'selected' : '' }}>Điện thoại</option>
							<option value="may-tinh" {{ old('Loai')=='may-tinh' ? 'selected' : '' }}>Máy tính</option>
							<option value="phu-kien" {{ old('Loai')=='phu-kien' ? 'selected' : '' }}>Phụ kiện</option>
						</select>
					</div>
				</div>


				<div class="form-group">
					<label for="MoTa" class="col-sm-2 control-label">Mô tả</label>
					<div class="col-sm-10">
						<textarea name="MoTa" id="MoTa" class="form-control" rows="5" placeholder="Mô tả ngắn">{{ old('MoTa') }}</textarea>
					</div>
				</div>

				<div class="form-group">
					<label for="tags" class="col-sm-2 control-label">Tags</label>
					<div class="col-sm-10">
						<input type="text" name="tags" id="tags" value="{{ old('tags') }}" class="form-control" placeholder="gõ tags, cách nhau bằng dấu phẩy">
						@if ($errors->has('tags')) <p class="text-danger">{{ $errors->first('tags') }}</p> @endif
					</div>
				</div>

				

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary">Lưu</button>
						<a href="{{ url()->previous() }}" class="btn btn-default">Hủy</a>
						<a href="{{ route('admin.products') }}" class="btn btn-info">Quay về danh sách</a>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>
{{-- Thêm CKEditor --}}
<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
	CKEDITOR.replace('MoTa', {
		height: 200,
		removeButtons: 'PasteFromWord,About', // Gọn hơn
	});
</script>
@endsection
