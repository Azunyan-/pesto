<?php

	require_once 'pesto.php';

	$pesto = new Pesto();
	if ($pesto->isConfigured()) {
		require_once 'po-config.php';
		$pesto->connectToDatabase($db_host, $db_port, $db_name, $db_user, $db_pass, $secureKey);
	}

?>