const dropArea = document.getElementById("drop-area");
const inputFile = document.getElementById("input-file");
const imageView = document.getElementById("img-view");

inputFile.addEventListener("change", uploadImage);

function uploadImage() {
    let file = inputFile.files[0];
    let fileType = file.type;
    imageView.innerHTML = ''; // Kosongkan isi imageView
    imageView.style.border = '2px dashed #bbb5ff';

    if (fileType.match('image.*')) {
        // Jika file adalah gambar, tampilkan sebagai pratinjau
        let imgLink = URL.createObjectURL(file);
        imageView.style.backgroundImage = `url(${imgLink})`;
        imageView.style.backgroundSize = 'cover';
        imageView.style.backgroundPosition = 'center';
        imageView.style.border = 0;
    } else {
        // Jika file adalah PDF atau jenis file lain, tampilkan ikon atau teks
        let iconHTML = fileType === 'application/pdf' ?
            '<img src="img/pdf_icon.png" alt="PDF icon" style="width: 80%; height: 70%;">' :
            `<p>${file.name}</p>`; // Tampilkan nama file untuk jenis file lain
        imageView.innerHTML = iconHTML;
        imageView.style.backgroundImage = ''; // Hapus pratinjau latar belakang
        imageView.style.border = 0;
    }

    document.getElementById('file-info').textContent = ` ${file.name}`;

}





dropArea.addEventListener ("dragover",function(e)
{
    e.preventDefault();
});

dropArea.addEventListener ("drop",function(e)
{
    e.preventDefault();
    inputFile.files = e.dataTransfer.files;
    uploadImage()
});
