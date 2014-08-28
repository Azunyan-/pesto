<?php

	class Pesto {

		# if pesto is configured
		private $configured;

		private $pdo;

		# host for database
		private $db_host;

		# port for database, typically 3306
		private $db_port;

		# name for database
		private $db_name;

		# username for database
		private $db_user;

		# password for database
		private $db_pass;

		public function connectToDatabase($host, $port, $name, $user, $pass) {
			# initialise db stuff
			$this->db_host = $host;
			$this->db_port = $port;
			$this->db_name = $name;
			$this->db_user = $user;
			$this->db_pass = $pass;

			# start a new session
			session_start();

			# create connection
			try {
				$this->pdo = new PDO("mysql:dbname={$this->db_name};host={$this->db_host};port={$this->db_port}", $this->db_user, $this->db_pass);
				return true;
			}
			catch (PDOException $ex) {
				echo $ex;
				return false;
			}
			return false;
		}

		# redirect to the setup page for
		# first time configuration
		public function setupPesto() {
			$this->redirect("po-setup.php");
		}

		# return if pesto has been
		# configured or not
		public function isConfigured() {
			return $this->configured;
		}

		# return the current page url
		public function getCurrentPageURL() {
			$pageURL = 'http';
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") {
				$pageURL .= "s";
			}
			$pageURL .= "://";
			if ($_SERVER['SERVER_PORT'] != 80) {
				$pageURL .= $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REQUEST_URI'];
			}
			else {
				$pageURL .= $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
			}
			return $pageURL;
		}

		# return the current page
		# e.g http://google.com/bill_gates_naked.php => bill_gates_naked.php
		public function getCurrentPage() {
			$parts = parse_url($this->getCurrentPageURL());
			return substr($parts['path'], strrpos($parts['path'], '/') + 1);
		}

		# return if the current page
		# is equal to the url specified
		# e.g:
		# code is:
		#		isCurrentPage("bill_gates_naked.php");
		# and the page is:
		# 		http://google.com/bill_gates_naked.php => bill_gates_naked.php
		# will return:
		#		true
		public function isCurrentPage($url) {
			$parts = parse_url($this->getCurrentPageURL());
			return substr($parts['path'], strrpos($parts['path'], '/') + 1) == $url;
		}

		# redirect to the given url, and status
		# status is default at 302
		public function redirect($url, $status = 302) {
			header("Location: $url", true, $status);
		}

	}

?>