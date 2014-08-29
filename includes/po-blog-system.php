<?php

	# Utility class for blog posts, tag creation, editing, etc
	class BlogSystem {

		private $connection;

		# Create a new instance of the BlogSystem
		#
		# $connection => for PDO access to the database
		public function __construct($connection) {
			$this->connection = $connection;
		}

		# Returns an entire record if the id exists in the table
		#
		# $post_id => the id of the post
		public function getPostRecord($post_id) {
			$get_post_sql = "SELECT * FROM `po-blog-posts` WHERE `id` = :id LIMIT 1";
			$get_post_query = $this->connection->prepare($get_post_sql);
			$get_post_query->bindParam(":id", $post_id);
			return $get_post_query->fetch(PDO::FETCH_ASSOC);
		}

		# Create a new Subject, will not be created if it's already in the
		# Subjects table
		#
		# returns if the insertion was a success or not
		public function createNewSubject($subject) {
			$create_subject_sql = "INSERT IGNORE INTO `po-subjects` (`subject`, `used`) VALUES (:subject, :used)";
			$create_subject_query = $this->connection->prepare($create_subject_sql);
			$create_subject_query->bindParam(":subject", $subject);
			$one = 1;
			$create_subject_query->bindParam(":used", $one = 1, PDO::PARAM_INT);
			return $create_subject_query->execute();
		}

		# Increment used by 1
		public function updateSubjectUsed($subject_id, $newValue) {
			$update_subject_sql = "UPDATE `po-subjects` SET `used` = :used WHERE `id` = :id";
			$update_subject_query = $this->connection->prepare($update_subject_sql);
			$update_subject_query->bindParam(":used", $newValue);
			$update_subject_query->bindParam(":id", $subject_id);
			return $update_subject_query->execute();
		}

		# Returns the record with the given subject name
		#
		# $subjectName => the subjects name to check
		#
		# returns an array of the record data if the subject exists
		public function getSubjectWithName($subjectName) {
			$subject_with_sql = "SELECT * FROM `po-subjects` WHERE `subject` = :subject ORDER BY `id` LIMIT 1";
			$subject_with_query = $this->connection->prepare($subject_with_sql);
			$subject_with_query->bindParam(":subject", $subjectName);
			$subject_with_query->execute();

			if ($subject_with_query->rowCount() == 0) return false;

			return $subject_with_query->fetch(PDO::FETCH_ASSOC);
		}

		# Return all the subjects as an array
		public function getSubjects() {
			$get_subject_sql = "SELECT * FROM `po-subjects` ORDER BY `used` DESC LIMIT 20";
			$get_subject_query = $this->connection->query($get_subject_sql);
			return $get_subject_query->fetchAll(PDO::FETCH_ASSOC);
		}

		# Create a new Blog Post
		#
		# $title 	=> Title of the blog post
		# $content  => Blog post content, can be any format, preferred is markdown
		# $owner_id => The owners ID
		# $subject  => Subject of the Blog Post
		#
		# Returns true if the query was a success
		public function newBlogPost($title, $content, $owner_id, $subject) {
			$current_date = date("Y-m-d H:i:s", time());

			$new_blog_post_sql = "INSERT INTO `po-blog-posts` (`title`, `content`, `owner_id`, `date`, `subject_id`) VALUES (:title, :content, :owner_id, :c_date, :subject)";
			$new_blog_post_query = $this->connection->prepare($new_blog_post_sql);
			$new_blog_post_query->bindParam(":title", $title);
			$new_blog_post_query->bindParam(":content", $content);
			$new_blog_post_query->bindParam(":owner_id", $owner_id);
			$new_blog_post_query->bindParam(":c_date", $current_date);
			$new_blog_post_query->bindParam(":subject", $subject);
			
			return $new_blog_post_query->execute();
		}

	}

?>