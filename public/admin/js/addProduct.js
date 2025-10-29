const imageInput = document.getElementById('images');
const imagePreview = document.getElementById('imagePreview');
let dt = new DataTransfer();

// Thêm nhiều hình ảnh
imageInput.addEventListener('change', function() {
    Array.from(this.files).forEach(file => {

        // Kiểm tra trùng tên file với các file đã chọn
        let isDuplicate = Array.from(dt.files).some(f => f.name === file.name);
        if(isDuplicate) {
            alert(`Ảnh "${file.name}" đã được chọn trước đó!`);
            return;
        }

        dt.items.add(file); // Thêm file vào DataTransfer

        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.classList.add('image-preview');

            const img = document.createElement('img');
            img.src = e.target.result;

            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerHTML = '&times;';
            btn.classList.add('remove-image');
            btn.addEventListener('click', function() {
                div.remove();
                removeFile(file.name);
            });

            div.appendChild(img);
            div.appendChild(btn);
            imagePreview.appendChild(div);
        }
        reader.readAsDataURL(file);
    });

    imageInput.files = dt.files;
});

// Xóa ảnh 
function removeFile(fileName) {
    const newDt = new DataTransfer();
    Array.from(dt.files).forEach(file => {
        if(file.name !== fileName) newDt.items.add(file);
    });
    dt = newDt;
    imageInput.files = dt.files;
}

document.querySelector("form").addEventListener("submit", function (e) {
    const giaNhap = parseFloat(document.getElementById("gia_nhap").value);
    const giaSauGiam = parseFloat(document.getElementById("gia_sau_giam").value);

    if (giaNhap > 1000000000) {
        alert("Giá nhập không được vượt quá 1.000.000.000 VNĐ");
        e.preventDefault(); // ngăn submit
        return;
    }

    if (giaSauGiam > 1000000000) {
        alert("Giá sau giảm không được vượt quá 1.000.000.000 VNĐ");
        e.preventDefault();
        return;
    }

    if (giaSauGiam > giaNhap) {
        alert("Giá sau giảm không được cao hơn giá nhập!");
        e.preventDefault();
    }
});

// Khi người dùng chọn danh mục trong datalist
$('#danh_muc').on('input', function() {
    const value = $(this).val();
    const option = $(`#danhmuc_list option[value="${value}"]`);
    if (option.length) {
        $(this).data('id', option.data('id'));
    } else {
        $(this).data('id', '');
    }
});

// Khi người dùng chọn nhà cung cấp
$('#nha_cung_cap').on('input', function() {
    const value = $(this).val();
    const option = $(`#nhacungcap_list option[value="${value}"]`);
    if (option.length) {
        $(this).data('id', option.data('id'));
    } else {
        $(this).data('id', '');
    }
});

// Trước khi gửi form, thay giá trị input = id thật
$('form').on('submit', function(e) {
    const maDM = $('#danh_muc').data('id');
    const maNCC = $('#nha_cung_cap').data('id');

    if (!maDM || !maNCC) {
        e.preventDefault();
        alert('Vui lòng chọn danh mục và nhà cung cấp hợp lệ!');
        return;
    }

    $('#danh_muc').val(maDM);
    $('#nha_cung_cap').val(maNCC);
});


