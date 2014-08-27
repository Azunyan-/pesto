<?php include 'includes/header.php'; ?>

<!DOCTYPE html>
<html lang="en">

	<head>
		<title>Setup Pesto</title>
		<link type="text/css" rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>

	<body>
		<div class="container">
			<h1>Setup Pesto</h1>
			<p>
				Setup your Pesto account. Make sure you have a database created on your webhost!
			</p>
			<div class="row">
				<div class="col-lg-8">
					<form class="form" method="po-setup.php" role="form">
						<div class="form-group">
							<legend for="host">Database Host</legend>
							<input name="host" type="text" class="form-control" />
						</div>

						<div class="form-group">
							<legend for="port">Database Port</legend>
							<input name="port" type="text" class="form-control" />
						</div>

						<div class="form-group">
							<legend for="name">Database Name</legend>
							<input name="name" type="text" class="form-control" />
						</div>

						<div class="form-group">
							<legend for="user">Database Username</legend>
							<input name="user" type="text" class="form-control" />
						</div>

						<div class="form-group">
							<legend for="pass">Database Password</legend>
							<input name="pass" type="password" class="form-control" />
						</div>

						<button type="submit" class="btn btn-primary form-control">Submit</button>
					</form>
				</div>
				<div class="col-lg-4">
					<h2>Fuck</h2>
				</div>
			</div>
		</div>
	</body>

</html>