<?php

	include 'includes/config.php';

	# for generating the configuration file
	if (isset($_POST['setup'])) {
		$database_host = $_POST['host'];
		$database_port = $_POST['port'];
		$database_name = $_POST['name'];
		$database_user = $_POST['user'];
		$database_pass = $_POST['pass'];	

		$blog_name 	   = $_POST['blogname'];
		$blog_desc	   = $_POST['blogdesc'];
		$display_name  = $_POST['displayname'];
		$full_name     = $_POST['fullname'];
		$email 		   = $_POST['email'];
		$first_pass    = $_POST['pass1'];
		$second_pass   = $_POST['pass2'];

		# connect to database
		if ($pesto->connectToDatabase($database_host, $database_port, $database_name, $database_user, $database_pass)) {
			# we're good to go

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
			if ($create_users_query) {
				# failed
			}

			# BLOG POSTS TABLE

			$pesto->setConfigured(true);
		}
		else {
			# failed to connect
		}

		# generate tables

		# generate the file

		# create the user add to tables
	}
	else {
		// failed
	}

?>