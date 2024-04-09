<?php

ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
include("connection.php");

if(isset($_SESSION['id_Admin']) || isset($_GET['id'])) {
  $id = $_SESSION['id_Admin'];
  
$result2 =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login_admin  WHERE id = $id"));
$result_sarapan = mysqli_query($conn, "SELECT * FROM sarapan_pagi");
$result_tengahari = mysqli_query($conn, "SELECT * FROM makanan_tengahari");
$result_petang = mysqli_query($conn, "SELECT * FROM minum_petang");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- ===== CSS ===== -->
  <link rel="stylesheet" href="css/sidebar.css">
  <style>
    /* Table styles */
    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: fixed; /* Tambahkan baris ini */
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }
    th {
        background-color: #007BFF;
        color: white;
    }
    .table-container {
        margin-left: 200px;
        padding: 20px;
    }
    .table-title {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .table-title h2 {
        margin-right: 10px;
    }
    .add-icon {
        cursor: pointer;
        color: #007BFF;
    }

    ul {
        list-style-type: disc;
        padding-left: 20px;
    }
    th:nth-child(1), /* Kolom pertama */
td:nth-child(1) {
  width: 20%; /* Sesuaikan lebar sesuai kebutuhan */
}

th:nth-child(2), /* Kolom kedua */
td:nth-child(2) {
  width: 100%; /* Sesuaikan lebar sesuai kebutuhan */
}

th:nth-child(3), /* Kolom ketiga */
td:nth-child(3) {
  width: 20%; /* Sesuaikan lebar sesuai kebutuhan */
}

    .popup {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.6);
    }

    .popup-content {
        background-color: #fff;
        margin: 15% auto;
        padding: 30px;
        border-radius: 5px;
        width: 400px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .popup-content h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 24px;
        color: #333;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #555;
    }

    .form-group input,
    .form-group textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .form-actions {
        text-align: right;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #f0f0f0;
        color: #333;
        margin-left: 10px;
    }

    .btn-secondary:hover {
        background-color: #ddd;
    }

    .custom-alert {
  padding: 15px;
  margin-bottom: 20px;
  border: 1px solid transparent;
  border-radius: 4px;
  max-width: 400px;
  margin: 0 auto;
  text-align: center;
}

.custom-alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.custom-alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

.trash-icon {
    color: red;
  }

  .edit-icon {
    color: blue;
  }
  </style>
