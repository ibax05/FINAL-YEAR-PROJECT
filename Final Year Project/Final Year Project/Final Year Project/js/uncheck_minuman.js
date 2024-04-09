    // Dapatkan semua elemen dalam kumpulan
    const elementsInGroup_minuman = document.querySelectorAll('input[id="minuman"]');

    // Tambahkan pengendali acara untuk setiap elemen
    elementsInGroup_minuman.forEach(element => {
        if (element.type === 'checkbox') {
            element.addEventListener('click', handleElementChange);
        } else if (element.type === 'text') {
            element.addEventListener('input', handleElementChange);
        }
    });

    // Fungsi untuk mengendalikan perubahan pada elemen
    function handleElementChange(event) {
        // Nyahpilih semua checkbox lain dan kosongkan semua input teks lain
        elementsInGroup_minuman.forEach(otherElement => {
            if (otherElement !== event.target) {
                if (otherElement.type === 'checkbox') {
                    otherElement.checked = false;
                } else if (otherElement.type === 'text') {
                    otherElement.value = '';
                }
            }
        });
    }




