<?php 
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
include("connection.php");

if(isset($_SESSION['id_Admin']) || isset($_GET['id'])) {
    $id = $_SESSION['id_Admin'];
    
$result2 =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login_admin  WHERE id = $id"));
$result = mysqli_query($conn, "SELECT * FROM table_makanan WHERE status_pemohonan='Dalam proses' ");




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pemohon</title>
    <link rel="stylesheet" href="css/sidebar.css">
    

    <style>
        
        /* CSS code here */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
            color: #333;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }


        table button {
            background-color: #007bff;
            cursor: pointer;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            color: white;
            transition: background-color 0.3s ease;
         }

         table button
         {

            cursor: pointer;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 8px; /* Adds space between buttons */
            transition: opacity 0.3s ease;
            width: 100px; /* Tetapkan saiz butang */
            height: 40px;
            border-radius: 4px;

         }

     
        

        .btn {
            cursor: pointer;
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            color: white;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            opacity: 0.8; /* Adjusted for consistency with .btn:hover */
        }

        .action-buttons {
            display: flex;
        }

        .btn {
            cursor: pointer;
            padding: 8px 12px;
            border: none;
            border-radius: 4px;
            font-weight: bold;
            margin-right: 8px; /* Adds space between buttons */
            transition: opacity 0.3s ease;
            width: 100px; /* Tetapkan saiz butang */
            height: 40px;
            border-radius: 4px;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .approve {
            background-color: #28a745; /* Green */
            color: white;
        }

        .reject {
            background-color: #dc3545; /* Red */
            color: white;
        }


        /* Responsiveness */
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
                display: block;
                overflow-x: auto;
            }

            th, td {
                padding: 8px;
            }
        }

        /* Set lebar maksimum untuk column "Aksi" */
        td:last-child {
            width: 50px;
        }
                /* Menerapkan sedikit padding di sekitar tombol untuk memberikan ruang yang lebih nyaman */
                .action-buttons {
            display: flex;
            gap: 8px; /* Memberikan jarak antar tombol */
        }

        /* Menyesuaikan gaya untuk tombol vendor */
        .vendor-select {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .vendor-select:hover {
            background-color: #0056b3;
        }

                /* CSS untuk pop-up */
                .popup {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .popup-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 30%;
            position: relative;
        }

        .close-btn {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close-btn:hover,
        .close-btn:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        .popup-buttons {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .popup-buttons button {
            margin-left: 10px;
        }
        .popup-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 400px; /* Lebar maksimum untuk konten popup */
        position: relative;
        border-radius: 8px; /* Sudut bulat */
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2); /* Bayang-bayang */
       }

     .popup-content h3 {
      margin-top: 0; /* Hapus margin atas */
      }

   .popup-content textarea {
    width: 100%;
    margin-bottom: 10px; /* Ruang kosong antara textarea dan butang */
    resize: vertical; /* Membolehkan textarea untuk diubah saiz secara vertikal */
}

   .popup-buttons {
    display: flex;
    justify-content: flex-end; /* Menyusun butang ke bahagian kanan */
}

   .popup-buttons button {
    padding: 10px 20px; /* Saiz padding butang */
    margin-left: 10px; /* Ruang kosong antara butang */
    border-radius: 4px; /* Sudut bulat */
    border: none; /* Hapus border */
    cursor: pointer; /* Tukar kursor ke pointer */
    transition: background-color 0.3s ease; /* Transisi apabila hover */
}

    .popup-buttons button:hover {
    opacity: 0.8; /* Sedikit transparan ketika hover */
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

.custom-alert .close {
  position: relative;
  top: -2px;
  right: -21px;
  color: inherit;
}

        


    </style>
</head>
    <body id="body-pd" >
        <div class="l-navbar" id="navbar">
            <nav class="nav">
                <div>
                    <div class="nav__brand">
                        <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                        <a href="dashboard.php" class="nav__logo">Admin</a>
                    </div>
                    <div class="nav__list">
                        <a href="dashboard.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
                            <ion-icon name="home-outline" class="nav__icon"></ion-icon>
                            <span class="nav__name">Rumah</span>
                        </a>
                        <a href="#" class=" nav__link active">
                            <ion-icon name="document-outline" class="nav__icon"></ion-icon> 
                            <span class="nav__name">Senarai Pemohon</span>
                        </a>
                        <a href="contact_from_user.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
                              <ion-icon name="mail-outline" class="nav__icon"></ion-icon>
                            <span class="nav__name">Message</span>
                        </a>
                        <a href="test.php?id=<?= $result2["id"] ?>" class=" nav__link collapse">
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
<?php if (isset($_SESSION['rejected'])): ?>
<div id="rejected" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['rejected']); ?>
  <?php unset($_SESSION['rejected']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_email'])): ?>
<div id="error_email" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_email']); ?>
  <?php unset($_SESSION['error_email']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_user'])): ?>
<div id="error_user" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_user']); ?>
  <?php unset($_SESSION['error_user']); ?>
</div>
<?php endif; ?>




<?php if (isset($_SESSION['approved'])): ?>
<div id="approved" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['approved']); ?>
  <?php unset($_SESSION['approved']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_email_approved'])): ?>
<div id="error_email_approved" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_email_approved']); ?>
  <?php unset($_SESSION['error_email_approved']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_user_email'])): ?>
<div id="error_user_email" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_user_email']); ?>
  <?php unset($_SESSION['error_user_email']); ?>
</div>
<?php endif; ?>



        

          <h1>Senarai Pemohon</h1>
          <br>
          <table id="statusTable">
              <thead>
                  <tr>
                    <th>Id Tempahan Makanan</th>
                    <th>Nama Pegawai</th>
                    <th>Unit/Bahagian</th>
                    <th>Status</th>
                    <th>Borang</th>
                    <th>Aksi</th>
                  </tr>
              </thead>
              <tbody>
              <?php while($row = mysqli_fetch_assoc($result)) { ?>
                  <!-- Contoh Data -->
                  <tr>
                    <td><?php echo $row['id_tempahan_makanan']; ?></td>
                    <td><?php echo $row['Nama_Pegawai']; ?></td>
                    <td><?php echo $row['Unit_Bahagian']; ?></td>
                    <td> <span style="background-color:  #ffc107; color: white; padding: 3px 10px; border-radius: 5px;"><?php echo $row['status_pemohonan'] ?></span></td>
                    <td><button onclick="window.location.href='list_permohonan_for_admin.php?id_tempahan_makanan=<?php echo $row['id_tempahan_makanan']; ?>&user_id=<?php echo $row['user_id']; ?>';">Borang</button></td>
                    <td>
                        <div class="action-buttons">
                        <button onclick="showPopup(<?php echo $row['id_tempahan_makanan']; ?>)" class="btn reject">Tolak</button>
                        <button onclick="window.location.href='approve.php?id=<?php echo $row['id_tempahan_makanan']; ?>'" class="btn approve">Luluskan</button>
                        </div>
                    </td>
                  </tr>
                  <div id="rejectPopup<?php echo $row['id_tempahan_makanan']; ?>" class="popup">
                      <div class="popup-content">
                          <span data-id="<?php echo $row['id_tempahan_makanan']; ?>" class="close-btn">&times;</span>
                          <h3>Alasan Penolakan</h3>
                          <form id="rejectForm<?php echo $row['id_tempahan_makanan']; ?>" action="reject.php" method="post">
                              <textarea id="message<?php echo $row['id_tempahan_makanan']; ?>" name="message" rows="5" placeholder="Pesan" required></textarea>
                              <input type="hidden" name="id_tempahan_makanan" value="<?php echo $row['id_tempahan_makanan']; ?>">
                              <div class="popup-buttons">
                                  <button type="button" class="btn reject" onclick="closePopup(<?php echo $row['id_tempahan_makanan']; ?>)">Batal</button>
                                  <button type="submit" class="btn approve">Hantar</button>
                              </div>
                          </form>
                       </div>
                    </div>
                <?php } ?>
              </tbody>
          </table>
          <script>
        // Dapatkan elemen span untuk menutup pop-up
        var closeBtn = document.getElementsByClassName('close-btn')[0];


        // Fungsi untuk menunjukkan pop-up
        function showPopup(idTempahan) {
            var popup = document.getElementById('rejectPopup' + idTempahan);
            popup.style.display = 'block';
        }

        // Fungsi untuk menutup pop-up
        function closePopup(idTempahan) {
            var popup = document.getElementById('rejectPopup' + idTempahan);
            popup.style.display = 'none';
        }

        // Apabila span "x" diklik, tutup pop-up
       closeBtn.onclick = function() {
        closePopup(idTempahan);
       }

        // Tambahkan event listener untuk setiap butang "Reject"
        var rejectButtons = document.querySelectorAll('.reject');
        rejectButtons.forEach(function(btn) {
            btn.addEventListener('click', function(event) {
                event.preventDefault(); // Menghalang laman web daripada menavigasi ke URL lain
                var idTempahan = this.getAttribute('data-id');
                showPopup(idTempahan);
            });
        });


        // Dapatkan semua butang tutup
        var closeButtons = document.querySelectorAll('.close-btn');

       // Loop melalui setiap butang tutup dan tambahkan event listener
        closeButtons.forEach(function(closeBtn) {
        closeBtn.addEventListener('click', function() {
        var idTempahan = this.getAttribute('data-id');
        closePopup(idTempahan);
    });
});
      </script>
        
        
        
                <!-- ===== IONICONS ===== -->
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <!-- ===== MAIN JS ===== -->
        <script src="js/main.js"></script>
<script>
            setTimeout(function() {
                document.getElementById('rejected').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_email').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_user').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)error_user
            
</script>

<script>
            setTimeout(function() {
                document.getElementById('approved').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_email_approved').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_user_approved').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)error_user
            
</script>
    </body>
</html>
<?php } ?>

























