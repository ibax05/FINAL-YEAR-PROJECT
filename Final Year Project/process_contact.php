<?php
ini_set('session.gc_maxlifetime', 3600); // Set session timeout to 1 hour (3600 seconds)
// Set sessio
session_start(); // Start session


// Include database connection
include("connection.php");

// Select email admin from database
$sql = "SELECT * FROM login_admin";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_id = $_POST['user_id'];
    $id_tempahan_makanan = $_POST['id_tempahan_makanan'];
    $Unit_Bahagian = $_POST['Unit_Bahagian'];
    $Email_Admin = $row['Email'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Insert data into table_contact
    $sql3 = "INSERT INTO table_contact (name_Pemohon, Message,Unit_Bahagian,id_tempahan_makanan,user_id) VALUES (?, ?, ?, ?,?)";
    $stmt3 = $conn->prepare($sql3);
    $stmt3->bind_param("sssii", $name, $message,$Unit_Bahagian,$id_tempahan_makanan, $user_id);
    $stmt3->execute();

    // Check if data is inserted successfully
    if ($stmt3->affected_rows > 0) {
        $_SESSION['success_message'] = "Pesan Anda berhasil dikirim!";
    } else {
        $_SESSION['error_message'] = "Gagal mengirim pesan. Silakan coba lagi.";
    }

    // Set success message
    $_SESSION['success_message'] = "Your message has been sent successfully!";
    header("Location: progress-permohonan.php?user_id=$user_id&id_tempahan_makanan=$id_tempahan_makanan");
    exit;
}

// Close the database connection
$conn->close();
?>