</head>
<?php if (isset($_SESSION['update_makanan'])): ?>
<div id="update_makanan" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['update_makanan']); ?>
  <?php unset($_SESSION['update_makanan']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan'])): ?>
<div id="error_makanan" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan']); ?>
  <?php unset($_SESSION['error_makanan']); ?>
</div>
<?php endif; ?>


<?php if (isset($_SESSION['tambah_makanan'])): ?>
<div id="tambah_makanan" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['tambah_makanan']); ?>
  <?php unset($_SESSION['tambah_makanan']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_tambah_makanan'])): ?>
<div id="error_tambah_makanan" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_tambah_makanan']); ?>
  <?php unset($_SESSION['error_tambah_makanan']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan_tak_sampai'])): ?>
<div id="error_makanan_tak_sampai" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan_tak_sampai']); ?>
  <?php unset($_SESSION['error_makanan_tak_sampai']); ?>
</div>
<?php endif; ?>



<?php if (isset($_SESSION['delete_makanan_pagi'])): ?>
<div id="delete_makanan_pagi" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['delete_makanan_pagi']); ?>
  <?php unset($_SESSION['delete_makanan_pagi']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan_pagi'])): ?>
<div id="error_makanan_pagi" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan_pagi']); ?>
  <?php unset($_SESSION['error_makanan_pagi']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_id_makanan_pagi'])): ?>
<div id="error_id_makanan_pagi" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_id_makanan_pagi']); ?>
  <?php unset($_SESSION['error_id_makanan_pagi']); ?>
</div>
<?php endif; ?>



<?php if (isset($_SESSION['delete_makanan_pagi'])): ?>
<div id="delete_makanan_pagi" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['delete_makanan_pagi']); ?>
  <?php unset($_SESSION['delete_makanan_pagi']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan_pagi'])): ?>
<div id="error_makanan_pagi" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan_pagi']); ?>
  <?php unset($_SESSION['error_makanan_pagi']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_id_makanan_pagi'])): ?>
<div id="error_id_makanan_pagi" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_id_makanan_pagi']); ?>
  <?php unset($_SESSION['error_id_makanan_pagi']); ?>
</div>
<?php endif; ?>



<?php if (isset($_SESSION['delete_makanan_tengahari'])): ?>
<div id="delete_makanan_tengahari" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['delete_makanan_tengahari']); ?>
  <?php unset($_SESSION['delete_makanan_tengahari']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan_tengahari'])): ?>
<div id="error_makanan_tengahari" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan_tengahari']); ?>
  <?php unset($_SESSION['error_makanan_tengahari']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_id_makanan_tengahari'])): ?>
<div id="error_id_makanan_tengahari" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_id_makanan_tengahari']); ?>
  <?php unset($_SESSION['error_id_makanan_tengahari']); ?>
</div>
<?php endif; ?>


<?php if (isset($_SESSION['delete_makanan_petang'])): ?>
<div id="delete_makanan_petang" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['delete_makanan_petang']); ?>
  <?php unset($_SESSION['delete_makanan_petang']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_makanan_petang'])): ?>
<div id="error_makanan_petang" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_makanan_petang']); ?>
  <?php unset($_SESSION['error_makanan_petang']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_id_makanan_petang'])): ?>
<div id="error_id_makanan_petang" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_id_makanan_petang']); ?>
  <?php unset($_SESSION['error_id_makanan_petang']); ?>
</div>
<?php endif; ?>



<body id="body-pd">
  <div id="popup" class="popup">
    <div class="popup-content">
      <h3>Tambah Set Makanan</h3>
      <form action="tambah_makanan.php" method="POST">
        <div class="form-group">
          <label for="jenisSet">Jenis Set:</label>
          <input type="text" id="jenisSet" name="jenisSet" required>
        </div>
        <div class="form-group">
          <label for="menu">Menu:</label>
          <textarea id="menu" name="menu" placeholder="Nasi ayam kampung,[ENTER]" rows="4" required></textarea>
        </div>
        <input type="hidden" id="table" name="table" value="">
        <div class="form-actions">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary close-btn">Batal</button>
        </div>
      </form>
    </div>
  </div>

<!-- Tambahkan elemen pop-up untuk ikon "Update" -->
<div id="updatePopup" class="popup">
  <div class="popup-content">
    <h3>Kemaskini Set Makanan</h3>
    <form action="update_makanan.php" method="POST">
      <div class="form-group">
        <label for="updateJenisSet">Jenis Set:</label>
        <input type="text" id="updateJenisSet" name="updateJenisSet" required>
      </div>
      <div class="form-group">
        <label for="updateMenu">Menu:</label>
        <textarea id="updateMenu" name="updateMenu" placeholder="Nasi ayam kampung,[ENTER]" rows="4" required></textarea>
      </div>
      <input type="hidden" id="updateId" name="updateId">
      <input type="hidden" id="updateTable" name="updateTable">
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-secondary close-btn">Batal</button>
      </div>
    </form>
  </div>
</div>

  <div class="l-navbar" id="navbar">
    <nav class="nav">
      <div>
        <div class="nav__brand">
          <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
          <a href="dashboard.php?id=<?= $result2["id"] ?>" class="nav__logo">Admin</a>
        </div>
        <div class="nav__list">
          <a href="dashboard.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
            <ion-icon name="home-outline" class="nav__icon"></ion-icon>
            <span class="nav__name">Rumah</span>
          </a>
          <a href="status_permohon.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
            <ion-icon name="document-outline" class="nav__icon"></ion-icon>
            <span class="nav__name">Senarai Pemohon</span>
          </a>
          <a href="contact_from_user.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
            <ion-icon name="mail-outline" class="nav__icon"></ion-icon>
            <span class="nav__name">Message</span>
          </a>
          <a href="#" class="nav__link active">
            <ion-icon name="fast-food-outline" class="nav__icon"></ion-icon>
            <span class="nav__name">List Makanan</span>
          </a>
        </div>
      </div>

      <a href="log_out_admin.php" class="nav__link">
        <ion-icon name="log-out-outline" class="nav__icon"></ion-icon>
        <span class="nav__name">Keluar</span>
      </a>
    </nav>
  </div>

  <div class="table-container">
    <div class="table-title">
      <h2>A. SARAPAN/MINUM PAGI</h2>
      <ion-icon name="add-circle-outline" class="add-icon" data-table="sarapan"></ion-icon>
    </div>
    <table>
      <tr>
        <th>JENIS SET</th>
        <th>MENU</th>
        <th style="width: 60px; " >AKSI</th>
      </tr>
      <?php
      if ($result_sarapan->num_rows > 0) {
        while ($row = $result_sarapan->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["Set_makanan"] . "</td>";
          echo "<td>";
          echo "<ul>";
          $menu_items = explode(",", $row["Menu"]); // Menggunakan koma sebagai pemisah
          foreach ($menu_items as $item) {
            echo "<li>" . trim($item) . "</li>";
          }
          echo "</ul>";
          echo "</td>";
          echo '<td style="width: 60px; text-align:center; " >';
          echo '<a href="delete_makanan_pagi.php?ID_jenis_makanan=' . $row['ID_jenis_makanan'] . '" style="margin-right: 10px;">';
          echo '<i class="fa-solid fa-trash trash-icon"></i>';
          echo '</a>';
          echo '<a href="#" class="update-icon" data-id="' . $row['ID_jenis_makanan'] . '" data-jenis-set="' . $row['Set_makanan'] . '" data-menu="' . $row['Menu'] . '" data-table="sarapan">';
          echo '<i class="fa-solid fa-pen-to-square edit-icon"></i>';
          echo '</a>';
          echo '</td>';
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='2'>Tiada data ditemui.</td></tr>";
      }
      ?>
    </table>

    <div class="table-title">
      <h2>B. MAKAN TENGAHARI</h2>
      <ion-icon name="add-circle-outline" class="add-icon" data-table="tengahari"></ion-icon>
    </div>
    <table>
      <tr>
        <th>JENIS SET</th>
        <th>MENU</th>
        <th style="width: 60px; " >AKSI</th>
      </tr>
      <?php
      if ($result_tengahari->num_rows > 0) {
        while ($row = $result_tengahari->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["Set_Makanan"] . "</td>";
          echo "<td>";
          echo "<ul>";
          $menu_items = explode(",", $row["Menu"]);
          foreach ($menu_items as $item) {
            echo "<li>" . trim($item) . "</li>";
          }
          echo "</ul>";
          echo "</td>";
          echo '<td style=" text-align:center; " >';
          echo '<a href="delete_makanan_tengahari.php?ID_jenis_makanan=' . $row['ID_jenis_makanan'] . '" style="margin-right: 10px;">';
          echo '<i class="fa-solid fa-trash trash-icon"></i>';
          echo '</a>';
          echo '<a href="#" class="update-icon" data-id="' . $row['ID_jenis_makanan'] . '" data-jenis-set="' . $row['Set_Makanan'] . '" data-menu="' . $row['Menu'] . '" data-table="tengahari">';
          echo '<i  class="fa-solid fa-pen-to-square edit-icon"></i>';
          echo '</a>';
          echo '</td>';
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='2'>Tiada data ditemui.</td></tr>";
      }
      ?>
    </table>

    <div class="table-title">
      <h2>C. MINUM PETANG</h2>
      <ion-icon name="add-circle-outline" class="add-icon" data-table="petang"></ion-icon>
    </div>
    <table>
      <tr>
        <th>JENIS SET</th>
        <th>MENU</th>
        <th style="width: 60px; " >AKSI</th>
      </tr>
      <?php
      if ($result_petang->num_rows > 0) {
        while ($row = $result_petang->fetch_assoc()) {
          echo "<tr>";
          echo "<td>" . $row["Set_Makanan"] . "</td>";
          echo "<td>";
          echo "<ul>";
          $menu_items = explode(",", $row["Menu"]);
          foreach ($menu_items as $item) {
            echo "<li>" . trim($item) . "</li>";
          }
          echo "</ul>";
          echo "</td>";
          echo '<td style="width: 60px; text-align:center; " >';
          echo '<a href="delete_makanan_petang.php?ID_jenis_makanan=' . $row['ID_jenis_makanan'] . '" style="margin-right: 10px;">';
          echo '<i class="fa-solid fa-trash trash-icon"></i>';
          echo '</a>';
          echo '<a href="#" class="update-icon" data-id="' . $row['ID_jenis_makanan'] . '" data-jenis-set="' . $row['Set_Makanan'] . '" data-menu="' . $row['Menu'] . '" data-table="petang">';
          echo '<i class="fa-solid fa-pen-to-square edit-icon"></i>';
          echo '</a>';
          echo '</td>';
          echo "</tr>";
        }
      } else {
        echo "<tr><td colspan='2'>Tiada data ditemui.</td></tr>";
      }
      ?>
    </table>
  </div>

  <!-- ===== IONICONS ===== -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>

  <!-- ===== MAIN JS ===== -->
  <script src="js/main.js"></script>
  <script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
  <script>
    // Mendapatkan elemen-elemen yang diperlukan
    const addIcons = document.querySelectorAll('.add-icon');
    const popup = document.getElementById('popup');
    const closeBtn = document.querySelector('.close-btn');
    const jenisSetInput = document.getElementById('jenisSet');
    const menuTextarea = document.getElementById('menu');

    // Variabel untuk menyimpan tabel saat ini
    let currentTable = '';

    // Menampilkan pop-up saat ikon "add" diklik
    addIcons.forEach(icon => {
      icon.addEventListener('click', () => {
        currentTable = icon.getAttribute('data-table');
        jenisSetInput.value = '';
        menuTextarea.value = '';
        document.getElementById('table').value = currentTable;
        popup.style.display = 'block';
      });
    });

    // Menyembunyikan pop-up saat tombol "Batal" diklik
    closeBtn.addEventListener('click', () => {
      popup.style.display = 'none';
    });

    // Menyembunyikan pop-up saat pengguna mengklik di luar pop-up
    window.addEventListener('click', (event) => {
      if (event.target == popup) {
        popup.style.display = 'none';
      }
    });

    // Mendapatkan elemen formulir pada pop-up "Kemaskini Set Makanan"
const Form = document.getElementById('popup').querySelector('form');

// Menutup pop-up setelah formulir "Kemaskini Set Makanan" dikirimkan
Form.addEventListener('submit', function(event) {
  const popup = document.getElementById('popup');
  popup.style.display = 'none';
});


    




  //untuk update
  // Mendapatkan elemen-elemen yang diperlukan
  const updateIcons = document.querySelectorAll('.update-icon');
  const updatePopup = document.getElementById('updatePopup');
  const updateCloseBtn = updatePopup.querySelector('.close-btn');
  const updateJenisSetInput = document.getElementById('updateJenisSet');
  const updateMenuTextarea = document.getElementById('updateMenu');
  const updateIdInput = document.getElementById('updateId');
  const updateTableInput = document.getElementById('updateTable');

  // Menampilkan pop-up dengan informasi "Jenis Set" dan "Menu" saat ikon "Update" diklik
  updateIcons.forEach(icon => {
    icon.addEventListener('click', (event) => {
      event.preventDefault();
      const id = icon.getAttribute('data-id');
      const jenisSet = icon.getAttribute('data-jenis-set');
      const menu = icon.getAttribute('data-menu');
      const table = icon.getAttribute('data-table');
      updateIdInput.value = id;
      updateJenisSetInput.value = jenisSet;
      updateMenuTextarea.value = menu;
      updateTableInput.value = table;
      updatePopup.style.display = 'block';
    });
  });

  // Menyembunyikan pop-up saat tombol "Batal" diklik
  updateCloseBtn.addEventListener('click', () => {
    updatePopup.style.display = 'none';
  });

  // Menyembunyikan pop-up saat pengguna mengklik di luar pop-up
  window.addEventListener('click', (event) => {
    if (event.target == updatePopup) {
      updatePopup.style.display = 'none';
    }
  });


  // Mendapatkan elemen formulir pada pop-up "Kemaskini Set Makanan"
const updateForm = document.getElementById('updatePopup').querySelector('form');

// Menutup pop-up setelah formulir "Kemaskini Set Makanan" dikirimkan
updateForm.addEventListener('submit', function(event) {
  const updatePopup = document.getElementById('updatePopup');
  updatePopup.style.display = 'none';
});
  </script>
  <script>
            setTimeout(function() {
                document.getElementById('update_makanan').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_makanan').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>


<script>
            setTimeout(function() {
                document.getElementById('tambah_makanan').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_tambah_makanan').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_makanan_tak_sampai').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>




<script>
            setTimeout(function() {
                document.getElementById('delete_makanan_pagi').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_makanan_pagi').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_id_makanan_pagi').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>



<script>
            setTimeout(function() {
                document.getElementById('delete_makanan_tengahari').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_makanan_tengahari').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_id_makanan_tengahari').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>


<script>
            setTimeout(function() {
                document.getElementById('delete_makanan_petang').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_makanan_petang').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_id_makanan_petang').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
</body>
</html>
<?php } ?>