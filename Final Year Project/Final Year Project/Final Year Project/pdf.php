<?php                
require 'connection.php'; 
include_once('tcpdf_6_2_13/tcpdf/tcpdf.php');

$user_id = $_GET['user_id'];
$id_tempahan_makanan = $_GET['id_tempahan_makanan'];

$result =  mysqli_query($conn, "SELECT * FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND  user_id  = $user_id");            
$count = mysqli_num_rows($result);  
if($count>0) 
{
	$result = mysqli_fetch_array($result, MYSQLI_ASSOC);

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 002');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('times', 'BI', 20);

// add a page
$pdf->AddPage();

// set some text to print
$txt = <<<EOD

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>List of Requests</title>
   <script src="js/pdf.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
       integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <style>
       /* Custom CSS for list page */
       body {
           padding: 20px;
           font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           line-height: 1.6;`
           color: #333;
       }
       .request-item {
           margin-bottom: 30px;
           padding: 20px;
           border: 1px solid #ddd;
           border-radius: 8px;
           background-color: #fff;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
       }
       .btn {
           background-color: #007bff;
           color: #fff;
           border: none;
           padding: 10px 20px;
           border-radius: 5px;
           cursor: pointer;
           transition: background-color 0.3s ease;
           text-transform: uppercase;
           font-weight: bold;
       }
       .btn:hover {
           background-color: #0056b3;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
       }
       .container {
           max-width: 800px;
           margin: 0 auto;
       }
       .request-item {
           margin-bottom: 20px;
       }
       .request-item h3 {
           margin-bottom: 10px;
       }
       .request-item p {
           margin-bottom: 8px;
       }
       .fancy-button {
           display: block;
           margin: 0 auto;
           padding: 12px 24px;
           background-color: #ff2600;
           color: #fff;
           border: none;
           border-radius: 5px;
           font-size: 16px;
           font-weight: bold;
           text-transform: uppercase;
           box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
           transition: all 0.3s ease;
           cursor: pointer;
       }
       .fancy-button:hover {
           background-color: #c7231e;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
           transform: translateY(-2px);
       }
   </style>
</head>
<body >
   <div class="container" id="form">
       <h2 class="mb-4">List of Requests</h2>
       <div class="request-item">
           <h3>1. Agenda Mesyuarat</h3>
           <p><strong>Tujuan:</strong> ' . $result["tujuan"] . '</p>
           <p><strong>Tarikh Mula:</strong> <?php echo $result['tarikh_mula']; ?></p>
           <p><strong>Tarikh Akhir:</strong> <?php echo $result["tarikh_akhir"]; ?></p>
           <p><strong>Masa:</strong> <?php echo date("h:i A", strtotime($result["masa"])); ?></p>
           <p><strong>Bilangan Ahli:</strong> <?php echo $result["Bilangan_Ahli"]; ?></p>
       </div>
       <div class="request-item">
           <h3>2. Informasi Pegawai</h3>
           <p><strong>Nama Pegawai:</strong> <?php echo $result['Nama_Pegawai']; ?></p>
           <p><strong>Jawatan:</strong> <?php echo $result["Jawatan"]; ?></p>
           <p><strong>Unit Bahagian:</strong> <?php echo $result["Unit_Bahagian"]; ?></p>
           <p><strong>Tarikh Memohon:</strong> <?php echo $result["Tarikh_Memohon"]; ?></p>
       </div>
       <div class="request-item">
           <h3>3. Pengerusi Mesyuarat</h3>
           <?php if(!empty($result["ketua_pengarah"])) { ?>
           <p><strong>Ketua Pengarah:</strong> <?php echo $result['ketua_pengarah']; ?></p>
           <?php } ?>
           <?php if(!empty($result["Timbalan_Ketua_Pengarah"])) { ?>
           <p><strong>Timbalan Ketua Pengarah:</strong> <?php echo $result["Timbalan_Ketua_Pengarah"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Pengarah_Bahagian"])) { ?>
           <p><strong>Pengarah Bahagian:</strong> <?php echo $result["Pengarah_Bahagian"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["lain_lain_penegerusi_mesyuarat"])) { ?>
           <p><strong>Lain-lain pengerusi mesyuarat:</strong> <?php echo $result["lain_lain_penegerusi_mesyuarat"]; ?></p>
           <?php } ?>
       </div>
       <div class="request-item">
           <h3>4. Jenis Mesyuarat</h3>
           <?php if(!empty($result["Mesyuarat_dalaman"])) { ?>
           <p><strong>Mesyuarat Dalaman:</strong> <?php echo $result['Mesyuarat_dalaman']; ?></p>
           <?php } ?>
           <?php if(!empty($result["Luaran"])) { ?>
           <p><strong>Mesyuarat Luaran:</strong> <?php echo $result["Luaran"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Lawatan"])) { ?>
           <p><strong>Mesyuarat Luaran:</strong> <?php echo $result["Lawatan"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Lain_lain_jenis_mesyuarat"])) { ?>
           <p><strong>Lain-lain jenis mesyuarat:</strong> <?php echo $result["Lain_lain_jenis_mesyuarat"]; ?></p>
           <?php } ?>
       </div>
       <div class="request-item food-section">
           <h3>5. Makan/Minum</h3>
           <div class="food-details">
               <div class="sub-section">
                   <h5>5.1 Menu:</h5>
                   <?php if(!empty($result["Mengikut_cadangan"])) { ?>
                   <p><strong>Mengikut Cadangan:</strong> <?php echo $result['Mengikut_cadangan']; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["lain_lain_menu"])) { ?>
                   <p><strong>Lain-lain Menu:</strong> <?php echo $result["lain_lain_menu"]; ?></p>
                   <?php } ?>
               </div>
               <div class="sub-section">
                   <h5>5.2 Jenis Minuman:</h5>
                   <?php if(!empty($result["Kopi"])) { ?>
                   <p><strong>Kopi:</strong> <?php echo $result['Kopi']; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Teh"])) { ?>
                   <p><strong>Teh:</strong> <?php echo $result["Teh"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Air_Mineral"])) { ?>
                   <p><strong>Air Mineral:</strong> <?php echo $result["Air_Mineral"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Lain_Lain_jenis_minuman"])) { ?>
                   <p><strong>Lain-lain:</strong> <?php echo $result["Lain_Lain_jenis_minuman"]; ?></p>
                   <?php } ?>
               </div>
               <div class="sub-section">
                   <h5>5.3 Masa Makanan Perlu Disediakan:</h5>
                   <?php if(!empty($result["sebelum_mesyuarat"])) { ?>
                   <p><strong>Sebelum Mesyuarat:</strong> <?php echo $result['sebelum_mesyuarat']; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Semasa_Mesyuarat"])) { ?>
                   <p><strong>Semasa Mesyuarat:</strong> <?php echo $result["Semasa_Mesyuarat"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Selepas_Mesyuarat"])) { ?>
                   <p><strong>Selepas Mesyuarat:</strong> <?php echo $result["Selepas_Mesyuarat"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["lain_lain_Makanan_Perlu_Disediakan"])) { ?>
                   <p><strong>Lain-lain:</strong> <?php echo $result["lain_lain_Makanan_Perlu_Disediakan"]; ?></p>
                   <?php } ?>
               </div>
               <div class="sub-section">
                   <h5>5.4 Jenis Hidangan:</h5>
                   <?php if(!empty($result["sarapan_pagi"])) { ?>
                   <p><strong>Sarapan Pagi:</strong> <?php echo $result['sarapan_pagi']; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Minum_pagi"])) { ?>
                   <p><strong>Minum Pagi:</strong> <?php echo $result["Minum_pagi"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Makan_Tengahari"])) { ?>
                   <p><strong>Makan Tengahari:</strong> <?php echo $result["Makan_Tengahari"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Minum_petang"])) { ?>
                   <p><strong>Minum Petang:</strong> <?php echo $result["Minum_petang"]; ?></p>
                   <?php } ?>
               </div>
               <div class="sub-section">
                   <h5>5.5 Cara Hidangan:</h5>
                   <?php if(!empty($result["Di_dalam_Bilik_Mesyuarat"])) { ?>
                   <p><strong>Di dalam Bilik Mesyuarat:</strong> <?php echo $result['Di_dalam_Bilik_Mesyuarat']; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Diluar_Bilik_Mesyuarat"])) { ?>
                   <p><strong>Di luar Bilik Mesyuarat:</strong> <?php echo $result["Diluar_Bilik_Mesyuarat"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Buffet"])) { ?>
                   <p><strong>Buffet:</strong> <?php echo $result["Buffet"]; ?></p>
                   <?php } ?>
                   <?php if(!empty($result["Hidangan_Vip"])) { ?>
                   <p><strong>Hidangan VIP:</strong> <?php echo $result["Hidangan_Vip"]; ?></p>
                   <?php } ?>
               </div>
           </div>
       </div>
       <button class="fancy-button" onclick="navigateToPDF()">Convert To PDF</button>
   </div>

<script>
function navigateToPDF() {
    var user_id = "<?php echo $user_id; ?>"; // Dapatkan nilai user_id dari PHP
    var id_tempahan_makanan = "<?php echo $id_tempahan_makanan; ?>"; // Dapatkan nilai id_tempahan_makanan dari PHP
    var url = "pdf.php?user_id=" + user_id + "&id_tempahan_makanan=" + id_tempahan_makanan; // Bina URL dengan parameter
    window.location.href = url;
}</script>

</body>
</html>

EOD;

// print a block of text using Write()
$pdf->Write(0, $txt, '', 0, 'C', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('example_002.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

//----- End Code for generate pdf
	
}
else
{
	echo 'Record not found for PDF.';
}

?>