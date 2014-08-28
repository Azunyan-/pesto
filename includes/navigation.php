<?php

	class Item {

		# name of the item
		private $name;

		# if you must be logged in to view
		private $login;

		# link of nav item
		private $link;

		public function __construct($name, $login, $link) {
			$this->name = $name;
			$this->login = $login;
			$this->link = $link;
		}

		public function getName() {
			return $this->name;
		}

		public function getLogin() {
			return $this->login;
		}

		public function getLink() {
			return $this->link;
		}

	}

?>

<div class="header">
	<ul class="nav nav-pills pull-right">

		<?php 
			# navigation items
			# link to page => name on navigation page
			$navItem = array(
				new Item("Home", false, "index.php"),
				new Item("New Post", false, "new-post.php"),
				new Item("Login", false, "po-login.php"),
				new Item("Test", true, "http://www.google.com")
			);

			foreach ($navItem as $item) {
				$name = $item->getName();
				$view = $item->getLogin();
				$link = $item->getLink();

				# get if page is active
				$active = $pesto->isCurrentPage($link) ? 'class="active"' : '';

				# print the link and name into the nav bar
				if ($view && $pesto->isLoggedIn()) { # print logged in ones
					echo "<li {$active}><a href='{$link}'>{$name}</a></li>";
				}
				else if ($view === false) { # they aren't logged in print non logged in ones
					echo "<li {$active}><a href='{$link}'>{$name}</a></li>";
				}
			}
		?>
	</ul>
	<h3 class="brand">Blog Name<br /> <span class="small">Probably the best blog ever made</span></h3>
</div>