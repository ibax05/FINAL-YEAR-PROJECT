<?php
session_start(); // Memulakan sesi
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $updateId = $_POST["updateId"];
    $updateJenisSet = $_POST["updateJenisSet"];
    $updateMenu = $_POST["updateMenu"];
    $updateTable = $_POST["updateTable"];

    // Lakukan sanitasi dan validasi data jika diperlukan

    // Lakukan update data berdasarkan tabel
    if ($updateTable === 'sarapan') {
        // Buat query untuk mengupdate data dalam tabel sarapan_pagi
        $sql = "UPDATE sarapan_pagi SET Set_makanan = '$updateJenisSet', Menu = '$updateMenu' WHERE ID_jenis_makanan = $updateId";
    } elseif ($updateTable === 'tengahari') {
        // Buat query untuk mengupdate data dalam tabel makanan_tengahari
        $sql = "UPDATE  makanan_tengahari SET Set_Makanan = '$updateJenisSet', Menu = '$updateMenu' WHERE ID_jenis_makanan = $updateId";
    } elseif ($updateTable === 'petang') {
        // Buat query untuk mengupdate data dalam tabel minum_petang
        $sql = "UPDATE minum_petang SET Set_Makanan = '$updateJenisSet', Menu = '$updateMenu' WHERE ID_jenis_makanan = $updateId";
    }

    if (mysqli_query($conn, $sql)) {
        // Update berhasil

        $_SESSION['update_makanan'] = "Informasi makanan berjaya di kemaskini";
        header("Location:test.php");
    } else {


        $_SESSION['error_makanan'] = "Informasi makanan tidak berjaya di kemaskini";
        header("Location:status_permohon.php");

    }

    mysqli_close($conn);
}
?>