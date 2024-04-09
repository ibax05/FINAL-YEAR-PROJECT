<?php 
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
include("connection.php");

if(isset($_SESSION['id_Admin']) || isset($_GET['id'])) {
  $id = $_SESSION['id_Admin'];
  
$result2 =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login_admin  WHERE id = $id"));

$result = mysqli_query($conn, "SELECT * FROM table_contact");





?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mesej</title>
  <link rel="stylesheet" href="css/sidebar.css">
  <style>
    body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;
}

.container {
  max-width: 1000px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
}

.table-container {
  overflow-x: auto;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  text-align: left;
}

thead {
  background-color: #007bff;
  color: #fff;
}

th {
  text-transform: uppercase;
}

tbody tr:nth-child(even) {
  background-color: #f2f2f2;
}

td:nth-child(4) {
  white-space: pre-wrap;
  word-wrap: break-word;
}

  </style>
</head>
    <body id="body-pd">
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
                        <a href="contact_from_user.php?id=<?= $result2["id"] ?>" class=" nav__link active" > 
                              <ion-icon name="mail-outline" class="nav__icon"></ion-icon>
                            <span class="nav__name">Mesej</span>
                        </a>
                        <a href="test.php?id=<?= $result2["id"] ?>" class=" nav__link collapse">
                           <ion-icon name="fast-food-outline" class="nav__icon"></ion-icon>
                             <span class="nav__name">Senarai Makanan</span>
                        </a>
                        
                        





                    </div>
                </div>

                <a href="log_out_admin.php" class="nav__link">
                    <ion-icon name="log-out-outline" class="nav__icon"></ion-icon>
                    <span class="nav__name">Keluar</span>
                </a>
            </nav>
        </div>
        <div class="container">
            <h2>Mesej</h2>
            <div class="table-container">
              <table>
                <thead>
                  <tr>
                    <th style="width: 20%;">Id Tempahan Makanan</th>
                    <th style="width: 20%;">Id Pemohon</th>
                    <th style="width: 20%;">Unit Bahagian</th>
                    <th style="width: 10%;">Nama</th>
                    <th style="width: 50%;">Pesan</th>
                    <th style="width: 50%;">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                    
                    // Check if the result set is not null
                    if ($result) {
                        // Check if there are any rows in the result set
                        if (mysqli_num_rows($result) > 0) {
                            // Loop through the result set
                            while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                  <tr>
                    <td><?php echo  $row['id_tempahan_makanan']; ?></td>
                    <td><?php echo $row['user_id']; ?></td>
                    <td><?php echo $row['Unit_Bahagian']; ?></td>
                    <td><?php echo $row['name_Pemohon']; ?></td>
                    <td><?php echo $row['Message']; ?></td>
                    <td>
                    <a href="delete_contact.php?id_tempahan_makanan=<?php echo $row['id_tempahan_makanan']; ?>&user_id=<?php echo $row['user_id']; ?>">
                    <i class="fa-solid fa-trash" style="color: red;"></i>
                    </a>
                    </td>
                  </tr>
                  <?php
                }
            } else {
                // No rows in the result set
                ?>
                <tr>
                <td colspan="6">No messages found.</td>
                </tr>
                <?php
            }
        } else {
            // Error in query execution
            ?>
            <tr>
            <td colspan="6">Error fetching messages.</td>
            </tr>
            <?php
        }
        ?>
                </tbody>
              </table>
            </div>
          </div>



        
        
        
                <!-- ===== IONICONS ===== -->
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
        
        <!-- ===== MAIN JS ===== -->
        <script src="js/main.js"></script>
        <script>
           setTimeout(function() {
              document.getElementById('success_message').style.display = 'none';
           }, 7000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
       </script>
       <script>
           setTimeout(function() {
            document.getElementById('error_message').style.display = 'none';
          }, 7000); // Menghilangkan notifikasi setelah 10 detik (10000 milidetik)
        </script>
    </body>
</html>
<?php } ?>


























