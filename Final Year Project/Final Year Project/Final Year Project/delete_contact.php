<?php
session_start(); // Memulai sesi

include("connection.php");

if(isset($_GET['id_tempahan_makanan']) && isset($_GET['user_id'])) {
  $user_id = $_GET['user_id'];
  $id_tempahan_makanan = $_GET['id_tempahan_makanan'];

  $query = "DELETE FROM table_contact WHERE id_tempahan_makanan = $id_tempahan_makanan AND user_id = $user_id";

  if(mysqli_query($conn, $query)){
    
    // Redirect ke halaman data makanan
    header("Location: contact_from_user.php");
    exit(); // Penting untuk menghentikan eksekusi skrip setelah melakukan redirect
  } else {
    $_SESSION['error_message'] = "Gagal Menghapus.";
    echo "Gagal menghapus data: " . mysqli_error($conn);
  }
} else {
  echo "user_id tidak ditemukan! <br>";
}

mysqli_close($conn);
?>
