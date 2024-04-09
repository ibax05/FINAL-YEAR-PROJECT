<?php
session_start();
include("connection.php");

if(isset($_GET['user_id']) && isset($_GET['id_tempahan_makanan'])) {
    $user_id = $_GET['user_id'];
    $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

    // Query untuk mendapatkan detail permohonan berdasarkan ID pengguna
    $result =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id  = $user_id"));
    $memo_path = $result['memo_path'];
    $memo_name = basename($memo_path);
    $previous_memo = $result['memo_name']; 

    $set_makanan_pagi = $result["sarapan_pagi_Minum_pagi"];
    $set_makanan_tengahari = $result["Makan_Tengahari"];
    $set_minum_petang = $result["Minum_petang"];





    // Tampilkan detail permohonan dalam bentuk form atau informasi
    // Anda dapat menyesuaikan tata letak dan tampilan sesuai kebutuhan Anda
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Permohonan</title>
    <!-- Include file CSS dan Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Poppins', sans-serif;
  background: #edf5ff; 
}

.form-container {
  background: #fff;
  width: 500px;
  padding: 30px;
  margin: 50px auto;
  border-radius: 10px;
  box-shadow: 2px 4px 16px rgba(0,0,0,.1);  
}
/*Tambahkan animasi saat focus:*/
input:focus,
textarea:focus {
border-color: #6c757d;
outline: none;
}
/* Judul & Sub Judul Form */
h2, 
h4 {
  text-align: center; 
  margin-bottom: 50px;
}



h2 {
  color: #3c6382;
}

h4 {
  font-weight: 500;
}

h6
{
    text-align : center;
}

/* Label Field */
label {
  display: block;
  font-size: 14px;
  color: #47525d;  
}


span
{
    color:red;
}

/* Field Input, Textarea, Select */
input, 
textarea,
select {
  width: 100%;
  padding: 10px 15px;
  border-radius: 5px;
  border: 1px solid #bbb;
  outline: none;
  margin-bottom: 20px;  
}

/* Tombol */  
button {
  display: inline-block;
  padding: 12px 28px;  
  border-radius: 5px; 
  background-color: #6d98e7;
  color: white; 
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

button:hover {
  transform: scale(1.05);
  box-shadow: 2px 4px 12px rgba(0,0,0,.1);
}

.custom-alert {
        max-width: 400px;
        margin: 0 auto;
        margin-top: 20px;
    }
    .button-container {
    display: flex;
    justify-content: space-between;
    margin-top: 20px;
}
  </style>
</head>
<body>
<?php if (isset($_SESSION['error'])): ?>
    <div id="error" class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?php echo ($_SESSION['error']); ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['updated'])): ?>
    <div id="updated" class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?php echo ($_SESSION['updated']); ?>
        <?php unset($_SESSION['updated']); ?>
    </div>
