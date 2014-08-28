<?php

	include 'includes/config.php';

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

		$secure_key    = $pesto->generateSecureKey();

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

			# We did it, generate a success message.
			$pesto->generateSuccess("Database successfully populated");
		}
		else {
			# failed to connect
			$pesto->generateError("Could not connect to the specified database");
		}
	}
	

?>