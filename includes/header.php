<?php

	require_once 'config.php';

	# debug mode is true for developers
	define ('DEBUG_MODE', true);

	# only redirect if we aren't already on the setup page.
	if (!$pesto->isConfigured() && !$pesto->isCurrentPage("po-setup.php")) {
		$pesto->setupPesto();
	}

?>


	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>
			<?php 
				if ($pesto->isConfigured()) {
					echo $blog_name;
				}
				else {
					echo 'Setup Pesto';
				}
			?>
		</title>

		<!-- CSS -->
		<link type="text/css" rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" />
		<link type="text/css" rel="stylesheet" href="css/pesto.css" />

		<!-- JavaScript -->
		<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	</head>
