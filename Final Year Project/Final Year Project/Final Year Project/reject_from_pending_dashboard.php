
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
if ($_SERVER["REQUEST_METHOD"] == "POST") {

$id_tempahan_makanan = $_POST["id_tempahan_makanan"];
$message = $_POST["message"];
$lowercase_message = strtolower($message);

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
if ($row) {
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


        // Update the application comment
        $sql2 = "UPDATE table_makanan SET Catatan = ? WHERE id_tempahan_makanan = ?";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bind_param("si", $message, $id_tempahan_makanan);
        $stmt2->execute();

        // Update the application status to approved
        $sql3 = "INSERT INTO table_status (id_tempahan_makanan, user_id, Nama_pemohon, Tarikh_Memohon, status_pemohonan) VALUES (?, ?, ?, ?, ?)";
        $stmt3 = $conn->prepare($sql3);
        $status = "Ditolak";
        $stmt3->bind_param("iisss", $id_tempahan_makanan, $user_id, $Nama_Pegawai, $Tarikh_Memohon, $status);
        $stmt3->execute();


        $sql4 = "UPDATE table_makanan SET status_pemohonan = 'Ditolak' WHERE id_tempahan_makanan = ?";
        $stmt4 = $conn->prepare($sql4);
        $stmt4->bind_param("i", $id_tempahan_makanan);
        $stmt4->execute();

        $mail->Body = "Maaf, permohonan id tempahan anda $id_tempahan_makanan telah ditolak kerana $lowercase_message .";

        $mail->send();

        $_SESSION['rejected_from_dashboard'] = "Permohonan pemohon berjaya di ditolak";
        header("Location:pending_from_dashboard.php");
    } catch (Exception $e) {
        $_SESSION['error_email_from_dashboard'] = "Permohonan pemohon tidak berjaya di email kan. Mailer Error: {$mail->ErrorInfo}";
        header("Location:pending_from_dashboard.php");
    }
} else {
    $_SESSION['error_user_from_dashboard'] = "No user found.";
    header("Location:pending_from_dashboard.php");
}

// Close the database connection
$conn->close();
}
?>



