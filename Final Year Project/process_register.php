<?php
    session_start();
    include("connection.php");
    if(isset($_POST['register']))
    {
        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['confirmation_password'];
        $image = isset($_POST['image']) ? $_POST['image'] : "";
        $code = 0;

        $sql = "SELECT * FROM register WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $count_email = mysqli_num_rows($result);

        $sql = "SELECT * FROM register WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $count_username = mysqli_num_rows($result);

        if ($count_email == 0 && $count_username == 0) {
            if ($password == $repassword) {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql_insert = "INSERT INTO register (Email, username, password,image,code) VALUES ('$email', '$username', '$hash','$image','$code')";
                $result_insert = mysqli_query($conn, $sql_insert);
                if ($result_insert) {
                    header("Location: signin.php?registered=success");
                    exit(); // Stop execution after redirection
                }
            } else {
                header("Location: register.php?error=Kata Laluan Tidak Sama");
                exit(); // Stop execution after redirection
            }
        } else {
            if ($count_email > 0) {
                // Email already exists, show alert and redirect
                header("Location: register.php?error=E-mel ini sudah wujud");
                exit(); // Stop execution after redirection
            } else if ($count_username > 0) {
                // Username already exists, show alert and redirect
                header("Location: register.php?error=Nama pengguan ini sudah wujud");
                exit(); // Stop execution after redirection
            }
        }
    }
?>



