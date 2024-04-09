<?php require_once "controllerUserData.php"; ?>
<?php if($_SESSION['info'] == false){ header('Location: signin.php'); } ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .login-form {
            width: 400px;
            padding: 40px;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-form h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-form .btn-primary {
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Log Masuk</h2>
        <?php if(isset($_SESSION['info'])) { ?>
            <!-- Menampilkan pesan sukses jika ada -->
            <div class="alert alert-success text-center">
                <?php echo $_SESSION['info']; ?>
            </div>
        <?php } ?>
        <!-- Form Login -->
        <form action="signin.php" method="POST">
            <div class="form-group">
                <button type="submit" name="login-now" class="btn btn-primary btn-block">Log Masuk</button>
            </div>
        </form>
    </div>
</body>
</html>