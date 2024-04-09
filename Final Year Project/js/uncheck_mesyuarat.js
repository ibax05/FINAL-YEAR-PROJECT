    // Dapatkan semua elemen dalam kumpulan
    const elementsInGroup = document.querySelectorAll('input[id="mesyuarat"]');

    // Tambahkan pengendali acara untuk setiap elemen
    elementsInGroup.forEach(element => {
        if (element.type === 'checkbox') {
            element.addEventListener('click', handleElementChange);
        } else if (element.type === 'text') {
            element.addEventListener('input', handleElementChange);
        }
    });

    // Fungsi untuk mengendalikan perubahan pada elemen
    function handleElementChange(event) {
        // Nyahpilih semua checkbox lain dan kosongkan semua input teks lain
        elementsInGroup.forEach(otherElement => {
            if (otherElement !== event.target) {
                if (otherElement.type === 'checkbox') {
                    otherElement.checked = false;
                } else if (otherElement.type === 'text') {
                    otherElement.value = '';
                }
            }
        });
    }




