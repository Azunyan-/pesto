<?php

	require_once 'libs/password.php';

	define('ADMIN', 0);		# administrator, all priveleges
	define('AUTHOR', 1);	# author, can only write posts
	define('DEFAULT', 2);	# default, can only comment

	class Pesto {

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

		public function isConfigured() {
			return file_exists("po-config.php");
		}

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

		# Generates an informational message as a Bootstrap danger alert
		#
		# $message  => The message contained in the alert
		public function generateInfo($message) {
			echo "
				<div class='alert alert-info' role='alert'>
					{$message}
				</div>
			";
		}

		# Generates a warning message as a Bootstrap danger alert
		#
		# $message  => The message contained in the alert
		public function generateWarning($message) {
			echo "
				<div class='alert alert-warning' role='alert'>
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

		# For truncating a blog post and putting a ... at the end. This function
		# will close any tags to avoid any HTML "leaking" onto other parts of the
		# page
		#
		# $text 		=> the text to truncate
		# $length   	=> length of the text, default is 100
		# $ending   	=> ending of the text, default is an ellipse '...'
		# $exact    	=> will preserve words if true, false by default
		# $considerHTML => will handle html tags if true, true by default
		function truncateHtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
			if ($considerHtml) {
				// if the plain text is shorter than the maximum length, return the whole text
				if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
					return $text;
				}
				// splits all html-tags to scanable lines
				preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
				$total_length = strlen($ending);
				$open_tags = array();
				$truncate = '';
				foreach ($lines as $line_matchings) {
					// if there is any html-tag in this line, handle it and add it (uncounted) to the output
					if (!empty($line_matchings[1])) {
						// if it's an "empty element" with or without xhtml-conform closing slash
						if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
							// do nothing
						// if tag is a closing tag
						} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
							// delete tag from $open_tags list
							$pos = array_search($tag_matchings[1], $open_tags);
							if ($pos !== false) {
							unset($open_tags[$pos]);
							}
						// if tag is an opening tag
						} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
							// add tag to the beginning of $open_tags list
							array_unshift($open_tags, strtolower($tag_matchings[1]));
						}
						// add html-tag to $truncate'd text
						$truncate .= $line_matchings[1];
					}
					// calculate the length of the plain text part of the line; handle entities as one character
					$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
					if ($total_length+$content_length> $length) {
						// the number of characters which are left
						$left = $length - $total_length;
						$entities_length = 0;
						// search for html entities
						if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
							// calculate the real length of all entities in the legal range
							foreach ($entities[0] as $entity) {
								if ($entity[1]+1-$entities_length <= $left) {
									$left--;
									$entities_length += strlen($entity[0]);
								} else {
									// no more characters left
									break;
								}
							}
						}
						$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
						// maximum lenght is reached, so get off the loop
						break;
					} else {
						$truncate .= $line_matchings[2];
						$total_length += $content_length;
					}
					// if the maximum length is reached, get off the loop
					if($total_length>= $length) {
						break;
					}
				}
			} else {
				if (strlen($text) <= $length) {
					return $text;
				} else {
					$truncate = substr($text, 0, $length - strlen($ending));
				}
			}
			// if the words shouldn't be cut in the middle...
			if (!$exact) {
				// ...search the last occurance of a space...
				$spacepos = strrpos($truncate, ' ');
				if (isset($spacepos)) {
					// ...and cut the text in this position
					$truncate = substr($truncate, 0, $spacepos);
				}
			}
			// add the defined ending to the text
			$truncate .= $ending;
			if($considerHtml) {
				// close all unclosed html-tags
				foreach ($open_tags as $tag) {
					$truncate .= '</' . $tag . '>';
				}
			}
			return $truncate;
		}

		# generate a secure key with the given length
		#
		# $length   => length of the secure key, default is 12
		public function generateSecureKey($length = 12) {
			$letters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789$@%&*()£![];.,";
			return substr(str_shuffle($letters), 0, $length);
		}

		# function for logging into an account
		#
		# $username => username for the account we're logging into
		# $password => password for the account we're logging into (raw)
		# $cookies  => whether or not to use cookies
		#
		# returns true if logged in successfully, otherwise, false.
		public function login($username, $password, $cookies = true) {
			if ($this->isConfigured()) {
				$add_user_sql   = "SELECT id, password FROM `po-users` WHERE `username` = :login ORDER BY `id` LIMIT 1";
				$add_user_query = $this->getConnection()->prepare($add_user_sql);

				$add_user_query->bindParam(":login", $username);
				$add_user_query->execute();

				if ($add_user_query->rowCount() == 0) {
					return false;
				}
				else {
					$user_row 			 = $add_user_query->fetch(PDO::FETCH_ASSOC);
					$user_id 			 = $user_row['id'];			# users id
					$user_pass_encrypted = $user_row['password'];	# users hashed password

					if (password_verify($password, $user_pass_encrypted)) {
						if ($cookies === true) {
							$_SESSION['logSyscuruser'] = $user_id;

							# save for 2 weeks
							setcookie("logSyslogin", hash("sha256", $this->secureKey . $user_id . $this->secureKey), time() + (14 * 24 * 60 * 60), "/");
							if (isset($_POST['remember_me']) && $this->rememberLoginDetails === true) {
								setcookie("logSysrememberMe", $user_id, time() + (14 * 24 * 60 * 60), "/");
							}
							$this->loggedIn = true;
						}
						return true;
					}
					else {
						return false;
					}
				}
			}
			else {
				return false;
			}
		}

		# Returns if the current user
		# is logged in
		public function isLoggedIn() {
			return $this->loggedIn;
		}

		# Checks if the user exists with the given username | email
		#
		# $username => the username to check with
		# $email    => the email to check with
		#
		# returns true if a user owns either the username or email
		public function userExists($username, $email) {
			$user_exists_check_sql = "SELECT id FROM `po-users` WHERE `username` = :username OR `email` = :email ORDER BY `id` LIMIT 1";
			$user_exists_check_query = $this->getConnection()->prepare($user_exists_check_sql);
			$user_exists_check_query->bindParam(":username", $username);
			$user_exists_check_query->bindParam(":email", $email);
			$user_exists_check_query->execute();
			return !$user_exists_check_query->rowCount() == 0;
		}

		# Registers a user with the given information
		#
		# $username  => username of user to register
		# $password  => password of user to register
		# $email     => email of the user to register
		# $name      => name of the user to register
		# $level     => the level of the account, 2 by default (DEFAULT_USER)
		#
		# returns true if the register was a success
		public function registerUser($username, $password, $email, $name, $level = 2) {
			# TODO: check if user exists

			# hash password with blowfish algorithm, default hash of 10
			$hashed_pass = password_hash($password, PASSWORD_BCRYPT);
			$register_user_sql = "INSERT INTO `po-users` (username, email, password, name, level) VALUES (:username, :email, :password, :name, :level)";
			$register_user_query = $this->getConnection()->prepare($register_user_sql);
			$register_user_query->bindParam(":username", $username);
			$register_user_query->bindParam(":email", $email);
			$register_user_query->bindParam(":password", $hashed_pass);
			$register_user_query->bindParam(":name", $name);
			$register_user_query->bindParam(":level", $level, PDO::PARAM_INT);
			return $register_user_query->execute();
		}

		# redirect to the setup page for
		# first time configuration
		public function setupPesto() {
			$this->redirect("po-setup.php");
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