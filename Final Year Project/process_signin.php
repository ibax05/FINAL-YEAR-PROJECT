<?php
include("connection.php");
session_start();
ini_set('session.gc_maxlifetime', 3600); 

// Define $email and $password
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';


$sql = "SELECT * FROM register WHERE Email='$email'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Fetching the user's data
        $row = $result->fetch_assoc();
        

        
        // Verifying the password
        if (password_verify($password, $row['password'])) {
            // Password matches, redirect to form.html
            $_SESSION['id'] = $row['id'];
            header("Location: form.php");
            exit();
        } else {
            header("Location: signin.php?error=Wrong Password. Please try again.");
        }
    } else {
        header ("Location: signin.php?error=No user found with this email.");
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


