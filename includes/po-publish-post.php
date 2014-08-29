<?php

	if (isset($_POST['publish'])) {
		$title 	 = $_POST['title'];
		$post  	 = $_POST['post'];
		$subject = $_POST['subject'];

		# get subject with name will return false if not found
		$used    = $blogSystem->getSubjectWithName($subject);

		# cheeky fucker didn't put in a title, post, or subject
		if ($title == "" || $post == "" || $subject == "") {
			$pesto->generateError("Title/Post/Subject is empty");
		}
		else {
			$newused = $used['used']; # fallback to default

			# check that it exists
			if ($used !== false) {
				$oldused = $used['used'];
				$newused = $oldused + 1;
			}
			# oh shit best create it
			else {
				$blogSystem->createNewSubject($subject);
			}

			$owner_handle = $pesto->getUser();
			$owner_id = $owner_handle['id'];
			$subject_id = $used['id'];

			$blogSystem->updateSubjectUsed($subject_id, $newused);
			$blogSystem->newBlogPost($title, $post, $owner_id, $subject_id);

			$pesto->generateSuccess("Your post has been published <a href='#'>here</a>");
		}
	}

?>