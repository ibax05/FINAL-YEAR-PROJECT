<?php
session_start(); // Memulakan sesi
// Sambung database
include("connection.php");

// Query
$sql = "SELECT * FROM table_makanan WHERE status_pemohonan='Dalam proses'";
$result = $conn->query($sql);

$sql2 = "SELECT * FROM table_makanan WHERE status_pemohonan='Dalam proses'";
$result2 = $conn->query($sql);

if ($result) {
    




?>

<!DOCTYPE html>
<html>
<head>
<title>Permohonan Diapprove</title>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<!-- Stylesheet -->
<style>

.approve {
            background-color: #28a745; /* Green */
            color: white;
        }

        .reject {
            background-color: #dc3545; /* Red */
            color: white;
        }
body {
  font-family: 'Poppins', sans-serif;
  background: #f8f9fa;  
}

.wrapper {
  padding: 30px;
  max-width: 100%;
  margin: 50px auto;
  background: #ffffff;
  border-radius: 15px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: transform 0.3s ease-in-out;
}

.wrapper:hover {
  transform: translateY(-5px);
}

.table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

.table thead {
  background: #007bff;
  color: #ffffff;
}

.table thead tr th {
  font-size: 16px;
  font-weight: 700;
  letter-spacing: 1px;
  padding: 15px;
  border-bottom: 2px solid #dee2e6;
}

.table tbody tr td {
  font-size: 14px;
  letter-spacing: 0.5px;
  font-weight: 500;
  padding: 10px;
  text-align: center;
  border-bottom: 1px solid #dee2e6;
}

.table tbody tr:hover {
  background-color: #f8f9fa;
}

@media (max-width: 768px) {
  .wrapper {
    margin: 20px;
    padding: 20px;
  }
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  
  padding: 12px 25px;
  border: none;
  border-radius: 3px;
  
  font-size: 16px;
  font-weight: 600;
  letter-spacing: 1px;
  
  transition: all 0.3s ease;  
}

.btn-primary:hover {
  background-color: #0062cc;
  transform: translateY(-2px);
  box-shadow: 0 2px 10px rgba(0,0,0,.2);
}

.btn-reject,
.btn-approve {
  padding: 12px 10px 12px 10px;
  font-size: 14px;
  width: 90px; /* Menentukan lebar tombol */
  cursor: pointer;
  transition: all 0.3s ease;
}
.btn-action {
  padding: 8px 12px;
  font-size: 14px;
  
  border: none;
  border-radius: 4px;
  
  color: white;
  cursor: pointer;
  
  transition: all 0.3s ease;
}

.btn-reject {
  background: #dc3545; 
  border: none;
  color: white;
  border-radius: 4px; 
}

.btn-approve {
   background: #28a745; ;  
   border: none;
   color: white;
   border-radius: 4px; 
}

.btn-action:hover {
  transform: translateY(-2px);
  box-shadow: 2px 2px 6px rgba(0,0,0,0.4);
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


</style>

</head>
<?php if (isset($_SESSION['error_email'])): ?>
    <div id="error_email" class="alert alert-danger alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?php echo ($_SESSION['error_email']); ?>
        <?php unset($_SESSION['error_email']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['approved'])): ?>
    <div id="approved" class="alert alert-success alert-dismissible fade show custom-alert" role="alert">
        <i class="fas fa-check-circle mr-2"></i>
        <?php echo ($_SESSION['approved']); ?>
        <?php unset($_SESSION['approved']); ?>
    </div>
<?php endif; ?>
<body>
<?php while($row2 = $result2->fetch_assoc()) { ?>

  <div id="rejectPopup<?php echo $row2['id_tempahan_makanan']; ?>" class="popup">
                      <div class="popup-content">
                          <span data-id="<?php echo $row2['id_tempahan_makanan']; ?>" class="close-btn">&times;</span>
                          <h3>Alasan Penolakan</h3>
                          <form id="rejectForm<?php echo $row2['id_tempahan_makanan']; ?>" action="reject_from_pending_dashboard.php" method="post">
                              <textarea id="message<?php echo $row2['id_tempahan_makanan']; ?>" name="message" rows="5" placeholder="Pesan" required></textarea>
                              <input type="hidden" name="id_tempahan_makanan" value="<?php echo $row2['id_tempahan_makanan']; ?>">
                              <div class="popup-buttons">
                                  <button type="button" class="btn reject" onclick="closePopup(<?php echo $row2['id_tempahan_makanan']; ?>)">Batal</button>
                                  <button type="submit" class="btn approve">Hantar</button>
                              </div>
                          </form>
                       </div>
                    </div>
<?php } ?>

<?php if (isset($_SESSION['rejected_from_dashboard'])): ?>
<div id="rejected_from_dashboard" class="custom-alert custom-alert-success" role="alert">
  <i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['rejected_from_dashboard']); ?>
  <?php unset($_SESSION['rejected_from_dashboard']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_email_from_dashboard'])): ?>
<div id="error_email_from_dashboard" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_email_from_dashboard']); ?>
  <?php unset($_SESSION['error_email_from_dashboard']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_user_from_dashboard'])): ?>
<div id="error_user_from_dashboard" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_user_from_dashboard']); ?>
  <?php unset($_SESSION['error_user_from_dashboard']); ?>
</div>
<?php endif; ?>



<?php if (isset($_SESSION['approved_from_dashboard'])): ?>
<div id="approved_from_dashboard" class="custom-alert custom-alert-success" role="alert">
<i class="fas fa-check-circle mr-2"></i>
  <?php echo ($_SESSION['approved_from_dashboard']); ?>
  <?php unset($_SESSION['approved_from_dashboard']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_email_from_dashboard_approved'])): ?>
<div id="error_email_from_dashboard_approved" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_email_from_dashboard_approved']); ?>
  <?php unset($_SESSION['error_email_from_dashboard_approved']); ?>
</div>
<?php endif; ?>

<?php if (isset($_SESSION['error_user_from_dashboard_approved'])): ?>
<div id="error_user_from_dashboard_approved" class="custom-alert custom-alert-danger" role="alert">
<i class="fas fa-exclamation-circle mr-2"></i>
  <?php echo ($_SESSION['error_user_from_dashboard_approved']); ?>
  <?php unset($_SESSION['error_user_from_dashboard_approved']); ?>
</div>
<?php endif; ?>


<div class="wrapper">

  <h1>Senarai Permohonan Tergantung</h1>
  
  <table class="table">
  
    <thead>
      <tr>
        <th>Id Tempahan Makanan</th>
        <th>Nama Pemohon</th>
        <th>Tarikh Permohonan</th>  
        <th>Status</th>
        <th>Aksi</th>
      </tr>
    </thead>
    
    <tbody>
    
    <?php while($row = $result->fetch_assoc()) { ?>
    
      <tr>
        <td><?php echo $row['id_tempahan_makanan']; ?></td>
        <td><?php echo $row['Nama_Pegawai']; ?></td>
        <td><?php echo $row['Tarikh_Memohon']; ?></td>
        <td>
          <span style="background-color:  #ffc107; color: white; padding: 5px 10px; border-radius: 5px;">Dalam proses</span>
        </td>
        <td>
        <button onclick="showPopup(<?php echo $row['id_tempahan_makanan']; ?>)" class="btn-reject">Tolak</button>
        <button onclick="window.location.href='approve_from_pending_dashboard.php?id=<?php echo $row['id_tempahan_makanan']; ?>'" class="btn-approve">Luluskan</button>
        </td>

      </tr>


      
    <?php } ?>
    
    </tbody>
    
  </table>
</div>

<div class="text-center mt-5">
      <button onclick="window.location.href='dashboard.php'" class="btn btn-primary btn-lg">Kembali</button>  
</div>

</body>
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
<script>
            setTimeout(function() {
                document.getElementById('rejected_from_dashboard').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_email_from_dashboard').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_user_from_dashboard').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)error_user
            
</script>


<script>
            setTimeout(function() {
                document.getElementById('approved_from_dashboard').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_email_from_dashboard_approved').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
            
</script>
<script>
            setTimeout(function() {
                document.getElementById('error_user_from_dashboard_approved').style.display = 'none';
            }, 4000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)error_user
            
</script>

</html>
<?php 
 
    } 
    else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }?>

