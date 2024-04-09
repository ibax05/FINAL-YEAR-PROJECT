<?php require_once "controllerUserData.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>


<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpeg" alt="bootstrap 4 login page" >
					</div>
					<div class="card fat">
						<div class="card-body"> 
							<h4 class="card-title">Lupa kata laluan</h4>
							<form method="POST" action="forgot.php" class="my-login-validation" autocomplete="" novalidate="">
							<?php
                               if(count($errors) > 0){
                            ?>
                            <div class="alert alert-danger text-center">
                                <?php 
                                    foreach($errors as $error){
                                        echo $error;
                                    }
                                ?>
                            </div>
                            <?php
                               }
                               ?>
								<div class="form-group">
									<label for="email">Alamat E-mel</label>
									<input id="email" type="email" class="form-control" name="email" required value="<?php echo $email ?>" required autofocus>
									<div class="invalid-feedback">
									     E-mel adalah wajib
									</div>
									<div class="form-text text-muted">
									      Dengan mengklik "Tetapkan Semula Kata Laluan" kami akan menghantar pautan tetapan semula kata laluan.
									</div>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block" name="check-email" value="Continue">
									     Menetapkan semula kata laluan
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2024 &mdash; AADK
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>