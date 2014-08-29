<?php include 'includes/header.php'; ?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">
				
				<?php
					function genPost($pesto) {
						$result = file_get_contents('http://loripsum.net/api/5/link/medium/decorate/ul/ol/dl/bq/code/prude');
						return $pesto->truncateHTML($result, 1000);
					}

					function genTitle($post) {
						$result = substr(file_get_contents('http://loripsum.net/api/plaintext'), 50, 250);
						$limit = 20;
						if(strlen($result) > $limit) {
							$endpos = strpos(str_replace(array("\r\n", "\r", "\n", "\t"), ' ', $result), ' ', $limit);
							if($endpos !== FALSE) {
								$result = trim(substr($result, 0, $endpos)) . "...";
							}
						}
						return $result;
					}
				?>

				<div class="col-lg-8">
					<?php
						foreach ($blogSystem->getPosts() as $post) {
							$subject_handle = $blogSystem->getSubjectById($post['subject_id']);
							echo '
							<div class="post">
								<h1 class="post-title"></h1>
								<h5 class="post-meta text-muted">Felix Angell &middot; August 20, 2014 &middot; Subject: <a href="#">'. $subject_handle['subject'] .'</a></h5>
								<div class="post-content">'
									. $post['content'] .
								'</div>
								<div class="small-space"></div>
								<a href="#" class="btn btn-primary">Read More</a>
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