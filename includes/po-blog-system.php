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