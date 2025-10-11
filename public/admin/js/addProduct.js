const imageInput = document.getElementById('images');
const imagePreview = document.getElementById('imagePreview');
let dt = new DataTransfer();

imageInput.addEventListener('change', function() {
    Array.from(this.files).forEach(file => {
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
        alert("⚠️ Giá nhập không được vượt quá 1.000.000.000 VNĐ");
        e.preventDefault(); // ngăn submit
        return;
    }

    if (giaSauGiam > 1000000000) {
        alert("⚠️ Giá sau giảm không được vượt quá 1.000.000.000 VNĐ");
        e.preventDefault();
        return;
    }

    if (giaSauGiam > giaNhap) {
        alert("⚠️ Giá sau giảm không được cao hơn giá nhập!");
        e.preventDefault();
    }
});