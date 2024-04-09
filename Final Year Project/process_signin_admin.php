<?php
include("connection.php");
session_start();
ini_set('session.gc_maxlifetime', 3600); 

// Define $email and $password
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$After_trim_password = trim($password);


$sql = "SELECT * FROM login_admin WHERE Email='$email'";
$result = $conn->query($sql);

if ($result) {
    if ($result->num_rows > 0) {
        // Fetching the user's data
        $row = $result->fetch_assoc();
        

        
        // Verifying the password
        if (strtolower($After_trim_password) == strtolower($row['password'])) {


              // Password matches, redirect to form.html
              $_SESSION['id_Admin'] = $row['id'];
              header("Location: dashboard.php");
              exit();
        } else {
            header("Location: sign_in__Admin.php?error2=Wrong Password. Please try again.");
        }
    } else {
        header ("Location: sign_in__Admin.php?error2=No user found with this email.");
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>