<?php endif; ?>
<div class="form-container">
<h2>Update Permohonan</h2>
    <form method="post" action="process_update _permohonan_pegawai.php " enctype="multipart/form-data">
        <!-- Tampilkan detail permohonan dalam form -->
        <!-- Contoh: -->


            <h3>1. Agenda Mesyuarat</h3><br>

            <h5>Tarikh Mula: </h5>
            <input type="hidden" name="user_id" value="<?php echo $result['user_id']; ?>">
            <input type="hidden" name="id_tempahan_makanan" value="<?php echo $result['id_tempahan_makanan']; ?>">
            <?php if(!empty( $result["tarikh_mula"])) { ?>
               <input type="date" name="tarikh_mula" value="<?php echo $result['tarikh_mula']; ?>" ><br>
            <?php } ?>

            <h5>Tarikh Akhir: </h5>
            <?php if(!empty($result["tarikh_akhir"])) { ?>
              <input type="date" name="tarikh_akhir" value="<?php echo $result["tarikh_akhir"]; ?>"><br>
            <?php } ?>

            <h5>Masa: </h5>
            <?php if(!empty($result["masa"])) { ?>
               <input type="time" name="masa" value="<?php echo $result["masa"]; ?>" ><br>
            <?php }  ?>

            <h5>Tujuan: </h5>
             <?php if(!empty($result["tujuan"])) { ?>
               <input type="text" name="tujuan" value="<?php echo $result["tujuan"]; ?> "><br>
            <?php } ?>

            <h5>Bilangan Ahli: </h5>
            <?php if(!empty($result["Bilangan_Ahli"])) { ?>
               <input type="text" name="Bilangan_Ahli" placeholder="30 " value="<?php echo $result["Bilangan_Ahli"]; ?> "><br>
            <?php } ?>    


            <h3>2. Informasi Pegawai</h3><br>
            <h5>Nama Pegawai: </h5>
            <?php if(!empty( $result["Nama_Pegawai"])) { ?>
               <input type="text" name="Nama_Pegawai" value="<?php echo $result['Nama_Pegawai']; ?>" ><br>
            <?php } ?>

            <h5>Jawatan: </h5>
            <?php if(!empty($result["Jawatan"])) { ?>
              <input type="text" name="Jawatan" value="<?php echo $result["Jawatan"]; ?>"><br>
            <?php } ?>

            <h5>Unit Bahagian: </h5>
            <?php if(!empty($result["Unit_Bahagian"])) { ?>
              <select name="Unit_Bahagian" id="unitBahagian" >
              <option value="<?php echo $result["Unit_Bahagian"]; ?>"><?php echo $result["Unit_Bahagian"]; ?></option>
              <option value="Bahagian Rawatan,Perubatan Dan Pemulihan">Bahagian Rawatan,Perubatan Dan Pemulihan</option>
              <option value="Bahagian Penguatkuasaan Dan Keselamatan">Bahagian Penguatkuasaan Dan Keselamatan</option>
              <option value="Bahagian Pencegahan">Bahagian Pencegahan</option>
              <option value="Bahagian Khidmat Pengurusan">Bahagian Khidmat Pengurusan</option>
              <option value="Bahagian Dasar,Perancangan Dan Penyelidikan">Bahagian Dasar,Perancangan Dan Penyelidikan</option>
              <option value="Bahagian Teknologi Maklumat Dan Komunikasi">Bahagian Teknologi Maklumat Dan Komunikasi</option>
              <option value="Unit Integriti">Unit Integriti</option>
              <option value="Unit Antarabangsa">Unit Antarabangsa</option>
              <option value="Unit Penasihat Undang-Undang">Unit Penasihat Undang-Undang</option>
              <option value="Unit Media & Komunikasi Korporat">Unit Media & Komunikasi Korporat</option>
              <option value="Unit Urus Setia Penyelarasan Pelaksanaan Dasar (MGDN)">Unit Urus Setia Penyelarasan Pelaksanaan Dasar (MGDN)</option>
              </select><br>
            <?php }  ?>

            <h5>Tarikh Memohon: </h5>
            <?php if(!empty($result["Tarikh_Memohon"])) { ?>
              <input type="date" name="Tarikh_Memohon" value="<?php echo $result["Tarikh_Memohon"]; ?>"><br>
            <?php } ?>

 

                
            <h3>3. Pengurusi Mesyuarat</h3>
            <?php if(!empty( $result["ketua_pengarah"])) { ?>
            <input type="text" name="ketua_pengarah" value="<?php echo $result['ketua_pengarah']; ?>" ><br>
             <?php } ?>

            <?php if(!empty($result["Timbalan_Ketua_Pengarah"])) { ?>
              <input type="text" name="Timbalan_Ketua_Pengarah" value="<?php echo $result["Timbalan_Ketua_Pengarah"]; ?>"><br>
                <?php } ?>

            <?php if(!empty($result["Pengarah_Bahagian"])) { ?>
               <input type="text" name="Pengarah_Bahagian" value="<?php echo $result["Pengarah_Bahagian"]; ?>" ><br>
            <?php }  ?>

             <?php if(!empty($result["lain_lain_penegerusi_mesyuarat"])) { ?>
               <input type="text" name="lain_lain_penegerusi_mesyuarat" value="<?php echo $result["lain_lain_penegerusi_mesyuarat"]; ?> "><br>
                <?php } ?>

                



             <h3>4. Jenis Mesyuarat </h3>
             <?php if(!empty($result["Mesyuarat_dalaman"]))  {?>
                <input type="text" id="tujuan" name="Mesyuarat_dalaman" value="<?php echo $result["Mesyuarat_dalaman"];  ?>" ><br>
            <?php } ?>

            <?php if(!empty($result["Luaran"])) { ?>  
                <input type="text" id="tujuan" name="Luaran" value="<?php echo $result["Luaran"]; ?>" ><br>
            <?php } ?>

            <?php if(!empty($result["Lawatan"])) { ?>
                <input type="text" id="tujuan" name="Lawatan" value="<?php echo  $result["Lawatan"]; ?>" ><br>
            <?php    } ?>


            <?php if(!empty($result["Lain_lain_jenis_mesyuarat"])) { ?>  
                  <input type="text" id="tujuan" name="Lain_lain_jenis_mesyuarat" value="<?php echo $result["Lain_lain_jenis_mesyuarat"];  ?>" ><br>
            <?php    }  ?>




            <br><h3>5. Makan/Minum </h3><br>

                <h5>5.1 menu</h5>
                
                <?php if(!empty($result["sarapan_pagi_Minum_pagi"]))   {?>
                  <?php echo "Set Makanan Pagi: "?>
                  <input type="text" id="tujuan" name="sarapan_pagi_Minum_pagi" value="<?php  echo $result["sarapan_pagi_Minum_pagi"]; ?>" ><br>
                <?php    } ?>

               
                <?php if(!empty($result["Makan_Tengahari"])){ ?>
                  <?php echo "Set Makanan Tengahari: "?>
                    <input type="text" id="tujuan" name="Makan_Tengahari" value=" <?php echo $result["Makan_Tengahari"]; ?>" ><br>
                <?php   } ?>

                <?php if(!empty($result["Minum_petang"])){ ?>
                  <?php echo "Set Minum Petang: "?>
                    <input type="text" id="tujuan" name="Minum_petang" value=" <?php echo $result["Minum_petang"]; ?>" ><br>
                <?php   } ?>





                   <h5>5.3 Masa Makanan Perlu Disediakan:</h5>
                <?php   if(!empty($result["sebelum_mesyuarat"])) { ?>     
                <input type="text" id="tujuan" name="sebelum_mesyuarat" value="<?php echo $result["sebelum_mesyuarat"]; ?> " ><br>
                <?php    } ?>


                <?php   if(!empty($result["Semasa_Mesyuarat"])) { ?> 
                <input type="text" id="tujuan" name="Semasa_Mesyuarat" value="<?php echo $result["Semasa_Mesyuarat"]; ?> " ><br>
                <?php   } ?>


                <?php     if(!empty($result["Selepas_Mesyuarat"])) { ?>     
                <input type="text" id="tujuan" name="Selepas_Mesyuarat" value="<?php echo $result["Selepas_Mesyuarat"]; ?>" ><br>
                <?php        } ?>

                <?php   if(!empty($result["lain_lain_Makanan_Perlu_Disediakan"])) { ?>   
                <input type="text" id="tujuan" name="lain_lain_Makanan_Perlu_Disediakan" value="<?php echo $result["lain_lain_Makanan_Perlu_Disediakan"]; ?>" ><br>
                <?php        } ?>






                    <h5>5.5 Cara Hidangan:</h5>
                <?php    if(!empty($result["Di_dalam_Bilik_Mesyuarat"])) { ?>            
                <input type="text" id="tujuan" name="Di_dalam_Bilik_Mesyuarat" value="<?php echo $result["Di_dalam_Bilik_Mesyuarat"]; ?>" ><br><br>
                <?php            } ?>       

                <?php     if(!empty($result["Diluar_Bilik_Mesyuarat"])) { ?> 
                <input type="text" id="tujuan" name="Diluar_Bilik_Mesyuarat" value="<?php echo $result["Diluar_Bilik_Mesyuarat"]; ?>" ><br><br>
                <?php            } ?> 

                <?php     if(!empty($result["Buffet"])) { ?>
                <input type="text" id="tujuan" name="Buffet" value="<?php echo $result["Buffet"]; ?>" ><br><br>
                <?php   } ?>
  
                <?php     if(!empty($row["Hidangan_Vip"])) { ?>
                <input type="text" id="tujuan" name="Hidangan_Vip" value="<?php echo $result["Hidangan_Vip"]; ?>" ><br><br>
                <?php            } ?>


               






 




         <h6>******Upload new memo or file******</h6>
        <input type="file" name="new_memo">
        <label>File Terupload Sebelumnya: <a href="view_memo.php?id_tempahan_makanan=<?php echo $result['id_tempahan_makanan']; ?>&user_id=<?php echo $result['user_id']; ?>"> <span><?php echo $result["memo_name"] ?></span></a></label><br>
        <!-- Tambahkan tombol submit untuk menyimpan perubahan -->
        <div class="button-container">
            <a href="progress-permohonan.php?id=<?php echo $result['user_id']; ?>" class="btn btn-secondary">Patah Balik</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script>
            setTimeout(function() {
                document.getElementById('updated').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
</body>
</html>
<?php

}

?>
