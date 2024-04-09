<?php
session_start(); // Start session
include("connection.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if a file was uploaded without errors
    if (isset($_FILES["new_memo"]) && $_FILES["new_memo"]["error"] == 0   ) {
        $target_dir = "uploads/"; // Change this to the desired directory for uploaded files
        $target_file = $target_dir . basename($_FILES["new_memo"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
        // Check if the file is allowed (you can modify this to allow specific file types)
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");
        if (!in_array($file_type, $allowed_types)) {


            $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
            $id_tempahan_makanan = mysqli_real_escape_string($conn, $_POST['id_tempahan_makanan']);

            $_SESSION['error'] = "Mintak maaf, hanya JPG, JPEG, PNG, GIF, and PDF sahaja dibenarkan.";
            header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
            exit();
        } else {
    
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["new_memo"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["new_memo"]["name"];
                $filetype = $_FILES["new_memo"]["type"];
                $filepath = $target_file;
    
    
                $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
                $id_tempahan_makanan = mysqli_real_escape_string($conn, $_POST['id_tempahan_makanan']);
                $tarikh_mula = isset($_POST['tarikh_mula']) ? $_POST['tarikh_mula'] : "";
                $tarikh_akhir = isset($_POST['tarikh_akhir']) ? $_POST['tarikh_akhir'] : "";
                $masa = isset($_POST['masa']) ? $_POST['masa'] : "";
                $tujuan = isset($_POST['tujuan']) ? $_POST['tujuan'] : "";
                $Bilangan_Ahli = isset($_POST['Bilangan_Ahli']) ? $_POST['Bilangan_Ahli'] : "";



                $Nama_Pegawai = isset($_POST['Nama_Pegawai']) ? $_POST['Nama_Pegawai'] : "";
                $Jawatan = isset($_POST['Jawatan']) ? $_POST['Jawatan'] : "";
                $Unit_Bahagian = isset($_POST['Unit_Bahagian']) ? $_POST['Unit_Bahagian'] : "";
                $Tarikh_Memohon = isset($_POST['Tarikh_Memohon']) ? $_POST['Tarikh_Memohon'] : "";

                $ketua_pengarah = isset($_POST['ketua_pengarah']) ? $_POST['ketua_pengarah'] : "";
                $Timbalan_Ketua_Pengarah = isset($_POST['Timbalan_Ketua_Pengarah']) ? $_POST['Timbalan_Ketua_Pengarah'] : "";
                $Pengarah_Bahagian = isset($_POST['Pengarah_Bahagian']) ? $_POST['Pengarah_Bahagian'] : "";
                $lain_lain_penegerusi_mesyuarat = isset($_POST['lain_lain_penegerusi_mesyuarat']) ? $_POST['lain_lain_penegerusi_mesyuarat'] : "";

                $Mesyuarat_dalaman = isset($_POST['Mesyuarat_dalaman']) ? $_POST['Mesyuarat_dalaman'] : "";
                $Luaran = isset($_POST['Luaran']) ? $_POST['Luaran'] : "";
                $Lawatan = isset($_POST['Lawatan']) ? $_POST['Lawatan'] : "";
                $Lain_lain_jenis_mesyuarat = isset($_POST['Lain_lain_jenis_mesyuarat']) ? $_POST['Lain_lain_jenis_mesyuarat'] : "";


                $sarapan_pagi_Minum_pagi = isset($_POST['sarapan_pagi_Minum_pagi']) ? $_POST['sarapan_pagi_Minum_pagi'] : "";
                $Makan_Tengahari = isset($_POST['Makan_Tengahari']) ? $_POST['Makan_Tengahari'] : "";
                $Minum_petang = isset($_POST['Minum_petang']) ? $_POST['Minum_petang'] : "";
            


                



                $sebelum_mesyuarat = isset($_POST['sebelum_mesyuarat']) ? $_POST['sebelum_mesyuarat'] : "";
                $Semasa_Mesyuarat = isset($_POST['Semasa_Mesyuarat']) ? $_POST['Semasa_Mesyuarat'] : "";
                $Selepas_Mesyuarat = isset($_POST['Selepas_Mesyuarat']) ? $_POST['Selepas_Mesyuarat'] : "";
                $lain_lain_Makanan_Perlu_Disediakan = isset($_POST['lain_lain_Makanan_Perlu_Disediakan']) ? $_POST['lain_lain_Makanan_Perlu_Disediakan'] : "";


                


                                
                $Di_dalam_Bilik_Mesyuarat = isset($_POST['Di_dalam_Bilik_Mesyuarat']) ? $_POST['Di_dalam_Bilik_Mesyuarat'] : "";
                $Diluar_Bilik_Mesyuarat = isset($_POST['Diluar_Bilik_Mesyuarat']) ? $_POST['Diluar_Bilik_Mesyuarat'] : "";
                $Buffet = isset($_POST['Buffet']) ? $_POST['Buffet'] : "";
                $Hidangan_Vip = isset($_POST['Hidangan_Vip']) ? $_POST['Hidangan_Vip'] : "";















    

    
                // Insert the file information into the database
                $sql = "UPDATE table_makanan set tarikh_mula = '$tarikh_mula',tarikh_akhir = '$tarikh_akhir',masa = '$masa',tujuan = '$tujuan',Bilangan_Ahli = '$Bilangan_Ahli',Nama_Pegawai = '$Nama_Pegawai',Jawatan = '$Jawatan',Unit_Bahagian = '$Unit_Bahagian',Tarikh_Memohon = '$Tarikh_Memohon',ketua_pengarah = '$ketua_pengarah',Timbalan_Ketua_Pengarah = '$Timbalan_Ketua_Pengarah',Pengarah_Bahagian = '$Pengarah_Bahagian',lain_lain_penegerusi_mesyuarat = '$lain_lain_penegerusi_mesyuarat',Mesyuarat_dalaman = '$Mesyuarat_dalaman',Luaran ='$Luaran',Lawatan = '$Lawatan',Lain_lain_jenis_mesyuarat = '$Lain_lain_jenis_mesyuarat',sebelum_mesyuarat = '$sebelum_mesyuarat',Semasa_Mesyuarat = '$Semasa_Mesyuarat',Selepas_Mesyuarat = '$Selepas_Mesyuarat',lain_lain_Makanan_Perlu_Disediakan = '$lain_lain_Makanan_Perlu_Disediakan',sarapan_pagi_Minum_pagi = '$sarapan_pagi_Minum_pagi',Makan_Tengahari = '$Makan_Tengahari',Minum_petang = '$Minum_petang',Di_dalam_Bilik_Mesyuarat = '$Di_dalam_Bilik_Mesyuarat',Diluar_Bilik_Mesyuarat = '$Diluar_Bilik_Mesyuarat',Buffet = '$Buffet',Hidangan_Vip ='$Hidangan_Vip',memo_type = '$filetype',memo_path = '$filepath',memo_name = '$filename'  WHERE id_tempahan_makanan = '$id_tempahan_makanan' AND user_id  = '$user_id'";
    
                if ($conn->query($sql) === TRUE) {

                    $_SESSION['updated'] = "Permohonan anda berjaya di kemaskini";
                    header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
                    
                } else {

                    $_SESSION['error'] = "Permohonan anda tidak berjaya di kemaskini";
                    header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
                }
    
                $conn->close();
            } else {

                $_SESSION['error'] = "Minta maaf,terdapat masalah ketika Muat Naik file/memo anda.";
                header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
            }
        }
    } 
    elseif(!isset($_FILES["new_memo"]["name"]) || $_FILES["new_memo"]["name"] == "" )
    {

        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $id_tempahan_makanan = mysqli_real_escape_string($conn, $_POST['id_tempahan_makanan']);
        $tarikh_mula = isset($_POST['tarikh_mula']) ? $_POST['tarikh_mula'] : "";
        $tarikh_akhir = isset($_POST['tarikh_akhir']) ? $_POST['tarikh_akhir'] : "";
        $masa = isset($_POST['masa']) ? $_POST['masa'] : "";
        $tujuan = isset($_POST['tujuan']) ? $_POST['tujuan'] : "";
        $Bilangan_Ahli = isset($_POST['Bilangan_Ahli']) ? $_POST['Bilangan_Ahli'] : "";



        $Nama_Pegawai = isset($_POST['Nama_Pegawai']) ? $_POST['Nama_Pegawai'] : "";
        $Jawatan = isset($_POST['Jawatan']) ? $_POST['Jawatan'] : "";
        $Unit_Bahagian = isset($_POST['Unit_Bahagian']) ? $_POST['Unit_Bahagian'] : "";
        $Tarikh_Memohon = isset($_POST['Tarikh_Memohon']) ? $_POST['Tarikh_Memohon'] : "";

        $ketua_pengarah = isset($_POST['ketua_pengarah']) ? $_POST['ketua_pengarah'] : "";
        $Timbalan_Ketua_Pengarah = isset($_POST['Timbalan_Ketua_Pengarah']) ? $_POST['Timbalan_Ketua_Pengarah'] : "";
        $Pengarah_Bahagian = isset($_POST['Pengarah_Bahagian']) ? $_POST['Pengarah_Bahagian'] : "";
        $lain_lain_penegerusi_mesyuarat = isset($_POST['lain_lain_penegerusi_mesyuarat']) ? $_POST['lain_lain_penegerusi_mesyuarat'] : "";

        $Mesyuarat_dalaman = isset($_POST['Mesyuarat_dalaman']) ? $_POST['Mesyuarat_dalaman'] : "";
        $Luaran = isset($_POST['Luaran']) ? $_POST['Luaran'] : "";
        $Lawatan = isset($_POST['Lawatan']) ? $_POST['Lawatan'] : "";
        $Lain_lain_jenis_mesyuarat = isset($_POST['Lain_lain_jenis_mesyuarat']) ? $_POST['Lain_lain_jenis_mesyuarat'] : "";

        $sarapan_pagi_Minum_pagi = isset($_POST['sarapan_pagi_Minum_pagi']) ? $_POST['sarapan_pagi_Minum_pagi'] : "";
        $Makan_Tengahari = isset($_POST['Makan_Tengahari']) ? $_POST['Makan_Tengahari'] : "";
        $Minum_petang = isset($_POST['Minum_petang']) ? $_POST['Minum_petang'] : "";






        $sebelum_mesyuarat = isset($_POST['sebelum_mesyuarat']) ? $_POST['sebelum_mesyuarat'] : "";
        $Semasa_Mesyuarat = isset($_POST['Semasa_Mesyuarat']) ? $_POST['Semasa_Mesyuarat'] : "";
        $Selepas_Mesyuarat = isset($_POST['Selepas_Mesyuarat']) ? $_POST['Selepas_Mesyuarat'] : "";
        $lain_lain_Makanan_Perlu_Disediakan = isset($_POST['lain_lain_Makanan_Perlu_Disediakan']) ? $_POST['lain_lain_Makanan_Perlu_Disediakan'] : "";


        


                        
        $Di_dalam_Bilik_Mesyuarat = isset($_POST['Di_dalam_Bilik_Mesyuarat']) ? $_POST['Di_dalam_Bilik_Mesyuarat'] : "";
        $Diluar_Bilik_Mesyuarat = isset($_POST['Diluar_Bilik_Mesyuarat']) ? $_POST['Diluar_Bilik_Mesyuarat'] : "";
        $Buffet = isset($_POST['Buffet']) ? $_POST['Buffet'] : "";
        $Hidangan_Vip = isset($_POST['Hidangan_Vip']) ? $_POST['Hidangan_Vip'] : "";


















        // Insert the file information into the database
        $sql = "UPDATE table_makanan set tarikh_mula = '$tarikh_mula',tarikh_akhir = '$tarikh_akhir',masa = '$masa',tujuan = '$tujuan',Bilangan_Ahli = '$Bilangan_Ahli',Nama_Pegawai = '$Nama_Pegawai',Jawatan = '$Jawatan',Unit_Bahagian = '$Unit_Bahagian',Tarikh_Memohon = '$Tarikh_Memohon',ketua_pengarah = '$ketua_pengarah',Timbalan_Ketua_Pengarah = '$Timbalan_Ketua_Pengarah',Pengarah_Bahagian = '$Pengarah_Bahagian',lain_lain_penegerusi_mesyuarat = '$lain_lain_penegerusi_mesyuarat',Mesyuarat_dalaman = '$Mesyuarat_dalaman',Luaran ='$Luaran',Lawatan = '$Lawatan',Lain_lain_jenis_mesyuarat = '$Lain_lain_jenis_mesyuarat',sebelum_mesyuarat = '$sebelum_mesyuarat',Semasa_Mesyuarat = '$Semasa_Mesyuarat',Selepas_Mesyuarat = '$Selepas_Mesyuarat',lain_lain_Makanan_Perlu_Disediakan = '$lain_lain_Makanan_Perlu_Disediakan',sarapan_pagi_Minum_pagi = '$sarapan_pagi_Minum_pagi',Makan_Tengahari = '$Makan_Tengahari',Minum_petang = '$Minum_petang',Di_dalam_Bilik_Mesyuarat = '$Di_dalam_Bilik_Mesyuarat',Diluar_Bilik_Mesyuarat = '$Diluar_Bilik_Mesyuarat',Buffet = '$Buffet',Hidangan_Vip ='$Hidangan_Vip'  WHERE id_tempahan_makanan = '$id_tempahan_makanan' AND user_id  = '$user_id'";

        if ($conn->query($sql) === TRUE)

        {
            $_SESSION['updated'] = "Permohonan anda berjaya di kemaskini";
            header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");

        }

        else
        {

            $_SESSION['error'] = "Permohonan anda tidak berjaya di kemaskini";
            header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
        }

        
        
    }
    else {



        $_SESSION['error'] = "Anda tidak membuat sebarang kemaskini";
        header("Location:update_permohonan_pegawai.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
    }
    }
    
?>



