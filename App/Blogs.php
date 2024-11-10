<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);


class Blogs{


	//Blog
    public function blog($blog_id){

        include DB;

		$query = $db->query("SELECT * FROM `blog_posts` WHERE `id` = '$blog_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$title = $row['title'];
				$content = $row['content'];
				$image = $row['image'];
				$created_time = $row['created_time'];
				$updated_time = $row['updated_time'];
				$user_id = $row['user_id'];
				$status = $row['status'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];

				$img_path = 'assets/blogs/';
				$img_backend_path = '../assets/blogs/';

				$image_frontend = $img_path.$image;
				$image_backend = $img_backend_path.$image;

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/blogs/dummy.jpg';
				}			
				

				if ( !file_exists($image_backend) ) {
					$image_backend = '../assets/blogs/dummy.jpg';
				}

				
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'title' => $title,
            'content' => $content,
            'image' => $image,
            'image_frontend' => $image_frontend,
            'image_backend' => $image_backend,
            'created_time' => $created_time,
            'updated_time' => $updated_time,
            'user_id' => $user_id,
            'status' => $status,
            'status_user_id' => $status_user_id,
            'status_time' => $status_time,

        );

	}



}

?>