<?php include 'includes/header.php'; ?>

	<body>
		<!-- Heading section with additional information -->
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<h1>Setup Pesto</h1>
					<p>
						Setup your blog, make sure you have a MySQL database created. Pesto will do the rest
						for you.
					</p>
				</div>
			</div>
		</div>

		<!-- Little bit of space so it's not all squished together -->
		<div class="space"></div>

		<!-- Main page content -->
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<!-- Form for config. generation -->
					<form class="form" method="po-setup.php" role="form">
						<!-- Database form section -->
						<div class="database-settings">
							<h3>Database Settings</h3>
							<div class="form-group">
								<legend for="host">Database Host</legend>
								<input name="host" type="text" class="form-control" autofocus required/>
							</div>

							<div class="form-group">
								<legend for="port">Database Port</legend>
								<input name="port" type="text" class="form-control" required/>
							</div>

							<div class="form-group">
								<legend for="name">Database Name</legend>
								<input name="name" type="text" class="form-control" required/>
							</div>

							<div class="form-group">
								<legend for="user">Database Username</legend>
								<input name="user" type="text" class="form-control" required/>
							</div>

							<div class="form-group">
								<legend for="pass">Database Password</legend>
								<input name="pass" type="password" class="form-control" required/>
							</div>
						</div>

						<div class="space"></div>

						<div class="user-settings">
							<div class="form-group">
								<legend for="displayname">Display Name</legend>
								<input name="displayname" type="text" class="form-control" required/>
							</div>
						</div>

						<button type="submit" class="btn btn-primary form-control">Submit</button>
					</form>
				</div>

				<!-- Sidebar for additional info. -->
				<div class="col-lg-4">
					<h2></h2>
				</div>
			</div>
		</div>
	</body>

</html>