<?php 
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)
session_start(); // Memulakan sesi
// Koneksi database dan ambil data
include("connection.php");
// Query untuk ambil data


if(isset($_SESSION['id_Admin']) || isset($_GET['id'])) {
$id = $_SESSION['id_Admin'];

$result2 =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM login_admin  WHERE id = $id"));

$sql = "SELECT COUNT(*) AS total FROM table_makanan WHERE status_pemohonan='Dalam proses'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$pendingCount = $row['total'];

$sql = "SELECT COUNT(*) AS total FROM table_status WHERE status_pemohonan='Diluluskan'";
$result3 = $conn->query($sql);
$row3 = $result3->fetch_assoc();
$ApprovedCount = $row3['total'];

$sql = "SELECT COUNT(*) AS total FROM table_status WHERE status_pemohonan='Ditolak'";
$result4 = $conn->query($sql);
$row4 = $result4->fetch_assoc();
$RejectedCount = $row4['total'];








?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- ===== CSS ===== -->
        <link rel="stylesheet" href="css/sidebar.css">
        
        <title>Dashboard | Admin</title>
    </head>
    <body id="body-pd">
        <div class="l-navbar" id="navbar">
            <nav class="nav">
                <div>
                    <div class="nav__brand">
                        <ion-icon name="menu-outline" class="nav__toggle" id="nav-toggle"></ion-icon>
                        <a href="dashboard.php" class="nav__logo">Admin</a>
                    </div>
                    <div class="nav__list">
                        <a href="dashboard.php?id=<?= $result2["id"] ?>" class=" nav__link active" >
                            <ion-icon name="home-outline" class="nav__icon"></ion-icon>
                            <span class="nav__name">Rumah</span>
                        </a>
                        <a href="status_permohon.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
                            <ion-icon name="document-outline" class="nav__icon"></ion-icon> 
                            <span class="nav__name">Senarai Pemohon</span>
                        </a>
                        <a href="contact_from_user.php?id=<?= $result2["id"] ?>" class="nav__link collapse">
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





        <div class="dashboard">

            <div data-href="approve_from_dashboard.php" class="dashboard-item">
              <div class="icon">
                <ion-icon name="checkmark-circle"></ion-icon>  
              </div>
              
              <div class="content">
                <h3>Permohonan Diluluskan</h3>  
                <h2><?php echo $ApprovedCount; ?></h2>
              </div>
            </div>
          
            <div data-href="pending_from_dashboard.php" class="dashboard-item">
              <div class="icon">
                <ion-icon name="hourglass"></ion-icon>
              </div>
              
              <div class="content">
                <h3>Permohonan Tergantung</h3>   
                <h2><?php echo $pendingCount; ?></h2>
              </div>
            </div>
            
            <div data-href="reject_from_dashboard.php" class="dashboard-item">
             <!-- content --> 
              <div class="icon">
                <ion-icon name="close-circle"></ion-icon>
              </div>

              <div class="content">
                <h3>Permohonan Ditolak</h3>   
                <h2><?php echo $RejectedCount; ?></h2>
              </div>
            </div>
            </div>
          </div>
        
        
        
                <!-- ===== IONICONS ===== -->
        <script src="https://unpkg.com/ionicons@5.1.2/dist/ionicons.js"></script>
        <script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>
        
        <!-- ===== MAIN JS ===== -->
        <script src="js/main.js"></script>
    </body>
</html>
<?php 

}
?>