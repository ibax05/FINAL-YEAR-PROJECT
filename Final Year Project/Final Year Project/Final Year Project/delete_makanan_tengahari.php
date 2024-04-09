<?php
session_start(); 
// Koneksi database
include("connection.php");

// Ambil user_id dari URL parameter 
if(isset($_GET['ID_jenis_makanan']) ) {
 
  $id_tempahan_makanan = $_GET['ID_jenis_makanan'];

  // Query delete data
  $query = "DELETE FROM makanan_tengahari WHERE ID_jenis_makanan  = $id_tempahan_makanan";

  // Eksekusi query 
  if(mysqli_query($conn, $query)){

    // Redirect ke halaman data makanan
    $_SESSION['delete_makanan_tengahari'] = "Informasi makanan tengahari berjaya di hapus";
    header("Location:test.php");

  } else {

    $_SESSION['error_makanan_tengahari'] = "Informasi makanan tengahari tidak berjaya di hapus";
    header("Location:status_permohon.php");

  }

} else {
  
  $_SESSION['error_id_makanan_tengahari'] = "Terdapat masalah di ID";
  header("Location:status_permohon.php");
  
}

mysqli_close($conn);

?>