<?php 

	include 'includes/header.php'; 

	if ($pesto->isLoggedIn()) {
		$pesto->redirect("index.php");
	}
?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">
				<div class="col-lg-8">
					<div class="post">
						<?php include 'includes/po-check-login.php'; ?>
						<h1>Login</h1>
						<form class="form" action="po-login.php" method="POST">
							<div class="form-group">
								<label for="displayname">Username:</label>
								<input type="text" name="displayname" class="form-control" autofocus required/>
							</div>

							<div class="form-group">
								<label for="password">Password:</label>
								<input type="password" name="password" class="form-control" required/>
							</div>

							<div class="small-space"></div>

							<button type="submit" name="login" class="btn btn-primary form-control">Login</button>
						</form>
					</div>
				</div>
			</div>
		</div>

	</body>

<?php include 'includes/footer.php'; ?>