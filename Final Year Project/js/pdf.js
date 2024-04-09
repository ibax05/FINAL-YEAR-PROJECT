window.onload = function () {
    document.getElementById("download")
        .addEventListener("click", () => {

            const form = this.document.getElementById("form");
            console.log(form);
            console.log(window);
            var element = document.getElementById('element-to-print');
            var opt = {
                margin: 1,
                filename: 'myfile.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', orientation: 'portrait' }
            };
            html2pdf().from(form).set(opt).save();

        })
}