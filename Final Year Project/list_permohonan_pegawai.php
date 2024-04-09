<?php

include("connection.php");

if(isset($_GET['user_id']) && isset($_GET['id_tempahan_makanan']) ) {
    $user_id = $_GET['user_id'];
    $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

    // Query untuk mendapatkan detail permohonan berdasarkan ID pengguna
    $result =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND  user_id  = $user_id"));
    $memo_path = $result['memo_path'];
    $memo_name = basename($memo_path);
    $previous_memo = $result['memo_name']; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Senarai permohonan yang dipohon</title>
   <script src="js/pdf.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
       integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js" ></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script type="text/javascript">
	$(document).ready(function($) 
	{ 

		$(document).on('click', '.btn_print', function(event) 
		{
			event.preventDefault();

			//credit : https://ekoopmans.github.io/html2pdf.js
			
			var element = document.getElementById('container_content'); 

			//easy
			//html2pdf().from(element).save();

			//custom file name
			//html2pdf().set({filename: 'code_with_mark_'+js.AutoCode()+'.pdf'}).from(element).save();


			//more custom settings
			var opt = 
			{
			  margin:       1.1,
			  filename:     'Report'+'.pdf',
			  image:        { type: 'jpeg', quality: 0.98 },
			  html2canvas:  { scale: 2 },
			  jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
			};

			// New Promise-based usage:
			html2pdf().set(opt).from(element).save();

			 
		});

 
 
	});
	</script>
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
<body  >

   <div class="container" id="container_content">
       <h2 class="mb-4">Senarai permohonan yang dipohon</h2>
       <div class="request-item">
           <h3>1. Agenda Mesyuarat</h3>
           <p><strong>Tujuan:</strong> <?php echo $result["tujuan"]; ?></p>
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
           <p><strong>Jenis Pengerusi Mesyuarat:</strong> <?php echo $result['ketua_pengarah']; ?></p>
           <?php } ?>
           <?php if(!empty($result["Timbalan_Ketua_Pengarah"])) { ?>
           <p><strong>Jenis Pengerusi Mesyuarat:</strong> <?php echo $result["Timbalan_Ketua_Pengarah"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Pengarah_Bahagian"])) { ?>
           <p><strong>Jenis Pengerusi Mesyuarat:</strong> <?php echo $result["Pengarah_Bahagian"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["lain_lain_penegerusi_mesyuarat"])) { ?>
           <p><strong>Jenis Pengerusi Mesyuarat:</strong> <?php echo $result["lain_lain_penegerusi_mesyuarat"]; ?></p>
           <?php } ?>
       </div>
       <div class="request-item">
           <h3>4. Jenis Mesyuarat</h3>
           <?php if(!empty($result["Mesyuarat_dalaman"])) { ?>
           <p><strong>Mesyuarat :</strong> <?php echo $result['Mesyuarat_dalaman']; ?></p>
           <?php } ?>
           <?php if(!empty($result["Luaran"])) { ?>
           <p><strong>Mesyuarat :</strong> <?php echo $result["Luaran"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Lawatan"])) { ?>
           <p><strong>Mesyuarat :</strong> <?php echo $result["Lawatan"]; ?></p>
           <?php } ?>
           <?php if(!empty($result["Lain_lain_jenis_mesyuarat"])) { ?>
           <p><strong>Mesyuarat:</strong> <?php echo $result["Lain_lain_jenis_mesyuarat"]; ?></p>
           <?php } ?>
       </div>
       <div class="request-item food-section">
           <h3>5. Makan/Minum</h3><br><br>
           <div class="food-details">
               <div class="sub-section">
                   <h5>5.1 Menu:</h5>
                
                <?php if(!empty($result["sarapan_pagi_Minum_pagi"])){ ?>
                <p><strong>Set Sarapan Pagi:</strong> <?php echo $result['sarapan_pagi_Minum_pagi']; ?></p>
                <?php   } ?>

               
                <?php if(!empty($result["Makan_Tengahari"])){ ?>
                <p><strong>Set Makanan Tengahari:</strong> <?php echo $result['Makan_Tengahari']; ?></p>
                <?php   } ?>

                <?php if(!empty($result["Minum_petang"])){ ?>
                <p><strong>Set Minum Petang:</strong> <?php echo $result['Minum_petang']; ?></p>
                <?php   } ?>
               </div>
               <div class="sub-section">
               <br><h5>5.2 Masa Makanan Perlu Disediakan:</h5>
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
               <br><h5>5.3 Cara Hidangan:</h5>
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
       
   </div>
   <button class="fancy-button btn_print" >Convert To PDF</button>


</body>
</html>



<?php



    }

?>

