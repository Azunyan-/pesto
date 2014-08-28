<?php
	
	require_once 'po-file-writer.php';

	# for generating the configuration file
	if (isset($_POST['setup'])) {

		# information for database connection
		$database_host = $_POST['host'];
		$database_port = $_POST['port'];
		$database_name = $_POST['name'];
		$database_user = $_POST['user'];
		$database_pass = $_POST['pass'];	

		# users desired blog info stuff
		$blog_name 	   = $_POST['blogname'];
		$blog_desc	   = $_POST['blogdesc'];
		$display_name  = $_POST['displayname'];
		$full_name     = $_POST['fullname'];
		$email 		   = $_POST['email'];
		$first_pass    = $_POST['pass1'];
		$second_pass   = $_POST['pass2'];

		$conf_writer   = new FileWriter("po-config.php");
		$secure_key    = $pesto->generateSecureKey();

		if ($first_pass != $second_pass) {
			$pesto->generateError("Passwords do not match");
		}

		# connect to database
		if ($pesto->connectToDatabase($database_host, $database_port, $database_name, $database_user, $database_pass, $secure_key)) {
			# we're good to go

			# DELETE EXISTING TABLES
			$delete_users_sql = "DROP TABLE IF EXISTS `po-users`";
			$delete_users_query = $pesto->getConnection()->query($delete_users_sql);
			$delete_blog_posts_sql = "DROP TABLE IF EXISTS `po-blog-posts`";
			$delete_blog_posts_query = $pesto->getConnection()->query($delete_blog_posts_sql);

			# USERS TABLE
			$create_users_sql = "
				CREATE TABLE `po-users` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`username` varchar(10) NOT NULL,
					`email` tinytext NOT NULL,
					`password` varchar(255) NOT NULL,
					`name` varchar(40) NOT NULL,
					`level` int(11) NOT NULL,
					PRIMARY KEY (`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;
			";
			$create_users_query = $pesto->getConnection()->query($create_users_sql);
			if (!$create_users_query) {
				$pesto->generateError("Failed to create `po-users` table!");
			}

			# BLOG POSTS TABLE
			$create_blog_posts_sql = "
				CREATE TABLE `po-blog-posts` (
					`id` int(11) NOT NULL AUTO_INCREMENT,
					`title` varchar(200) NOT NULL,
					`content` text NOT NULL,
					`owner_id` int(11) unsigned NOT NULL,
					`date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
					PRIMARY KEY(`id`)
				) ENGINE=MyISAM DEFAULT CHARSET=latin1;
			";
			$create_blog_posts_query = $pesto->getConnection()->query($create_blog_posts_sql);
			if (!$create_blog_posts_query) {
				$pesto->generateError("Failed to create `po-blog-posts` table!");
			}

			# GENERATE CONFIGURATION FILE

			## start php tag
			$conf_writer->addLine("<?php");
			$conf_writer->emptyLine();	
			
			## add php database stuff
			$conf_writer->addLine('$db_host = \'' . addslashes($database_host) . '\';', "\t"); # $db_host   = 'whatever';
			$conf_writer->addLine('$db_port = \'' . addslashes($database_port) . '\';', "\t"); # $db_port   = 'whatever';
			$conf_writer->addLine('$db_name = \'' . addslashes($database_name) . '\';', "\t"); # $db_name   = 'whatever';
			$conf_writer->addLine('$db_user = \'' . addslashes($database_user) . '\';', "\t"); # $db_user   = 'whatever';
			$conf_writer->addLine('$db_pass = \'' . addslashes($database_pass) . '\';', "\t"); # $db_pass   = 'whatever';
			$conf_writer->addLine('$secureKey = \'' . addslashes($secure_key) . '\';', "\t");  # $secureKey = 'my secure key';
			$conf_writer->addLine('$blog_desc = \'' . addslashes($blog_desc) . '\';', "\t");   # $blog_desc = 'my blog';
			$conf_writer->addLine('$blog_name = \'' . addslashes($blog_name) . '\';', "\t");   # $blog_name = 'The Pesto Blog';

			## close php tag
			$conf_writer->emptyLine();	
			$conf_writer->addLine("?>");

			## write file
			$conf_writer->writeFile();

			# ADD USER TO DATABASE
			$pesto->registerUser($display_name, $first_pass, $email, $full_name, 0);

			# GENERATE MESSAGE STUFF
			$pesto->generateSuccess("
				Tables created, administrator registered. Setup is complete, redirecting in <span id='counter'>5</span> seconds...<br />
				Hasn't redirected yet? <a href='index.php'>click here</a>
			");
		}
		else {
			# failed to connect
			$pesto->generateError("Could not connect to the specified database");
		}
	}
	
?>

<script>
function countdown() {
	var counter = $('#counter').html();
	var counter_index = parseInt(counter);
	if (counter_index < 2) {
		location.href = "index.php";
	}
	counter_index -= 1;
	$('#counter').html(counter_index);
}
$(document).ready(function() {
	if ($('#counter').is(':visible')) {
		setInterval(countdown, 1000);
	}
});
</script>