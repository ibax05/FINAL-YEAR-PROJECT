
<?php
session_start(); // Memulakan sesi
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

//sambungkan pangkalan data
include("connection.php");

// Securely fetch the applicant ID from URL
$id_tempahan_makanan = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Prepare and execute the SELECT statement
$sql = "SELECT tm.*, r.Email 
        FROM table_makanan tm
        JOIN register r ON r.id = tm.user_id
        WHERE tm.id_tempahan_makanan = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tempahan_makanan);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

$user_id = $row['user_id'];
$Nama_Pegawai = $row['Nama_Pegawai'];
$Tarikh_Memohon = $row['Tarikh_Memohon'];
$Catatan = $row['Catatan'];


// Check if user was found
if ($row ) {
    // Initialize PHPMailer and set mail properties
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'qaimanqaiman930@gmail.com';
        $mail->Password = 'giwl tacb focm xasy';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = '465';

        $mail->setFrom('qaimanqaiman930@gmail.com', 'ADMIN');
        $mail->addAddress($row['Email']);

        $mail->isHTML(true);
        $mail->Subject = "Maklumat Tempahan Makanan";




        $sql2 = "UPDATE table_makanan SET status_pemohonan='Diluluskan' WHERE id_tempahan_makanan = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("i", $id_tempahan_makanan);
        $stmt2->execute();


        // Update the application status to approved
        $sql3 = "INSERT INTO table_status (id_tempahan_makanan, user_id, Nama_pemohon, Tarikh_Memohon, status_pemohonan) VALUES (?, ?, ?, ?, ?)";
        $stmt3 = $conn->prepare($sql3);
        $status = "Diluluskan";
        $stmt3->bind_param("iisss", $id_tempahan_makanan, $user_id, $Nama_Pegawai, $Tarikh_Memohon, $status);
        $stmt3->execute();

        $mail->Body = "Tahniah, permohonan id tempahan anda $id_tempahan_makanan telah disetujui .";

        $mail->send();





        $_SESSION['approved'] = "Permohonan pemohon berjaya di diluluskan";
        header("Location:status_permohon.php");

    } catch (Exception $e) {
        $_SESSION['error_email_approved'] = "Permohonan pemohon tidak berjaya di email kan. Mailer Error: {$mail->ErrorInfo}";
        header("Location:status_permohon.php");
    }
} else {
    $_SESSION['error_user_approved'] = "No user found.";
    header("Location:status_permohon.php");
}

// Close the database connection
$conn->close();
?>



