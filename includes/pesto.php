<?php

	class Pesto {

		# if pesto is configured
		private $configured;

		# "middleman" for connecting to the database
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

		# the current user
		private $user = false;

		# if the user is logged in
		private $loggedIn;

		# login cookie
		private $cookie;

		# current user session
		private $session;

		# if the user should be remembered
		private $remCook;

		# secure key
		private $secureKey;

		# if login details should be remembered
		private $rememberLoginDetails;

		# Connect to the given database
		#
		# $host      => database host
		# $port      => database port, typically 3306
		# $name      => database name
		# $user      => username to connect to db with
		# $pass      => password to connect to db with
		# $secureKey => secure key for hashing stuff
		public function connectToDatabase($host, $port, $name, $user, $pass, $secureKey) {
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
				$this->cookie  = isset($_COOKIE['logSyslogin']) ? $_COOKIE['logSyslogin'] : false;
				$this->session = isset($_SESSION['logSyscuruser']) ? $_SESSION['logSyscuruser'] : false;
				$this->remCook = isset($_COOKIE['logSysrememberMe']) ? $_COOKIE['logSysrememberMe'] : false;

				$encUserId	   = hash("sha256", $this->secureKey . $this->session . $this->secureKey);
				$this->loggedIn = $this->cookie == $encUserId ? true : false;

				if ($this->rememberLoginDetails === true && isset($this->remCook) && $this->loggedIn === false) {
					$encUserId		= hash("sha256", $this->secureKey . $this->remCook . $this->secureKey);
					$this->loggedIn = $this->cookie == $encUserId ? true : false;
					if ($this->loggedIn === true) {
						$_SESSION['logSyscuruser'] = $this->remCook;
					}
				}
				$this->user = $this->session;
				$this->setConfigured(true);
				return true;
			}
			catch (PDOException $ex) {
				return false;
			}
			return false;
		}

		# Generates an error message as a Bootstrap danger alert
		#
		# $message  => The message contained in the alert
		public function generateError($message) {
			echo "
				<div class='alert alert-danger' role='alert'>
					{$message}
				</div>
			";
		}

		# Generates a success message as a Bootstrap success alert
		#
		# $message  => The message contained in the alert
		public function generateSuccess($message) {
			echo "
				<div class='alert alert-success' role='alert'>
					{$message}
				</div>
			";
		}

		# generate a secure key with the given length
		#
		# $length   => length of the secure key, default is 12
		public function generateSecureKey($length = 12) {
			$letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			return substr(str_shuffle($letters), 0, $length);
		}

		# function for logging into an account
		#
		# $username => username for the account we're logging into
		# $password => password for the account we're logging into (raw)
		# $cookies  => whether or not to use cookies
		public function login($username, $password, $cookies = true) {
			if ($this->isConfigured()) {
			}
		}

		# redirect to the setup page for
		# first time configuration
		public function setupPesto() {
			$this->redirect("po-setup.php");
		}

		# set if pesto has been configured yet
		#
		# $configured => whether pesto has been configured
		# 			     or not.
		public function setConfigured($configured) {
			$this->configured = $configured;
		}

		# return if pesto has been
		# configured or not
		public function isConfigured() {
			return $this->configured;
		}

		# return the pdo connection to the 
		# database
		public function getConnection() {
			return $this->pdo;
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
		#
		# $url      => the url to check
		public function isCurrentPage($url) {
			$parts = parse_url($this->getCurrentPageURL());
			return substr($parts['path'], strrpos($parts['path'], '/') + 1) == $url;
		}

		# redirect to the given url, and status
		# status is default at 302
		#
		# $url 	    => the url to redirect to
		# $status   => the status of redirect, default is 302 (OK)
		public function redirect($url, $status = 302) {
			header("Location: $url", true, $status);
		}

	}

?>