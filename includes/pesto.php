<?php

	class Pesto {

		# if pesto is configured
		private $configured;

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