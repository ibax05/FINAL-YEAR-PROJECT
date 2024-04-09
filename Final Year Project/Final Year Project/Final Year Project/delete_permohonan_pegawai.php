<?php

// Koneksi database
include("connection.php");

// Ambil user_id dari URL parameter 
if(isset($_GET['user_id']) && isset($_GET['id_tempahan_makanan']) ) {
  $user_id = $_GET['user_id'];
  $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

  // Query delete data
  $query = "DELETE FROM table_makanan WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id = $user_id";

  // Eksekusi query 
  if(mysqli_query($conn, $query)){

    // Redirect ke halaman data makanan
    header("Location: progress-permohonan.php?id=$user_id");

  } else {

    echo "Gagal menghapus data: " . mysqli_error($conn);

  }

} else {
  
  echo "user_id tidak ditemukan! <br>";
  
}

mysqli_close($conn);

?>