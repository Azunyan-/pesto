<?php

	require_once 'includes/config.php';

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
			echo 'awesome';
			# we're good to go
		}
		else {
			echo 'oh dear';
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