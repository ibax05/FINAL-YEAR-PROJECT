<?php
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
include("connection.php");


if(isset($_SESSION['id']) || isset($_GET['id'])) {
    $id = $_SESSION['id'];

    // Query untuk mendapatkan detail permohonan berdasarkan ID pengguna
    $result =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM register  WHERE id = $id"));

    $result_sarapan = mysqli_query($conn, "SELECT * FROM sarapan_pagi");
    $result_tengahari = mysqli_query($conn, "SELECT * FROM makanan_tengahari");
    $result_petang = mysqli_query($conn, "SELECT * FROM minum_petang");









?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/forms.css">
    <style>
        .error-message {
    color: red;
    font-weight: bold;
    display: none;
    }

    .custom-alert {
        max-width: 400px;
        margin: 0 auto;
        margin-top: 20px;
    }
    </style>

</head>
<header>
    <nav class="navbar fixed-top">
        <div class="container-fluid">
            <div class="brand">
                <img src="img/logo.jpeg" alt="bootstrap 4 login page" width=" 78 / 1">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column p-0">
                    <nav class="nav flex-column flex-grow-1">
                        <a href="form.php?id=<?= $result["id"] ?>" class="nav-link text-dark fw-bold py-3 px-4 border-bottom">
                        <i class="fa-solid fa-house"></i> Rumah
                        </a>

                        <a href="progress-permohonan.php?id=<?= $result["id"] ?>" class="nav-link text-dark py-3 px-4 border-bottom">
                        <i class="fa-solid fa-hourglass-start"></i> Status Permohonan
                        </a>

                        <a href="update_profile.php?id=<?= $result["id"] ?>" class="nav-link text-dark py-3 px-4 border-bottom">
                        <i class="fa-solid fa-user"></i> Profil
                        </a>
                    </nav>

                    <div class="mt-auto">
                        <a href="logout.php" class="nav-link text-dark py-3 px-4">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>    
    </nav>
</header>

<body>
        <!-- Letakkan notifikasi di sini -->
        <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
        <?php header("Refresh: 5; url=form.php"); ?>
    <?php endif; ?>

    <?php if (isset($_GET['submitted'])): ?>
        <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            <?php echo htmlspecialchars($_GET['submitted']); ?>
        </div>
        <?php header("Refresh: 5; url=form.php"); ?>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?php echo htmlspecialchars($_SESSION['error']); ?>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['updated'])): ?>
    <div class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?php echo htmlspecialchars($_SESSION['updated']); ?>
        <?php unset($_SESSION['updated']); ?>
    </div>
