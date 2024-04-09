<?php

// Koneksi database
include("connection.php");

// Ambil user_id dari URL parameter 
if(isset($_GET['id_tempahan_makanan']) && isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
  $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

  // Query delete data
  $query = "DELETE FROM table_status WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id = $user_id";

  // Eksekusi query 
  if(mysqli_query($conn, $query)){

    // Redirect ke halaman data makanan
    header("Location: approve_from_dashboard.php");

  } else {

    echo "Gagal menghapus data: " . mysqli_error($conn);

  }

} else {
  
  echo "user_id tidak ditemukan! <br>";
  
}

mysqli_close($conn);

?>