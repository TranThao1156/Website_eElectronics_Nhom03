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
