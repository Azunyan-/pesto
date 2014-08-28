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

		<!-- Main page content -->
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<!-- Form for config. generation -->
					<form class="form" method="po-gen-config.php" role="form">
						<!-- Database form section -->
						<div class="database-settings">
							<h2>Database Settings <span class="text-muted small">&mdash; for storing blogs, users, etc</span></h2>
							<div class="form-group">
								<legend for="host">Database Host</legend>
								<input name="host" type="text" class="form-control" placeholder="127.0.0.1" autofocus required/>
							</div>

							<div class="form-group">
								<legend for="port">Database Port</legend>
								<input name="port" type="text" class="form-control" placeholder="3306" required/>
							</div>

							<div class="form-group">
								<legend for="name">Database Name</legend>
								<input name="name" type="text" class="form-control" placeholder="website-db" required/>
							</div>

							<div class="form-group">
								<legend for="user">Database Username</legend>
								<input name="user" type="text" class="form-control" placeholder="root" required/>
							</div>

							<div class="form-group">
								<legend for="pass">Database Password</legend>
								<input name="pass" type="password" class="form-control" placeholder="hunter2" required/>
							</div>
						</div>

						<div class="space"></div>

						<div class="user-settings">
							<h2>Blog Settings <span class="text-muted small">&mdash; personalize your blog</span></h2>
							<div class="form-group">
								<legend for="blogname">Blog Name</legend>
								<input name="blogname" type="text" class="form-control" placeholder="More songs about buildings and food" required/>
							</div>

							<div class="form-group">
								<legend for="displayname">Display Name</legend>
								<input name="displayname" type="text" class="form-control" placeholder="jcarmack" required/>
							</div>

							<div class="form-group">
								<legend for="fullname">Full Name</legend>
								<input name="fullname" type="text" class="form-control" placeholder="John Carmack" required/>
							</div>

							<div class="form-group">
								<legend for="email">Email</legend>
								<input name="email" type="email" class="form-control" placeholder="jcarmack@gmail.com" required/>
							</div>

							<div class="form-group">
								<legend for="pass1">Password</legend>
								<input name="pass1" type="password" class="form-control" placeholder="hunter2" required/>
							</div>

							<div class="form-group">
								<legend for="pass2">Confirm Password</legend>
								<input name="pass2" type="password" class="form-control" placeholder="hunter2" required/>
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

			<div class="gooch"></div>
		</div>
	</body>

</html>