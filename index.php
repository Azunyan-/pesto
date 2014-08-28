<?php include 'includes/header.php'; ?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">
				
				<?php
					function genPost($pesto) {
						$result = "";
						$x = rand(20, 150);
						for ($i = 0; $i < $x; $i++) {
							$result .= $pesto->generateSecureKey() . " ";
						}
						return $result;
					}
				?>

				<div class="col-lg-8">
					<?php
						for ($i = 0; $i < 10; $i++) {
							echo '
							<div class="post">
								<h1 class="post-title">' . $pesto->generateSecureKey() . '</h1>
								<h4 class="post-date">August 20, 2014 &mdash; ' . $pesto->generateSecureKey() . '</h4>
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
						<?php echo stripslashes($blog_desc); ?>
					</p>
				</div>
			</div>
		</div>

	</body>

<?php include 'includes/footer.php'; ?>