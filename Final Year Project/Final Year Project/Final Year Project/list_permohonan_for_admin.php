<?php

include("connection.php");

if(isset($_GET['id_tempahan_makanan']) && isset($_GET['user_id']) ) {
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
    <title>Senarai Permohonan</title>
    
   <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
			  filename:     'Report_Pemohon_<?php echo $result['id_tempahan_makanan'];?>_<?php echo date('Ymd'); ?>_<?php echo $result['Nama_Pegawai']; ?>_<?php echo $result['Unit_Bahagian']; ?>.pdf',
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
        body {
            background-color: #f8f9fa;
        }
        .table {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 10px;
        }
        .table:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>
    <div class="container my-5">
                <div class="row">
            <div class="col-md-6">
                <h1 class="mb-4">Senarai Permohonan</h1>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn  btn-danger btn_print">Convert to PDF</button>
            </div>
        </div>
        <table class="table table-bordered" id="container_content">
            <tr>
                <th colspan="2">1.Informasi Pegawai</th>
            </tr>
            <tr>
                <td>Nama Pegawai:</td>
                <td><?php echo $result['Nama_Pegawai']; ?></td>
            </tr>
            <tr>
                <td>Jawatan:</td>
                <td><?php echo $result["Jawatan"]; ?></td>
            </tr>
            <tr>
                <td>Unit/Bahagian:</td>
                <td><?php echo $result["Unit_Bahagian"]; ?></td>
            </tr>
            <tr>
                <td>Tarikh Permohonan:</td>
                <td><?php echo $result["Tarikh_Memohon"]; ?></td>
            </tr>
            <tr>
                <th colspan="2">2.Agenda Mesyuarat</th>
            </tr>
            <tr>
                <td>Tujuan:</td>
                <td><?php echo $result["tujuan"]; ?></td>
            </tr>
            <tr>
                <td>Tarikh Mula:</td>
                <td><?php echo $result['tarikh_mula']; ?></td>
            </tr>
            <tr>
                <td>Tarikh Akhir:</td>
                <td><?php echo $result["tarikh_akhir"]; ?></td>
            </tr>
            <tr>
                <td>Masa:</td>
                <td><?php echo date("h:i A", strtotime($result["masa"])); ?></td>
            </tr>
            <tr>
                <td>Bilangan Ahli:</td>
                <td><?php echo $result["Bilangan_Ahli"]; ?></td>
            </tr>
            <tr>
                <th colspan="2">3.Pengerusi Mesyuarat</th>
            </tr>
            <tr>
                <td>Jenis pengerusi mesyuarat:</td>
                <td>
                    <?php if(!empty($result["ketua_pengarah"])) { ?>
                        <?php echo $result['ketua_pengarah']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Timbalan_Ketua_Pengarah"])) { ?>
                        <?php echo $result['Timbalan_Ketua_Pengarah']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Pengarah_Bahagian"])) { ?>
                        <?php echo $result['Pengarah_Bahagian']; ?>
                    <?php } ?>
                    <?php if(!empty($result["lain_lain_penegerusi_mesyuarat"])) { ?>
                        <?php echo $result['lain_lain_penegerusi_mesyuarat']; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">4.Jenis Mesyuarat</th>
            </tr>

            <tr>
                <td>Jenis mesyuarat:</td>
                <td>
                    <?php if(!empty($result["Mesyuarat_dalaman"])) { ?>
                        <?php echo $result['Mesyuarat_dalaman']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Luaran"])) { ?>
                        <?php echo $result['Luaran']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Lawatan"])) { ?>
                        <?php echo $result['Lawatan']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Lain_lain_jenis_mesyuarat"])) { ?>
                        <?php echo $result['Lain_lain_jenis_mesyuarat']; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <th colspan="2">5.Makan/Minum</th>
            </tr>
            <?php if(!empty($result["sarapan_pagi_Minum_pagi"])){ ?>
            <tr>
                <td>Set Sarapan Pagi:</td>
                <td>
                <?php echo $result['sarapan_pagi_Minum_pagi']; ?>
                </td>
            </tr>
            <?php   } ?>
            <?php if(!empty($result["Makan_Tengahari"])){ ?>
            <tr>
                <td>Set Makan Tengahari:</td>
                <td>
                <?php echo $result['Makan_Tengahari']; ?>
                </td>
            </tr>
            <?php   } ?>
            <?php if(!empty($result["Minum_petang"])){ ?>
            <tr>
                <td>Set Minum Petang:</td>
                <td>
                <?php echo $result['Minum_petang']; ?>
                </td>
            </tr>
            <?php   } ?>
            <tr>
                <td>Masa makanan perlu disediakan:</td>
                <td>
                    <?php if(!empty($result["sebelum_mesyuarat"])) { ?>
                        <?php echo $result['sebelum_mesyuarat']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Semasa_Mesyuarat"])) { ?>
                        <?php echo $result['Semasa_Mesyuarat']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Selepas_Mesyuarat"])) { ?>
                        <?php echo $result['Selepas_Mesyuarat']; ?>
                    <?php } ?>
                    <?php if(!empty($result["lain_lain_Makanan_Perlu_Disediakan"])) { ?>
                        <?php echo $result['lain_lain_Makanan_Perlu_Disediakan']; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>Cara hidangan:</td>
                <td>
                    <?php if(!empty($result["Di_dalam_Bilik_Mesyuarat"])) { ?>
                        <?php echo $result['Di_dalam_Bilik_Mesyuarat']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Diluar_Bilik_Mesyuarat"])) { ?>
                        <?php echo $result['Diluar_Bilik_Mesyuarat']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Buffet"])) { ?>
                        <?php echo $result['Buffet']; ?>
                    <?php } ?>
                    <?php if(!empty($result["Hidangan_Vip"])) { ?>
                        <?php echo $result['Hidangan_Vip']; ?>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="text-center">
                    <a href="view_memo.php?id_tempahan_makanan=<?php echo $result['id_tempahan_makanan']; ?>&user_id=<?php echo $result['user_id']; ?>" class="btn btn-primary">Lihat Memo</a>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
<?php
}
?>