<?php
include("connection.php"); // Assuming you have a separate file for the database connection

//$result =  mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM register "));
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {



    // Check if a file was uploaded without errors
    if (isset($_FILES["file_memo"]) && $_FILES["file_memo"]["error"] == 0) {
    $target_dir = "uploads/"; // Change this to the desired directory for uploaded files
    $target_file = $target_dir . basename($_FILES["file_memo"]["name"]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the file is allowed (you can modify this to allow specific file types)
    $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");
    if (!in_array($file_type, $allowed_types)) {
        header("Location:form.php?error=Mintak maaf, hanya JPG, JPEG, PNG, GIF, and PDF sahaja dibenarkan.");
    
    } else {

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["file_memo"]["tmp_name"], $target_file)) {
            // File upload success, now store information in the database
            $filename = $_FILES["file_memo"]["name"];
            $filesize = $_FILES["file_memo"]["size"];
            $filetype = $_FILES["file_memo"]["type"];
            $filepath = $target_file;


            extract($_POST);
            // Dapatkan nilai input dari borang Pengurusi Mesyuarat
            $Ketua_Pengarah = isset($_POST['Ketua_Pengarah']) ? 'Ketua Pengarah' : '';
            $Timbalan_Ketua_Pengarah = isset($_POST['Timbalan_Ketua_Pengarah']) ? 'Timbalan Ketua Pengarah' : '';
            $Pengarah_Bahagian = isset($_POST['Pengarah_Bahagian']) ? 'Pengarah Bahagian' : '';
            $lain_lain_pengerusi_Mesyuarat = isset($_POST['Lain_Lain_Pengerusi_Mesyuarat']) ? $_POST['Lain_Lain_Pengerusi_Mesyuarat'] : '';
    
            // Dapatkan nilai input dari borang Jenis Mesyuarat
            $mesyuarat_Dalaman = isset($_POST['mesyuarat_Dalaman']) ? 'Mesyuarat Dalaman' : '';
            $Luaran = isset($_POST['Luaran']) ? 'Mesyuarat Luaran' : '';
            $Lawatan = isset($_POST['Lawatan']) ? 'Mesyuarat Lawatan' : '';
            $Lain_Lain_Jenis_Mesyuarat = isset($_POST['Lain_Lain_Jenis_Mesyuarat']) ? $_POST['Lain_Lain_Jenis_Mesyuarat'] : '';

            //makanan pagi
            // Inisialisasi string kosong untuk menyimpan set makanan pagi yang dipilih
            $set_makanan_pagi = '';

            // Loop melalui huruf A hingga Z
            for ($char = 'a'; $char <= 'z'; $char++) {
            $checkbox_name = 'set_' . $char . '_makanan_pagi';
    
            // Periksa apakah checkbox dengan nama tersebut ada dalam $_POST
            if (isset($_POST[$checkbox_name])) {
            $set_name = 'SET ' . strtoupper($char);
            $set_makanan_pagi .= $set_name . ', ';
             }
             }

            // Hapus koma dan spasi terakhir dari string $set_makanan_pagi
            $set_makanan_pagi = rtrim($set_makanan_pagi, ', ');




            //makanan Tengahari
            // Inisialisasi string kosong untuk menyimpan set tengahari yang dipilih
            $set_makanan_tengahari = '';

            // Loop melalui huruf A hingga Z
            for ($char = 'a'; $char <= 'z'; $char++) {
            $checkbox_name = 'set_' . $char . '_makanan_tengahari';
    
            // Periksa apakah checkbox dengan nama tersebut ada dalam $_POST
            if (isset($_POST[$checkbox_name])) {
            $set_name = 'SET ' . strtoupper($char);
            $set_makanan_tengahari .= $set_name . ', ';
             }
             }


            //minum Petang
            // Inisialisasi string kosong untuk menyimpan set makanan pagi yang dipilih
            $set_minum_petang = '';

            // Loop melalui huruf A hingga Z
            for ($char = 'a'; $char <= 'z'; $char++) {
            $checkbox_name = 'set_' . $char . '_minum_petang';
    
            // Periksa apakah checkbox dengan nama tersebut ada dalam $_POST
            if (isset($_POST[$checkbox_name])) {
            $set_name = 'SET ' . strtoupper($char);
            $set_minum_petang .= $set_name . ', ';
             }
             }


            // Menetapkan nilai NULL jika pemboleh ubah kosong
            $set_makanan_pagi = empty($set_makanan_pagi) ? NULL : $set_makanan_pagi;
            $set_makanan_tengahari = empty($set_makanan_tengahari) ? NULL : $set_makanan_tengahari;
            $set_minum_petang = empty($set_minum_petang) ? NULL : $set_minum_petang;



    


    
            // Dapatkan nilai input dari borang Masa Makanan Perlu Disediakan
            $Sebelum_mesyuarat = isset($_POST['Sebelum_mesyuarat']) ? ' Sebelum mesyuarat  ' : '';
            $Semasa_mesyuarat = isset($_POST['Semasa_mesyuarat']) ? ' Semasa mesyuarat  ' : '';
            $Selepas_mesyuarat = isset($_POST['Selepas_mesyuarat']) ? 'Selepas mesyuarat  ' : '';
            $Lain_Lain_Masa_Makanan_Perlu_Disediakan = isset($_POST['Lain_Lain_Masa_Makanan_Perlu_Disediakan']) ? $_POST['Lain_Lain_Masa_Makanan_Perlu_Disediakan'] : '';
    


    
        
    
            // Dapatkan nilai input dari borang Cara Hidangan
            $di_Dalam_bilik_mesyuarat = isset($_POST['di_Dalam_bilik_mesyuarat']) ? ' di Dalam bilik mesyuarat   ' : '';
            $Di_Luar_mesyuarat = isset($_POST['Di_Luar_mesyuarat']) ? ' Di Luar mesyuarat  ' : '';
            $Buffet = isset($_POST['Buffet']) ? 'Buffet  ' : '';
            $Hidangan_VIP = isset($_POST['Hidangan_VIP']) ? 'Hidangan VIP  ' : '';
    
    
            $status = "Dalam proses";
            $catatan = "-";

            // Database connection
            include("connection.php");

            // Insert the file information into the database





            //echo "Nilai set_makanan_pagi: " . $set_makanan_pagi . "<br>";
            //echo "<pre>";
            //print_r($_POST);
            //echo "</pre>";
            
            $user_id = $_POST['id'];
            $sql = "INSERT INTO  table_makanan (user_id,tarikh_mula,tarikh_akhir,masa,tujuan,Bilangan_Ahli,Nama_Pegawai,Jawatan,Unit_Bahagian,Tarikh_Memohon,ketua_pengarah,Timbalan_Ketua_Pengarah,Pengarah_Bahagian,lain_lain_penegerusi_mesyuarat,Mesyuarat_dalaman,Luaran,Lawatan,Lain_lain_jenis_mesyuarat,sebelum_mesyuarat,Semasa_Mesyuarat,Selepas_Mesyuarat,lain_lain_Makanan_Perlu_Disediakan,sarapan_pagi_Minum_pagi,Makan_Tengahari,Minum_petang,Di_dalam_Bilik_Mesyuarat,Diluar_Bilik_Mesyuarat,Buffet,Hidangan_Vip,memo_type,memo_path,memo_name,status_pemohonan,Catatan) VALUES 
                                          ('$user_id','$tarikh_mula','$tarikh_akhir','$masa','$tujuan','$Bilangan_Ahli','$Nama_pegawai_pemohon','$Jawatan','$Unit_Bahagian','$Tarikh_memohon','$Ketua_Pengarah','$Timbalan_Ketua_Pengarah','$Pengarah_Bahagian','$lain_lain_pengerusi_Mesyuarat','$mesyuarat_Dalaman','$Luaran','$Lawatan','$Lain_Lain_Jenis_Mesyuarat','$Sebelum_mesyuarat','$Semasa_mesyuarat','$Selepas_mesyuarat','$Lain_Lain_Masa_Makanan_Perlu_Disediakan','$set_makanan_pagi','$set_makanan_tengahari','$set_minum_petang','$di_Dalam_bilik_mesyuarat','$Di_Luar_mesyuarat','$Buffet','$Hidangan_VIP','$filetype','$filepath','$filename','$status','$catatan')";
            

            if ($conn->query($sql) === TRUE) {
               header("Location:form.php?submitted=Permohonan anda di proses dalam masa 3 hari bekerja");
            } else {
               header("Location:form.php?error=Permohonan anda tidak berjaya disimpan di dalam database");
            }

            $conn->close();
        } else {
        
           header("Location:form.php?error=Minta maaf,terdapat masalah ketika Muat Naik file/memo anda.");
        }
    }
    } 
   else 
    {
    header("Location:form.php?error=Tiada fail dimuat naik.");
    }

    }


    

    





?>





        

        