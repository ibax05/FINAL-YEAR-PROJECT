<?php
session_start();
include("connection.php");

if(isset($_POST['user_id'])) {

    $id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM register WHERE id = $id"));

    if(isset($_POST['update_profile'])) {
        $update_name = mysqli_real_escape_string($conn, $_POST['update_name']);
        $update_email = mysqli_real_escape_string($conn, $_POST['update_email']);
        mysqli_query($conn, "UPDATE `register` SET username = '$update_name', Email = '$update_email' WHERE id = '$id'") or die('Query failed');

        $password_error = '';
        $password_success = '';
        $update_password = mysqli_real_escape_string($conn, md5($_POST['update_password']));
        $c_update_password = mysqli_real_escape_string($conn, md5($_POST['c_update_password']));

        if(!empty($update_password) || !empty($c_update_password)) {
            if($update_password == $c_update_password) {
                $hash = password_hash($update_password, PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE `register` SET password = '$hash' WHERE id = '$id'") or die('Query failed');
                
                header("Location:update_profile.php?success=Password updated successfully!");
            } else {
                
                $password_error = 'Passwords do not match!';
            }
        }

        $update_image = $_FILES['update_image']['name'];
        $update_image_size = $_FILES['update_image']['size'];
        $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
        $update_image_folder = 'uploaded_img_profile/' . $update_image;

        $image_error = '';
        $image_success = '';

        if(!empty($update_image)) {
            if($update_image_size > 2000000) {
                $image_error = 'Image is too large!';
            } else {
                $image_update_query = mysqli_query($conn, "UPDATE `register` SET image = '$update_image' WHERE id = '$id'") or die('Query failed');
                if($image_update_query) {
                    move_uploaded_file($update_image_tmp_name, $update_image_folder);
                }
                header("Location: update_profile.php?success=Image updated successfully!!");
                
            }
        }
    }

}

?>