<?php endif; ?>

    <h2>
        TEMPAHAN MAKAN DAN MINUM UNTUK MESYUARAT
    </h2>
    <p class="memo-text">***Permohonan mestilah bersertakan memo***</p>

    <form method="post" action="process_form.php" enctype="multipart/form-data" onsubmit="return validateForm(event)"> 


        <div class="side-nav">
            <div class="tajuk-Agenda-Mesyuarat">
                <h4>1. Agenda Mesyuarat</h4>
            </div>
        </div>
        

        <div class="Agenda-Mesyuarat" id="agendaSection">

            <div>
                <input type="hidden" name="id" value="<?php echo $id ?>">
                <label for="tarikh">Tarikh Mula:<span class="mandatory">*</span></label>
                <input type="date" id="tarikh" name="tarikh_mula" >
            </div>

            <div>
                <label for="tarikh">Tarikh Akhir:<span class="mandatory">*</span></label>
                <input type="date" id="tarikh" name="tarikh_akhir" >
            </div>

            <div>
                <label for="masa">Masa:<span class="mandatory">*</span></label>
                <input type="time" id="masa" name="masa" >
            </div>

            <div>
                <label for="tujuan">Tujuan:<span class="mandatory">*</span></label>
                <input type="text" id="tujuan" name="tujuan" >
            </div>

            <div>
                <label for="Bilangan Ahli">Bilangan Ahli:<span class="mandatory">*</span></label>
                <input type="number" id="bilik" name="Bilangan_Ahli" min="1">
            </div>

        </div>



        <div class="side-nav">
            <div class="tajuk-Informasi-Pegawai">
                <h4>2. Informasi Pegawai</h4>
            </div>
        </div>

        <div class="Pegawai-pemohon" id="pegawaiSection">
            <div>
                <label for="Nama pegawai pemohon">Nama pegawai:<span class="mandatory" required>*</span></label>
                <input type="text" id="Nama pegawai pemohon" name="Nama_pegawai_pemohon" required>
            </div>

            <div>
                <label for="Jawatan">Jawatan(GRED):<span class="mandatory">*</span></label>
                <input type="text" id="Jawatan" name="Jawatan" >
            </div>

            <div>
                <label for="Unit / Bahagian">Unit / Bahagian:<span class="mandatory">*</span></label>
                <select name="Unit_Bahagian" id="unitBahagian" required>
                <option value="">-- Sila pilih unit/bahagian --</option>
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
                </select>
                <span id="unitBahagianError" class="error-message"></span>
            </div>

            <div>
                <label for="Tarikh memohon">Tarikh memohon:<span class="mandatory">*</span></label>
                <input type="date" id="Tarikh memohon" name="Tarikh_memohon" >
            </div>


        </div>

        <div class="side-nav">
            <div class="tajuk-Pengurusi-Mesyuarat">
                <h4>3. Pengurusi Mesyuarat <span class="mandatory">*</span></h4>
            </div>
        </div>

        <div class="Pengerusi-Mesyuarat" id="pengerusiSection">

            <div class="row">
                <div>
                    <label>3.1 Ketua Pengarah</label>
                    <input type="checkbox" id="pengerusi" name="Ketua_Pengarah">
                </div>

                <div>
                    <label>3.2 Timbalan Ketua Pengarah</label>
                    <input type="checkbox" id="pengerusi" name="Timbalan_Ketua_Pengarah">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>3.3 Pengarah Bahagian</label>
                    <input type="checkbox" id="pengerusi" name="Pengarah_Bahagian">
                </div>

                <div>
                    <label>3.4.Lain-lain:</label>
                    <input type="text" id="pengerusi" name="Lain_Lain_Pengerusi_Mesyuarat">
                </div>
            </div>

        </div>

        <div class="kadar-makan-minum">

            <div class="tajuk-kadar-makan-minum">
                <p>Kadar Makan & Minum:-</p>
            </div>

            <div class="image-kadar-makan-minum">
                <img src="img/table-makanan.jpg">
            </div>



        </div>

        <div class="side-nav">
            <div class="tajuk-Jenis-Mesyuarat">
                 <h4>4. Jenis Mesyuarat <span class="mandatory">*</span></h4>
            </div>
        </div>

        <div class="Jenis-Mesyuarat" id="JenisMesyuaratSection">

            <div class="row">
                <div>
                    <label>4.1 Mesyuarat Dalaman</label>
                    <input type="checkbox" id="mesyuarat" name="mesyuarat_Dalaman">
                </div>

                <div>
                    <label>4.2 Luaran</label>
                    <input type="checkbox" id="mesyuarat" name="Luaran">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>4.3 Lawatan</label>
                    <input type="checkbox" id="mesyuarat" name="Lawatan">
                </div>

                <div>
                    <label>4.4.Lain-lain:</label>
                    <input type="text" id="mesyuarat" name="Lain_Lain_Jenis_Mesyuarat">
                </div>
            </div>

        </div>


        <div class="side-nav">
            <div class="tajuk-Makan-Minum">
                 <h4>5. Makan/Minum <span class="mandatory">*</span></h4>
            </div>
        </div>
        <div class="side-nav">
            <div class="sub-tajuk">
                 <h6> 5.1 Menu:</h6>
            </div>
        </div>
        <div class="menu" id="id_menu">
  <h5>Makanan Pagi</h5>
  <table>
    <tr>
      <th>Jenis Set</th>
      <th>Menu</th>
      <th>Tandakan di mana yang berkaitan</th>
    </tr>
    <?php
    while ($row = $result_sarapan->fetch_assoc()) {
      $set_name = $row["Set_makanan"];
      $menu_items = explode(",", $row["Menu"]);

      $set_name_only = substr($set_name, 0, strpos($set_name, '('));
      $set_lowercase = strtolower($set_name_only);

      $set_lowercase = strtolower(str_replace(' ', '_', $set_lowercase));
      echo "<tr>";
      echo "<td>$set_name</td>";
      echo "<td><ul>";
      foreach ($menu_items as $item) {
        echo "<li>" . trim($item) . "</li>";
      }
      echo "</ul></td>";
      echo "<td class='checkbox-cell'>";
      echo "<label>";
      echo "<input type='checkbox' name='" . $set_lowercase . "makanan_pagi'>";
      echo "<span class='checkmark'></span>";
      echo "</label>";
      echo "</td>";
      echo "</tr>";
    }
    ?>
  </table>

  <h5>Makanan Tengahari</h5>
  <table>
    <tr>
      <th>Jenis Set</th>
      <th>Menu</th>
      <th>Tandakan di mana yang berkaitan</th>
    </tr>
    <?php
    while ($row = $result_tengahari->fetch_assoc()) {
      $set_name = $row["Set_Makanan"];
      $menu_items = explode(",", $row["Menu"]);
      $set_name_only = substr($set_name, 0, strpos($set_name, '('));
      $set_lowercase = strtolower($set_name_only);
      $set_lowercase = str_replace(' ', '_', $set_lowercase);
      echo "<tr>";
      echo "<td>$set_name</td>";
      echo "<td><ul>";
      foreach ($menu_items as $item) {
        echo "<li>" . trim($item) . "</li>";
      }
      echo "</ul></td>";
      echo "<td class='checkbox-cell'>";
      echo "<label>";
      echo "<input type='checkbox' name='" . $set_lowercase . "makanan_tengahari'>";
      echo "<span class='checkmark'></span>";
      echo "</label>";
      echo "</td>";
      echo "</tr>";
    }
    ?>
  </table>

  <h5>Minum Petang</h5>
  <table>
    <tr>
      <th>Jenis Set</th>
      <th>Menu</th>
      <th>Tandakan di mana yang berkaitan</th>
    </tr>
    <?php
    while ($row = $result_petang->fetch_assoc()) {
      $set_name = $row["Set_Makanan"];
      $menu_items = explode(",", $row["Menu"]);

      // Ekstrak nama set sahaja (tanpa harga)
      $set_name_only = substr($set_name, 0, strpos($set_name, '('));
      
      $set_lowercase = strtolower($set_name_only);
      $set_lowercase = str_replace(' ', '_', $set_lowercase);
      echo "<tr>";
      echo "<td>$set_name</td>";
      echo "<td><ul>";
      foreach ($menu_items as $item) {
        echo "<li>" . trim($item) . "</li>";
      }
      echo "</ul></td>";
      echo "<td class='checkbox-cell'>";
      echo "<label>";
      echo "<input type='checkbox' name='" . $set_lowercase . "minum_petang'>";
      echo "<span class='checkmark'></span>";
      echo "</label>";
      echo "</td>";
      echo "</tr>";
    }
    ?>
  </table>
