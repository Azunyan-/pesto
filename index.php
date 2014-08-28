<?php include 'includes/header.php'; ?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">
				
				<?php
					function genPost($pesto) {
						$result = file_get_contents('http://loripsum.net/api/5/medium/decorate/link/ul/ol/dl/bq/code/prude');
						$len = strlen($result);
						$max_len = 1000;
						if ($len > $max_len) {
							$result = substr($result, 0, $max_len);
							$result .= "...";
						}
						return $result;
					}

					function genTitle($post) {
						$title = file_get_contents('http://loripsum.net/api/plaintext');
						$len = strlen($title);
						$max_len = 30;
						if ($len > $max_len) {
							$title = substr($title, $len / 2, $max_len + $len / $len);
						}
						return $title;
					}
				?>

				<div class="col-lg-8">
					<?php
						for ($i = 0; $i < 10; $i++) {
							echo '
							<div class="post">
								<h1 class="post-title">' . genTitle($pesto) . '</h1>
								<h5 class="post-meta text-muted">Felix Angell &middot; August 20, 2014 &middot; Subject: <a href="#">Secure Keys</a></h5>
								<p class="post-content">'
									. genPost($pesto) . 
								'</p>
							</div>
							';
						}
					?>
				</div>

				<div class="col-lg-4">
					<h1>About</h1>
					<p>
						<?php echo genPost($pesto); ?>
					</p>
				</div>
			</div>
		</div>

	</body>

<?php include 'includes/footer.php'; ?>