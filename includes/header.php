<?php

	require_once 'config.php';

	# only redirect if we aren't already on the setup page.
	if (!$pesto->isConfigured() && !$pesto->isCurrentPage("po-setup.php")) {
		$pesto->setupPesto();
	}

?>