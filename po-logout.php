<?php
	
	include 'includes/header.php';

	if (!$pesto->isLoggedIn()) {
		$pesto->redirect("index.php");
	}
	else {
		$pesto->logout();
		$pesto->redirect("index.php");
	}
	
?>