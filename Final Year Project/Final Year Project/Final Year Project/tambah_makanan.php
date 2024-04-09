<?php
include("connection.php");
session_start(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $jenisSet = $_POST["jenisSet"];
  $menu = $_POST["menu"];
  $table = $_POST["table"];

  // Lakukan sesuatu dengan data yang diterima berdasarkan tabel
  if ($table === 'sarapan') {
    

    // Buat query untuk menyisipkan data
    $sql = "INSERT INTO sarapan_pagi (Set_makanan, Menu) VALUES ('$jenisSet', '$menu')";

    if ($conn->query($sql) === TRUE) {
              $_SESSION['tambah_makanan'] = "Informasi makanan berjaya di tambah";
      header("Location:test.php");
    } else {
      $_SESSION['error_tambah_makanan'] = "Informasi makanan tidak berjaya di tambah";
      header("Location:status_permohon.php");
    }

 
  } else if ($table === 'tengahari') {

    // Buat query untuk menyisipkan data
    $sql = "INSERT INTO makanan_tengahari (Set_makanan, Menu) VALUES ('$jenisSet', '$menu')";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['tambah_makanan'] = "Informasi makanan berjaya di tambah";
      header("Location:test.php");
    } else {
      $_SESSION['error_tambah_makanan'] = "Informasi makanan tidak berjaya di tambah";
      header("Location:status_permohon.php");
    }
  } else if ($table === 'petang') {
    // Buat query untuk menyisipkan data
    $sql = "INSERT INTO minum_petang (Set_makanan, Menu) VALUES ('$jenisSet', '$menu')";

    if ($conn->query($sql) === TRUE) {
      $_SESSION['tambah_makanan'] = "Informasi makanan berjaya di tambah";
      header("Location:test.php");
    } else {
      $_SESSION['error_tambah_makanan'] = "Informasi makanan tidak berjaya di tambah";
      header("Location:status_permohon.php");


    }
  }
}
else{
  $_SESSION['error_makanan_tak_sampai'] = "Anda tidak menghantar apa-apa informasi";
  header("Location:status_permohon.php");
}
?>