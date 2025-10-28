@extends('layouts.layout_backoffice')

@section('css')
<link rel="stylesheet" href="{{ asset('admin/css/add_products.css') }}">
@endsection


@section('content')

<div class="container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <h2>Thêm sản phẩm mới</h2>
    <form action="{{ route('add_product.store') }}" method="POST" enctype="multipart/form-data">
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
        <!-- required sẽ tự kiểm tra nếu người dùng không nhập sẽ báo -->
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
                class="datalist-input">
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
        <textarea id="mo_ta" name="MoTa" placeholder="Nhập mô tả chi tiết sản phẩm"></textarea>
        <!-- Danh mục và tags -->
        <label for="danh_muc" class="form-label">Danh mục</label>
        <div class="custom-datalist">
            <input
                list="danhmuc_list"
                id="danh_muc"
                name="MaDanhMuc"
                placeholder="Chọn hoặc nhập danh mục"
                required
                class="datalist-input">
            <datalist id="danhmuc_list">
                @foreach($dsDanhMuc as $dm)
                <option value="{{ $dm->Ten }}"></option>
                @endforeach
            </datalist>
            <button type="button" id="btnThemDanhMuc" class="btn-add">+</button>
        </div>

        <label for="tags">Tags (phân cách bằng dấu phẩy)</label>
        <input type="text" id="tags" name="Tags" placeholder="Ví dụ: công nghệ, giảm giá, hot">

        <!-- Nút thêm sản phẩm -->
        <button type="submit">Thêm sản phẩm</button>
    </form>
</div>

@endsection


@section('script')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Ajax
    $('#btnThemDanhMuc').on('click', function() {
        const tenDanhMuc = $('#danh_muc').val().trim();

        if (tenDanhMuc === '') {
            alert('Vui lòng nhập tên danh mục!');
            return;
        }

        $.ajax({
            url: "{{ route('category.ajaxAdd') }}",
            type: "POST",
            data: {
                Ten: tenDanhMuc, 
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if (res.success) {
                    alert(res.message);
                    $('#danhmuc_list').append(`<option value="${res.data.Ten}"></option>`);
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const msg = xhr.responseJSON?.message || 'Danh mục đã tồn tại!';
                    alert(msg);
                } else {
                    alert('Lỗi máy chủ!');
                }
            }
        });
    });

    //Mô tả sản phẩm
    let moTaEditor;
    ClassicEditor
        .create(document.querySelector('#mo_ta'))
        .then(editor => {
            moTaEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });
    const form = document.querySelector('form');
    form.addEventListener('submit', function() {
        // Lấy text thuần, bỏ tất cả thẻ HTML
         document.querySelector('#mo_ta').value = editor.model.document.getRoot().getChild(0).getChild(0)?.data || editor.getData().replace(/<[^>]*>/g, '');
    });
</script>

<!-- Script riêng của trang -->
<script src="/admin/js/addProduct.js"></script>
@endsection