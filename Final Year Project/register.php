<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<img src="img/logo.jpeg" alt="bootstrap 4 login page">
					</div>
					<div class="card fat">
						<div class="card-body">
						<h4 class="card-title">Daftar</h4>
                        <?php if(isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
						<?php header("Refresh: 5; url=register.php");?> 
                        <?php endif; ?>
							<form action="process_register.php" method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="email">Alamat E-Mel</label>
									<input id="email" type="email" class="form-control" name="email" required>
									<div class="invalid-feedback">
										E-mel adalah wajib
									</div>
								</div>


								<div class="form-group">
									<label for="email">Nama Pengguna</label>
									<input id="email" type="text" class="form-control" name="username" required>
									<div class="invalid-feedback">
									  Nama pengguna adalah wajib
									</div>
								</div>

								<div class="form-group">
									<label for="password"> Kata Laluan</label>
									<input id="password" type="password" class="form-control" name="password" required data-eye>
									<div class="invalid-feedback">
										Kata laluan adalah wajib
									</div>
								</div>

								<div class="form-group">
									<label for="password">Pengesahan Kata Laluan</label>
									<input id="password" type="password" class="form-control" name="confirmation_password" required data-eye>
									<div class="invalid-feedback">
									Pengesahan Kata Laluan adalah wajib
									</div>
								</div>


								<div class="form-group m-0">
									<button type="submit" name="register" class="btn btn-primary btn-block">
									  Daftar
									</button>
								</div>
								<div class="mt-4 text-center">
								    Sudah mempunyai akaun? <a href="signin.php">Log Masuk     </a>
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
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="js/my-login.js"></script>
</body>
</html>