</div>


        
        


        <div class="side-nav">
            <div class="sub-tajuk">
                 <h6> 5.2 Masa Makanan Perlu Disediakan:</h6>
            </div>
        </div>
        <div class="Makan-Minum3" id="MasaMakananPerluDisediakanSection">
            <div class="row">
                <div>
                    <label>i. Sebelum Mesyuarat</label>
                    <input type="checkbox" id="waktu" name="Sebelum_mesyuarat">
                </div>

                <div>
                    <label>ii. Semasa Mesyuarat</label>
                    <input type="checkbox" id="waktu" name="Semasa_mesyuarat">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>iii. Selepas Mesyuarat</label>
                    <input type="checkbox" id="waktu" name="Selepas_mesyuarat">
                </div>

                <div>
                    <label>iv.Lain-lain:</label>
                    <input type="text" id="waktu" name="Lain_Lain_Masa_Makanan_Perlu_Disediakan">
                </div>
            </div>
        </div>



        <div class="side-nav">
            <div class="sub-tajuk">
                 <h6> 5.3 Cara Hidangan:</h6>
            </div>
        </div>
        <div class="Makan-Minum5" id="carahidangan">
            <div class="row">
                <div>
                    <label>i. Di Dalam Bilik Mesyuarat</label>
                    <input type="checkbox" id="cara_hidangan" name="di_Dalam_bilik_mesyuarat"> 
                </div>

                <div>
                    <label>ii. Di Luar Bilik Mesyuarat</label>
                    <input type="checkbox" id="cara_hidangan" name="Di_Luar_mesyuarat">
                </div>
            </div>

            <div class="row">
                <div>
                    <label>iii. Buffet</label>
                    <input type="checkbox" id="cara_hidangan" name="Buffet">
                </div>

                <div>
                    <label>iv. Hidagan VIP:</label>
                    <input type="checkbox" id="cara_hidangan" name="Hidangan_VIP">
                </div>
            </div>

        </div>

        <div class="tajuk-Memo">
            <h4>Muat Naik Anda Punya Memo/File Disini👇</h4>
        </div>

        <div class="Upload-Memo">
           <label for="input-file" id="drop-area">
               <div id="img-view">
                   <div>
                      <i class="fas fa-cloud-upload-alt fa-4x"></i>
                      <p>Drag and drop or click here <br> to upload image or file</p>
                   </div>
                </div>
                <input type="file" name="file_memo" id="input-file" hidden>
                <div id="file-info"></div>
            </label>
        </div>



        <div class="submit-button">
            <button type="submit"  >Hantar Permohonan</button>
        </div>

    </form>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
<script src=js/upload-memo.js></script>
<script src="js/uncheck_mesyuarat.js"></script>
<script src="js/uncheck_pengerusi.js"></script>
<script src="js/uncheck_menu.js"></script>
<script src="js/uncheck_minuman.js"></script>
<script src="js/uncheck_makanan_perlu_disediakan.js"></script>
<script src="js/uncheck_jenis_hidangan.js"></script>
<script src="js/uncheck_cara_hidangan.js"></script>
<script src="js/validateform.js"></script>
</body>
</html>
<?php

}

?>
