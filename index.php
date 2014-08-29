<?php 

	include 'libs/Parsedown.php';
	include 'includes/header.php'; 

	$parser = new Parsedown();

?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">
				<div class="col-lg-8">
					<?php
						foreach ($blogSystem->getPosts() as $post) {
							# for getting the name, since we only have the subjects id
							$subject_handle = $blogSystem->getSubjectById($post['subject_id']);
							
							# store the id of the owner
							$user_id = $post['owner_id'];
							
							# information about the user with the given id
							$user_handle = $pesto->getUser($user_id);
							
							# the username taken from the user record
							$username = $user_handle['username'];

							# reformat the date to something more readable
							$formatted_date = date("d M Y", strtotime($post['date']));

							echo '
							<div class="post">
								<h1 class="post-title">'. $post['title']. '</h1>
								<h5 class="post-meta text-muted"><a href="#">' . $username . '</a> &middot; '. $formatted_date .' &middot; Subject: <a href="#">'. $subject_handle['subject'] .'</a></h5>
								<div class="post-content">'
									. $parser->text($post['content']) .
								'</div>
								<div class="small-space"></div>
								<a href="#" class="btn btn-primary btn-sm">Read More</a>
							</div>
							';
						}
					?>
				</div>

				<div class="col-lg-4">
					<h1>About</h1>
					<p>
						<?php
							echo $parser->text($blog_desc);
						?> 
					</p>
				</div>
			</div>
		</div>

	</body>

<?php include 'includes/footer.php'; ?>