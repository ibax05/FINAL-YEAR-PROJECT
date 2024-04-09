function validateForm(event) {
    // Semak Bahagian 1: Agenda Mesyuarat
    var agendaFields = document.querySelectorAll('#agendaSection input');
    if (!checkFields(agendaFields)) {
        alert('Sila lengkapkan semua bidang pada Agenda Mesyuarat.');
        return false;
    }

// Semak Bahagian 2: Pegawai Pemohon
// Ambil semua bidang pada bagian "Informasi Pegawai"
var pegawaiFields = document.querySelectorAll('#pegawaiSection input[required], #pegawaiSection select[required]');

// Fungsi untuk memvalidasi apakah semua bidang tidak kosong
function checkFields(fields) {
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value.trim() === '') {
            return false;
        }
    }
    return true;
}

// Fungsi untuk validasi formulir
function validateForm() {
    // Validasi lainnya...

    if (!checkFields(pegawaiFields)) {
        alert('Sila lengkapkan semua bidang pada Informasi Pegawai.');
        return false;
    }

    // Validasi lainnya...
    return true;
}

// Event listener untuk validasi saat formulir dikirimkan
var form = document.querySelector('form');
form.addEventListener('submit', function(event) {
    if (!validateForm()) {
        event.preventDefault();
    }
});

    // Semak Bahagian 3: Pengerusi Mesyuarat
    var pengerusiFields = document.querySelectorAll('#pengerusiSection input[type="checkbox"],#pengerusiSection input[type="text"]');
    var checked = false;
    var doneforinput = false;

    pengerusiFields.forEach(function (input) {
        if (input.type === 'checkbox' && input.checked) { 
            checked = true;
        } else if (input.type === 'text' && input.value.trim() !== '') { 
            doneforinput = true;
        }
    });

    if (!checked && !doneforinput) {
        alert('Sila pilih sekurang-kurangnya satu pilihan pada Pengerusi Mesyuarat.');
        if (event) {
            event.preventDefault(); // Untuk menghentikan tindakan lalai (jika digunakan dalam event listener)
        }
        return false;
    }




    // Semak Bahagian 4: Jenis Mesyuarat
    var JenisMesyuaratSectionFields = document.querySelectorAll('#JenisMesyuaratSection input[type="checkbox"],#JenisMesyuaratSection input[type="text"]');
    var checked2 = false;
    var doneforinput2 = false;

    JenisMesyuaratSectionFields.forEach(function (input) {
        if (input.type === 'checkbox' && input.checked) { 
            checked2 = true;
        } else if (input.type === 'text' && input.value.trim() !== '') { 
            doneforinput2 = true;
        }
    });

    if (!checked2 && !doneforinput2) {
        alert('Sila pilih sekurang-kurangnya satu pilihan pada Jenis Mesyuarat.');
        if (event) {
            event.preventDefault(); // Untuk menghentikan tindakan lalai (jika digunakan dalam event listener)
        }
        return false;
    }







    // Semak Bahagian 5.1 : Menu
    var id_menu = document.querySelectorAll('#id_menu input[type="checkbox"]');
    var checked3 = false;

    id_menu.forEach(function (input) {
    if (input.checked) { 
        checked3 = true;
    }
   });

    if (!checked3) {
    alert('Sila pilih sekurang-kurangnya satu pilihan pada Menu.');
    if (event) {
        event.preventDefault();
    }
    return false;
    }










    // Semak Bahagian 5.2: Masa Makanan Perlu Disediakan
    var MasaMakananPerluDisediakanSectionFields = document.querySelectorAll('#MasaMakananPerluDisediakanSection input[type="checkbox"],#MasaMakananPerluDisediakanSection input[type="text"]');
    var checked5 = false;
    var doneforinput5 = false;

    MasaMakananPerluDisediakanSectionFields.forEach(function (input) {
        if (input.type === 'checkbox' && input.checked) { 
            checked5 = true;
        } else if (input.type === 'text' && input.value.trim() !== '') { 
            doneforinput5 = true;
        }
    });

    if (!checked5 && !doneforinput5) {
        alert('Sila pilih sekurang-kurangnya satu pilihan pada Masa Makanan Perlu Disediakan.');
        if (event) {
            event.preventDefault(); // Untuk menghentikan tindakan lalai (jika digunakan dalam event listener)
        }
        return false;
    }


 


    // Semak Bahagian 5.3: Cara Hidangan
    var carahidanganSectionFields = document.querySelectorAll('#carahidangan input[type="checkbox"]');
    var checked7 = false;
    var doneforinput7 = false;

    carahidanganSectionFields.forEach(function (input) {
        if (input.type === 'checkbox' && input.checked) { 
            checked7 = true;
        } else if (input.type === 'text' && input.value.trim() !== '') { 
            doneforinput7 = true;
        }
    });

    if (!checked7 && !doneforinput7) {
        alert('Sila pilih sekurang-kurangnya satu pilihan pada Cara Hidangan.');
        if (event) {
            event.preventDefault(); // Untuk menghentikan tindakan lalai (jika digunakan dalam event listener)
        }
        return false;
    }



}



function checkFields(fields) {
    for (var i = 0; i < fields.length; i++) {
        if (fields[i].value === '') {
            return false; // Jika terdapat bidang yang kosong, kembalikan false
        }
    }
    return true; // Jika semua bidang telah diisi, kembalikan true
}