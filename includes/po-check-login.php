<?php

	if (isset($_POST['login']) && isset($_POST['displayname']) && isset($_POST['password'])) {
		$displayname = $_POST['displayname'];
		$password 	 = $_POST['password'];

		if ($pesto->login($displayname, $password)) {
			$pesto->redirect("index.php");
		}
		else {
			$pesto->generateError("Failed to login");
		}
	}

?>