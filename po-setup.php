<?php 

	include 'includes/header.php'; 

	# this is a small function so that the html is cleaner
	# will return a template description placeholder written in
	# markdown, the weird formatting is beacuse it's in a textarea
	# so how you see it is how it's displayed.
	function desc() {
return "# Markdown
Pesto uses markdown for writing blog posts, in addition to this,
we also use it for smaller things such as this description field.
Everything inside of this field will go in the about section on
your Blog! So make this as detailed as you can!

# What is markdown?
Markdown is a simplified markup language which is parsed to HTML.
So instead of writing the following for a link:

	<a href='http://www.google.com'>Google</a>

It is written as...

	[Google](http://www.google.com)

# How do I write Markdown?
You **dont** have to use Markdown to write this description, however,
the audience of your blog will be more likely to read the about section
if it's formatted nicely! If you want to learn markdown, check the link
in the 'Setup Pesto' paragraph!
";
	}

?>

	<body>
		<!-- Heading section with additional information -->
		<div class="container">
			<div class="row">
				<?php 
					# this is important!
					$pesto->generateInfo("It is highly reccommended that you delete this file after setup!");
					
					# include the generation stuff
					include 'includes/po-gen-config.php';
				?>
				<div class="col-lg-8">
					<h1>Setup Pesto</h1>
					<p>
						Setup your blog, make sure you have a MySQL database created. Pesto will do the rest
						for you. Any table name collisions will be deleted/overwritten. Please note that Pesto
						uses Markdown throughout the website, so if you don't know Markdown, I highly suggest
						that you check out <a href="http://markdowntutorial.com/" target="_blank">this tutorial</a>.
						It's very easy to learn!
					</p>
				</div>
			</div>
		</div>

		<!-- Main page content -->
		<div class="container">
			<div class="row">
				<div class="col-lg-8">
					<!-- Form for config. generation -->
					<form class="form" action="po-setup.php" method="POST" role="form">
						<!-- Database form section -->
						<div class="database-settings">
							<h2>Database Settings <span class="text-muted small">&mdash; for storing blogs, users, etc</span></h2>
							<div class="form-group">
								<legend for="host">Database Host</legend>
								<input name="host" type="text" class="form-control" placeholder="127.0.0.1" <?php if (DEBUG_MODE) { echo 'value="localhost"'; }?> autofocus required/>
							</div>

							<div class="form-group">
								<legend for="port">Database Port</legend>
								<input name="port" type="text" class="form-control" placeholder="3306" <?php if (DEBUG_MODE) { echo 'value="3306"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="name">Database Name</legend>
								<input name="name" type="text" class="form-control" placeholder="website-db" <?php if (DEBUG_MODE) { echo 'value="pesto-test"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="user">Database Username</legend>
								<input name="user" type="text" class="form-control" placeholder="root" <?php if (DEBUG_MODE) { echo 'value="pesto"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="pass">Database Password</legend>
								<input name="pass" type="password" class="form-control" placeholder="hunter2" <?php if (DEBUG_MODE) { echo 'value="123"'; }?> required/>
							</div>
						</div>

						<div class="space"></div>

						<div class="user-settings">
							<h2>Blog Settings <span class="text-muted small">&mdash; personalize your blog</span></h2>
							<div class="form-group">
								<legend for="blogname">Blog Name</legend>
								<input name="blogname" type="text" class="form-control" placeholder="More songs about buildings and food" <?php if (DEBUG_MODE) { echo 'value="Testing Blog"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="tagline">Tagline</legend>
								<input name="tagline" type="text" class="form-control" placeholder="Probably the best blogan in the world" <?php if (DEBUG_MODE) { echo 'value="wow"'; } ?> required/>
							</div>

							<div class="form-group">
								<legend for="blogdesc">Blog Description</legend>
								<textarea rows="25" name="blogdesc" class="form-control" placeholder="<?php echo desc(); ?>" <?php if (DEBUG_MODE) { echo 'value="test"'; }?> required></textarea>
							</div>

							<div class="form-group">
								<legend for="displayname">Display Name</legend>
								<input name="displayname" type="text" class="form-control" placeholder="jcarmack" <?php if (DEBUG_MODE) { echo 'value="admin"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="fullname">Full Name</legend>
								<input name="fullname" type="text" class="form-control" placeholder="John Carmack" <?php if (DEBUG_MODE) { echo 'value="Testing Things"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="email">Email</legend>
								<input name="email" type="email" class="form-control" placeholder="jcarmack@gmail.com" <?php if (DEBUG_MODE) { echo 'value="test@test.test"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="pass1">Password</legend>
								<input name="pass1" type="password" class="form-control" placeholder="hunter2" <?php if (DEBUG_MODE) { echo 'value="123"'; }?> required/>
							</div>

							<div class="form-group">
								<legend for="pass2">Confirm Password</legend>
								<input name="pass2" type="password" class="form-control" placeholder="hunter2" <?php if (DEBUG_MODE) { echo 'value="123"'; }?> required/>
							</div>
						</div>

						<button type="submit" name="setup" class="btn btn-primary form-control">Submit</button>
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