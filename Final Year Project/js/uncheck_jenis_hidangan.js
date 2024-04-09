    // Dapatkan semua elemen dalam kumpulan
    const elementsInGroup_jenis_hidangan= document.querySelectorAll('input[id="jenis_hidangan"]');

    // Tambahkan pengendali acara untuk setiap elemen
    elementsInGroup_jenis_hidangan.forEach(element => {
        if (element.type === 'checkbox') {
            element.addEventListener('click', handleElementChange);
        } else if (element.type === 'text') {
            element.addEventListener('input', handleElementChange);
        }
    });

    // Fungsi untuk mengendalikan perubahan pada elemen
    function handleElementChange(event) {
        // Nyahpilih semua checkbox lain dan kosongkan semua input teks lain
        elementsInGroup_jenis_hidangan.forEach(otherElement => {
            if (otherElement !== event.target) {
                if (otherElement.type === 'checkbox') {
                    otherElement.checked = false;
                } else if (otherElement.type === 'text') {
                    otherElement.value = '';
                }
            }
        });
    }




