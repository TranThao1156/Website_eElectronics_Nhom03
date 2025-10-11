@extends('layouts.layout_user')
@section('css')
<link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection
@section('content')
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Contact</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hiển thị thông tin success/error khi người dùng thêm liên hệ -->
    
    @if(session('success'))
        <div class="alert alert-success text-center fs-3" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger text-center fs-3" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif



<div class="contact-section">
    <div class="container">
        <!-- Tiêu đề -->
        <div class="contact-content">
            <!-- Thông tin liên hệ + form -->
            <div class="contact-info">
                <div class="info-box">
                    <p><strong>Địa chỉ:</strong> <span style="color:#d35400;font-weight:bold;">Tòa nhà Ladexx, 266 Đội Cấn, Ba Đình, Hà Nội</span></p>
                    <p><strong>Điện thoại:</strong> <span style="color:#2980b9;font-weight:bold;">19006750</span></p>
                    <p><strong>Email:</strong> <span style="color:#27ae60;font-weight:bold;">support@gmail.com</span></p>
                </div>

                <form action="{{ route('contact.store') }}"  method="POST" class="contact-form" onsubmit="return confirmSubmit()">
                    @csrf
                    <input type="text" id="Ten" name="Ten" placeholder="Họ và tên" required pattern="^[A-Za-zÀ-ỹà-ỹ\s]+$" title="Tên chỉ được chứa chữ cái và khoảng trắng">
                    <input type="email" id="Email" name="Email" placeholder="Email" required pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$" title="Email phải có dạng @gmail.com">
                    <input type="text" id="SoDienThoai" name="SoDienThoai" placeholder="Số điện thoại" required pattern="^\d{10}$" title="Số điện thoại phải đúng 10 số">
                    <input type="text" id="TieuDe" name="TieuDe" placeholder="Tiêu đề" required pattern="^[A-Za-zÀ-ỹà-ỹ\s]+$" title="Tiêu đề chỉ được chứa chữ cái và khoảng trắng">
                    <textarea id="NoiDung" name="NoiDung" rows="4" placeholder="Nội dung" required></textarea>
                    <button type="submit">Gửi liên hệ</button>
            </div>

            <!-- Google map -->
            <div class="contact-map">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.7367880274595!2d105.81407921488389!3d21.00447898601174!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab5a3f6d2bdf%3A0x3c62a7cf0b1f5e77!2zMjY2IMSQLiDEkOG7i2kgQ8OhbiwgSOG6o2kgxJDhuqFjLCBIw6AgTuG7mWksIFZpZXRuYW0!5e0!3m2!1svi!2s!4v1669812345678"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
function confirmSubmit() {
    const ten = document.getElementById("Ten").value;
    const email = document.getElementById("Email").value;
    const sdt = document.getElementById("SoDienThoai").value;
    const tieude = document.getElementById("TieuDe").value;
    const noidung = document.getElementById("NoiDung").value;

    return confirm(
        "Bạn có chắc chắn muốn gửi thông tin liên hệ này?\n\n"
        + "👤 Tên: " + ten + "\n"
        + "📞 SĐT: " + sdt + "\n"
        + "📧 Email: " + email + "\n"
        + "📌 Tiêu đề: " + tieude + "\n"
        + "✉️ Nội dung: " + noidung
    );
}
</script>
