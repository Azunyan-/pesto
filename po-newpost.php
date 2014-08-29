<?php 

	include 'includes/header.php'; 

	if (!$pesto->isLoggedIn()) {
		$pesto->redirect("index.php");
	}
?>

	<body>

		<div class="container">
			<!-- Navigation Bar -->
			<?php include 'includes/navigation.php'; ?>

			<div class="row">

				<!-- Largish section on left -->
				<div class="col-lg-8">
					<div class="post">
						<?php include 'includes/po-publish-post.php' ?>
						<h1>New Blog Post</h1>
						<form class="form" action="po-newpost.php" method="POST">
							<div class="form-group">
								<label for="title">Title</label>
								<input type="text" name="title" placeholder="Why cats should be banned from India" class="form-control" />
							</div>

							<div class="small-space"></div>

							<div class="form-group">
								<label for="post">Post</label>
								<textarea rows="15" type="text" placeholder="They're too fluffy" name="post" class="form-control"></textarea>
							</div>

							<div class="small-space"></div>

							<div class="form-group">
								<label for="subject">Subject</label>
								<input type="text" name="subject" placeholder="Animals" class="subject form-control" />
							</div>

							<div class="small-space"></div>

							<button type="submit" name="publish" class="btn btn-primary form-control">Publish</button>
						</form>
					</div>
				</div>

				<script>
				function change(value) {
					$('.subject').val(value);
				}
				</script>


				<!-- Additional Content on sidebar -->
				<div class="col-lg-4">
					<div class="post">
						<h1>Subjects</h1>
						<p>
							Subjects you use a lot:
						</p>

						<ul>
							<?php
							foreach ($blogSystem->getSubjects() as $row) {
								echo "<li><a href='javascript:;' onclick=\"change('{$row['subject']}')\">&quot;{$row['subject']}&quot; &mdash; used {$row['used']} times</a></li>";
							}
							?>
						</ul>
					</div>
				</div>
			</div>
		</div>

	</body>

<?php include 'includes/footer.php'; ?>