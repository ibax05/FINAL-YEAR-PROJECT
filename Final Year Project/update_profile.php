<?php
ini_set('session.gc_maxlifetime', 3600); // Menetapkan masa tamat sesi kepada 1 jam (3600 saat)

session_start(); // Start session

include("connection.php"); // Include connection file

if (isset($_SESSION['id']) || isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_SESSION['id']); // Sanitize ID

    // Query to get user details
    $result = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM register WHERE id = $id"));

    if (isset($_POST['update_profile'])) {

                // Sanitize user input
                $update_name = mysqli_real_escape_string($conn, trim($_POST['update_name']));
                $update_email = mysqli_real_escape_string($conn, trim($_POST['update_email']));
        
                $messages_berjaya_update_email_username = []; // Inisialisasi array untuk menyimpan semua mesej
                $messages_erorr_update_email_username = [];
        
                if (!empty($_POST['update_name'])) {
                    $update_query = mysqli_query($conn, "UPDATE register SET username='$update_name' WHERE id=$id");
        
                    if ($update_query) {
                        $messages_berjaya_update_email_username[] =  "Username & email berjaya di kemaskini!";
                    } else {
                        $messages_erorr_update_email_username[] =  "Username & email gagal di kemaskini!";
                    }
                }
        
                if (!empty($_POST['update_email'])) {
                    $update_query = mysqli_query($conn, "UPDATE register SET Email='$update_email' WHERE id=$id");
        
                    if ($update_query) {
                        $messages_berjaya_update_email_username[] = "Username & email berjaya di kemaskini!!";
                    } else {
                        $messages_erorr_update_email_username[] =  "Username & email gagal di kemaskini!";
                    }
                }


  
              





    







        // 2. Build notification messages with exit logic
        $success_messages = [];
        $error_messages = [];






        if (!empty($_POST['update_password']) || !empty($_POST['c_update_password'])) {
            if ($_POST['update_password'] === $_POST['c_update_password']) {
                // Hash password before updating
                $hash = password_hash(mysqli_real_escape_string($conn, $_POST['update_password']), PASSWORD_DEFAULT);
                mysqli_query($conn, "UPDATE `register` SET password = '$hash' WHERE id = '$id'") or die('Query failed: ' . mysqli_error($conn));
                $success_messages[] = 'Kata laluan berjaya dikemas kini!';
                // Exit if password update succeeds alone

            } else {
                $error_messages[] = 'Kata laluan tidak sepadan!';
            }
        }

        // Check if image is uploaded
        if (!empty($_FILES['update_image']['name'])) {
            $update_image = $_FILES['update_image'];

            // Validate image size
            if ($update_image['size'] > 2000000) {
                $error_messages[] = 'Imej terlalu besar!';
            } else {
                $update_image_name = $update_image['name'];
                $update_image_tmp_name = $update_image['tmp_name'];
                $update_image_folder = 'uploaded_img_profile/' . $update_image_name;

                // Upload image
                if (move_uploaded_file($update_image_tmp_name, $update_image_folder)) {
                    // Update image path in database
                    mysqli_query($conn, "UPDATE `register` SET image = '$update_image_name' WHERE id = '$id'") or die('Query failed: ' . mysqli_error($conn));
                    $success_messages[] = 'Imej berjaya dikemas kini!';
                } else {
                    $error_messages[] = 'Muat naik imej gagal!';
                }
            }
        }

 

    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>profile</title>

   <!-- custom css file link  -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   <link rel="stylesheet" href="css/update_profile.css">

</head>


<header>
<nav class="navbar fixed-top">
        <div class="container-fluid">
            <div class="brand">
                <img src="img/logo.jpeg" alt="bootstrap 4 login page" width=" 78 / 1">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                aria-controls="offcanvasNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end bg-light" tabindex="-1" id="offcanvasNavbar">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">Pegawai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body d-flex flex-column p-0">
                    <nav class="nav flex-column flex-grow-1">
                        <a href="form.php?id=<?php echo $result['id']; ?>" class="nav-link text-dark py-3 px-4 border-bottom">
                        <i class="fa-solid fa-house"></i> Rumah
                        </a>

                        <a href="progress-permohonan.php?id=<?php echo $result['id']; ?>" class="nav-link text-dark  py-3 px-4 border-bottom">
                        <i class="fa-solid fa-hourglass-start"></i> Status Permohonan
                        </a>

                        <a href="#" class="nav-link text-dark fw-bold py-3 px-4 border-bottom">
                        <i class="fa-solid fa-user"></i> Profil
                        </a>
                    </nav>

                    <div class="mt-auto">
                        <a href="logout.php" class="nav-link text-dark py-3 px-4">
                        <i class="fa-solid fa-right-from-bracket"></i> Keluar
                        </a>
                    </div>
                </div>
            </div>
        </div>    
    </nav>
</header>
<body>
   
<div class="update-profile">

    <?php
      $select = mysqli_query($conn, "SELECT * FROM `register` WHERE id = '$id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>
   
   <form action="" method="post" enctype="multipart/form-data">
     <h2>Profil</h2>

     <?php
         if($fetch['image'] == ''){
            echo '<img src="img/default-avatar.png">';
         }else{
            echo '<img src="uploaded_img_profile/'.$fetch['image'].'">';
         }
      ?>

      <?php         
        // 2. Display combined success notifications
        if (!empty($success_messages)) {
            echo '<div class="alert alert-success" role="alert">';
            foreach ($success_messages as $message) {
                echo $message . '<br>';
            }
            echo '</div>';
        }

        // 3. Display individual error notifications
        if (!empty($error_messages)) {
            foreach ($error_messages as $message) {
                echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
            }
        }


        /* 2. Display combined success notifications
        if (!empty( $messages_berjaya_update_email_username)) {
         echo '<div class="alert alert-success" role="alert">';
        foreach ( $messages_berjaya_update_email_username as $message) {
                 echo $message . '<br>';
        }
        echo '</div>';
        }


         // 3. Display individual error notifications
        if (!empty($messages_erorr_update_email_username)) {
        foreach ($messages_erorr_update_email_username as $message) {
        echo '<div class="alert alert-danger" role="alert">' . $message . '</div>';
        }
      }*/




        ?>












    









      
<div class="flex">
    <div class="inputBox">
        <span>Nama Pengguna  :</span>
        <input type="text" name="update_name" value="<?php echo $result['username']; ?>" class="box">
    </div>
    <div class="inputBox">
        <span>Alamat E-Mel:</span>
            <input type="email" name="update_email"  value="<?php echo $result['Email']; ?>" class="box">
    </div>
</div>

<div class="flex">
    <div class="inputBox">
        <span>Kata Laluan  :</span>
        <div class="password-input-container">
           <input type="password" name="update_password" id="password" value="" class="box">
           <i class="fa-solid fa-eye" id="togglePassword"></i>
        </div>
    </div>
    <div class="inputBox">
        <span>Pengesahan Kata Laluan:</span>
        <div class="password-input-container">
            <input type="password" name="c_update_password" id="confirmPassword" value="" class="box">
            <i class="fa-solid fa-eye" id="toggleConfirmPassword"></i>
        </div>
    </div>
</div>


      <div class="flexImage" >
         <div class="inputBoxImage">
         <span>kemas kini gambar anda:</span>
         <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
            
         </div>
      </div>
      <input type="submit" value="kemas kini profil" name="update_profile" class="btn">
   </form>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/42211e8bf7.js" crossorigin="anonymous"></script>    
<script>
function togglePasswordVisibility(inputId, toggleId) {
    const input = document.getElementById(inputId);
    const toggle = document.getElementById(toggleId);

    toggle.addEventListener('click', function() {
        if (input.type === 'password') {
            input.type = 'text';
            toggle.classList.remove('fa-eye');
            toggle.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            toggle.classList.remove('fa-eye-slash');
            toggle.classList.add('fa-eye');
        }
    });
}

togglePasswordVisibility('password', 'togglePassword');
togglePasswordVisibility('confirmPassword', 'toggleConfirmPassword');
</script>
<script>
function hideNotifications(notificationType) {
  var notifications = document.querySelectorAll('.alert-' + notificationType);
  notifications.forEach(function(notification) {
    setTimeout(function() {
      notification.style.display = 'none';
    }, 3000); // Masanya dalam milisaat, ubah mengikut keperluan anda
  });
}

// Gunakan fungsi untuk menghilangkan notifikasi tertentu
hideNotifications('danger');   // Untuk notifikasi kegagalan
hideNotifications('success');  // Untuk notifikasi kejayaan
</script>
</body>
</html>
<?php

}


?>
