<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);


class Homepage{


	//Products
    public function new_products(){

        include DB;

        $now = date('Y-m-d H:i:s', time());

        $prod_arr = array();

		$query = $db->query("SELECT * FROM `products` WHERE `status` = '1' AND `admin_status` = '1' AND IF( `post_method` = 2, `bid_end_time` >= '$now', `created` <= '$now' ) ORDER BY created DESC LIMIT 20");

		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$category_id = $row['category_id'];
				$post_method = $row['post_method'];
				$bid_start_time = $row['bid_start_time'];
				$bid_end_time = $row['bid_end_time'];
				$title = $row['title'];
				$description = $row['description'];
				$price = $row['price'];
				$quantity = $row['quantity'];
				$orientation = $row['orientation'];
				$dimension_id = $row['dimension_id'];
				$dimension_x = $row['dimension_x'];
				$dimension_y = $row['dimension_y'];
				$dimension_label_id = $row['dimension_label_id'];
				$image = $row['image'];
				$artwork_date = $row['artwork_date'];
				$status = $row['status'];
				$admin_status = $row['admin_status'];
				$created = $row['created'];

				$price_label = number_format($price,2);

				$img_path = 'assets/artworks/'.$id.'/';
				$image = $img_path.$image;

				if ( !file_exists($image) ) {
					$image = 'assets/artworks/dummy.jpg';
				}


				$prod = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'category_id' => $category_id,
		            'post_method' => $post_method,
		            'bid_start_time' => $bid_start_time,
		            'bid_end_time' => $bid_end_time,
		            'title' => $title,
		            'description' => $description,
		            'price' => $price,
		            'price_label' => $price_label,
		            'quantity' => $quantity,
		            'orientation' => $orientation,
		            'dimension_id' => $dimension_id,
		            'dimension_x' => $dimension_x,
		            'dimension_y' => $dimension_y,
		            'dimension_label_id' => $dimension_label_id,
		            'artwork_date' => $artwork_date,
		            'image' => $image,
		            'status' => $status,
		            'admin_status' => $admin_status,
		            'created' => $created,
		        ); 

				array_push($prod_arr, $prod);

			}
		}

		$db->close();

        return $prod_arr; 

	}


	//Gallery
    public function gallery($category, $medium, $method, $query){

        include DB;

        $prod_arr = array();

        $now = date('Y-m-d H:i:s', time());


        $sql = "SELECT * FROM `products` WHERE `status` = '1' AND `admin_status` = '1'";

        if ( $category != null ) {
        	$sql .= " AND `category_id` = '$category'";
        }

        if ( $method != null ) {
        	$sql .= " AND `post_method` = '$method'";
        }

        if ( $medium != null ) {
        	$sql .= " AND `medium_id` = '$medium'";
        }

        if ( $query != null ) {
        	$sql .= " AND (`title` LIKE '%$query%' OR `description` LIKE '%$query%')";
        }

        $sql .= " AND IF( `post_method` = 2, `bid_end_time` >= '$now', `created` <= '$now' )";

        $sql .= " ORDER BY created DESC";



        //Start - Pagination
        $pageno = 1;
        if (isset($_GET['page'])) {
		    $pageno = $_GET['page'];
		}

		$no_of_records_per_page = 20;
		$offset = ($pageno-1) * $no_of_records_per_page; 


		$total_pages_sql = $sql;
		$result = $db->query($total_pages_sql);
		$total_rows = $result->num_rows;
		$total_pages = ceil($total_rows / $no_of_records_per_page);

		$sql .= " LIMIT $offset, $no_of_records_per_page";
		//End - Pagination

		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$category_id = $row['category_id'];
				$post_method = $row['post_method'];
				$bid_start_time = $row['bid_start_time'];
				$bid_end_time = $row['bid_end_time'];
				$title = $row['title'];
				$description = $row['description'];
				$price = $row['price'];
				$quantity = $row['quantity'];
				$orientation = $row['orientation'];
				$dimension_id = $row['dimension_id'];
				$dimension_x = $row['dimension_x'];
				$dimension_y = $row['dimension_y'];
				$dimension_label_id = $row['dimension_label_id'];
				$image = $row['image'];
				$artwork_date = $row['artwork_date'];
				$status = $row['status'];
				$admin_status = $row['admin_status'];
				$created = $row['created'];

				$price_label = number_format($price,2);

				$img_path = 'assets/artworks/'.$id.'/';
				$image = $img_path.$image;

				if ( !file_exists($image) ) {
					$image = 'assets/artworks/dummy.jpg';
				}


				$prod = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'category_id' => $category_id,
		            'post_method' => $post_method,
		            'bid_start_time' => $bid_start_time,
		            'bid_end_time' => $bid_end_time,
		            'title' => $title,
		            'description' => $description,
		            'price' => $price,
		            'price_label' => $price_label,
		            'quantity' => $quantity,
		            'orientation' => $orientation,
		            'dimension_id' => $dimension_id,
		            'dimension_x' => $dimension_x,
		            'dimension_y' => $dimension_y,
		            'dimension_label_id' => $dimension_label_id,
		            'artwork_date' => $artwork_date,
		            'image' => $image,
		            'status' => $status,
		            'admin_status' => $admin_status,
		            'created' => $created,
		        ); 

				array_push($prod_arr, $prod);

			}
		}

		$db->close();

        return array(
        	'list' => $prod_arr,
            'total_pages' => $total_pages,
        ); 

	}


	//Auction Products
    public function auction($category, $medium, $query){

        include DB;

        $now = date('Y-m-d H:i:s', time());

        $prod_arr = array();


        $sql = "SELECT * FROM `products` WHERE `status` = '1' AND `admin_status` = '1' AND `post_method` = '2'";

        if ( $category != null ) {
        	$sql .= " AND `category_id` = '$category'";
        }

        if ( $medium != null ) {
        	$sql .= " AND `medium_id` = '$medium'";
        }

        if ( $query != null ) {
        	$sql .= " AND (`title` LIKE '%$query%' OR `description` LIKE '%$query%')";
        }

        $sql .= " AND IF( `post_method` = 2, `bid_end_time` >= '$now', `created` <= '$now' )";

        $sql .= " ORDER BY created DESC";



        //Start - Pagination
        $pageno = 1;
        if (isset($_GET['page'])) {
		    $pageno = $_GET['page'];
		}

		$no_of_records_per_page = 20;
		$offset = ($pageno-1) * $no_of_records_per_page; 


		$total_pages_sql = $sql;
		$result = $db->query($total_pages_sql);
		$total_rows = $result->num_rows;
		$total_pages = ceil($total_rows / $no_of_records_per_page);

		$sql .= " LIMIT $offset, $no_of_records_per_page";
		//End - Pagination



		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$category_id = $row['category_id'];
				$medium_id = $row['medium_id'];
				$post_method = $row['post_method'];
				$bid_start_time = $row['bid_start_time'];
				$bid_end_time = $row['bid_end_time'];
				$title = $row['title'];
				$description = $row['description'];
				$price = $row['price'];
				$quantity = $row['quantity'];
				$orientation = $row['orientation'];
				$dimension_id = $row['dimension_id'];
				$dimension_x = $row['dimension_x'];
				$dimension_y = $row['dimension_y'];
				$dimension_label_id = $row['dimension_label_id'];
				$image = $row['image'];
				$artwork_date = $row['artwork_date'];
				$status = $row['status'];
				$admin_status = $row['admin_status'];
				$created = $row['created'];

				$price_label = number_format($price,2);

				$img_path = 'assets/artworks/'.$id.'/';
				$image = $img_path.$image;

				if ( !file_exists($image) ) {
					$image = 'assets/artworks/dummy.jpg';
				}


				$prod = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'category_id' => $category_id,
		            'medium_id' => $medium_id,
		            'post_method' => $post_method,
		            'bid_start_time' => $bid_start_time,
		            'bid_end_time' => $bid_end_time,
		            'title' => $title,
		            'description' => $description,
		            'price' => $price,
		            'price_label' => $price_label,
		            'quantity' => $quantity,
		            'orientation' => $orientation,
		            'dimension_id' => $dimension_id,
		            'dimension_x' => $dimension_x,
		            'dimension_y' => $dimension_y,
		            'dimension_label_id' => $dimension_label_id,
		            'artwork_date' => $artwork_date,
		            'image' => $image,
		            'status' => $status,
		            'admin_status' => $admin_status,
		            'created' => $created,
		        ); 

				array_push($prod_arr, $prod);

			}
		}

		$db->close();

        return array(
        	'list' => $prod_arr,
            'total_pages' => $total_pages,
        ); 


	}


	//Artists
    public function artist($service, $query){

        include DB;
        $data_arr = array();

        $sql = "SELECT * FROM `users` WHERE `role_id` = 2 AND `status` = '1'";
       
        if ( $service != null ) {
        	$sql .= " AND `service_id` = '$service'";
        }

        if ( $query != null ) {
        	$sql .= " AND (`first_name` LIKE '%$query%' OR `last_name` LIKE '%$query%')";
        }

        $sql .= " ORDER BY first_name ASC";
		
		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$role_id = $row['role_id'];
				$username = $row['username'];
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$email = $row['email'];
				$phone = $row['phone'];
				$address_1 = $row['address_1'];
				$address_2 = $row['address_2'];
				$town = $row['town'];
				$state = $row['state'];
				$postcode = $row['postcode'];
				$country_id = $row['country_id'];
				$status = $row['status'];
				$created = $row['created'];
				$image = $row['image'];
				$full_name = $first_name . ' ' .$last_name;

				$img_path = 'assets/artists/'.$id.'/';

				$image_frontend = $img_path.$image;

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/artists/dummy.jpg';
				}

				$data = array(
		            'id' => $id,
		            'role_id' => $role_id,
		            'username' => $username,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'town' => $town,
		            'state' => $state,
		            'postcode' => $postcode,
		            'country_id' => $country_id,
		            'status' => $status,
		            'created' => $created,
		            'image' => $image_frontend,
		            'full_name' => $full_name,
		        );

		        array_push($data_arr, $data);
				
			}
		}

		$db->close();

        
		return $data_arr;
	}


	//Artists
    public function artist_services($service, $query){

        include DB;
        $data_arr = array();

        $sql = "SELECT
        s.user_id as user_id,
        s.id as s_id,
        s.service_id as service_id,
        u.first_name as first_name,
        u.last_name as last_name
        FROM artist_services AS s INNER JOIN users AS u ON s.user_id = u.id
        WHERE s.status = '1'";

        if ( $service != null ) {
       		$sql .= " AND s.service_id = '$service'";
        }

        if ( $query != null ) {
        	$sql .= " AND CONCAT(u.first_name,' ', u.last_name) LIKE '%$query%'";
        }

        $sql .= " GROUP BY s.user_id ORDER BY user_id ASC";

        //Start - Pagination
        $pageno = 1;
        if (isset($_GET['page'])) {
		    $pageno = $_GET['page'];
		}

		$no_of_records_per_page = 20;
		$offset = ($pageno-1) * $no_of_records_per_page; 


		$total_pages_sql = $sql;
		$result = $db->query($total_pages_sql);
		$total_rows = $result->num_rows;
		$total_pages = ceil($total_rows / $no_of_records_per_page);

		$sql .= " LIMIT $offset, $no_of_records_per_page";
		//End - Pagination
		
		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$s_id = $row['s_id'];
				$user_id = $row['user_id'];
				$service_id = $row['service_id'];
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$status = $row['status'];

				$ua = new Users();
				$a_full_name = $ua->user($user_id)['full_name'];
				$a_image = $ua->user($user_id)['image_front'];				

				$data = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'service_id' => $service_id,
		            'status' => $status,
		            'full_name' => $a_full_name,
		            'image' => $a_image,
		   
		            
		        );

		        array_push($data_arr, $data);
				
			}

		}


		$db->close();

        
		return array(
        	'list' => $data_arr,
            'total_pages' => $total_pages,
        );
	}


	//Artist products
    public function artist_products($user_id){

        include DB;

        $prod_arr = array();


        $sql = "SELECT * FROM `products` WHERE  `user_id` = '$user_id' AND `status` = '1' AND `admin_status` = '1' ";

        //Start - Pagination
        $pageno = 1;
        if (isset($_GET['page'])) {
		    $pageno = $_GET['page'];
		}

		$no_of_records_per_page = 20;
		$offset = ($pageno-1) * $no_of_records_per_page; 


		$total_pages_sql = $sql;
		$result = $db->query($total_pages_sql);
		$total_rows = $result->num_rows;
		$total_pages = ceil($total_rows / $no_of_records_per_page);

		$sql .= " LIMIT $offset, $no_of_records_per_page";
		//End - Pagination

		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$category_id = $row['category_id'];
				$post_method = $row['post_method'];
				$bid_start_time = $row['bid_start_time'];
				$bid_end_time = $row['bid_end_time'];
				$title = $row['title'];
				$description = $row['description'];
				$price = $row['price'];
				$quantity = $row['quantity'];
				$orientation = $row['orientation'];
				$dimension_id = $row['dimension_id'];
				$dimension_x = $row['dimension_x'];
				$dimension_y = $row['dimension_y'];
				$dimension_label_id = $row['dimension_label_id'];
				$image = $row['image'];
				$artwork_date = $row['artwork_date'];
				$status = $row['status'];
				$admin_status = $row['admin_status'];
				$created = $row['created'];

				$price_label = number_format($price,2);

				$img_path = 'assets/artworks/'.$id.'/';
				$image = $img_path.$image;

				if ( !file_exists($image) ) {
					$image = 'assets/artworks/dummy.jpg';
				}


				$prod = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'category_id' => $category_id,
		            'post_method' => $post_method,
		            'bid_start_time' => $bid_start_time,
		            'bid_end_time' => $bid_end_time,
		            'title' => $title,
		            'description' => $description,
		            'price' => $price,
		            'price_label' => $price_label,
		            'quantity' => $quantity,
		            'orientation' => $orientation,
		            'dimension_id' => $dimension_id,
		            'dimension_x' => $dimension_x,
		            'dimension_y' => $dimension_y,
		            'dimension_label_id' => $dimension_label_id,
		            'artwork_date' => $artwork_date,
		            'image' => $image,
		            'status' => $status,
		            'admin_status' => $admin_status,
		            'created' => $created,
		        ); 

				array_push($prod_arr, $prod);

			}
		}

		$db->close();

        return array(
        	'list' => $prod_arr,
            'total_pages' => $total_pages,
        ); 

	}


	//Blogs
    public function blogs( $query){

        include DB;

        $blg_arr = array();


        $sql = "SELECT * FROM `blog_posts` WHERE `status` = '1'";

        if ( $query != null ) {
        	$sql .= " AND (`title` LIKE '%$query%' OR `content` LIKE '%$query%')";
        }

        $sql .= " ORDER BY created_time DESC";


        //Start - Pagination
        $pageno = 1;
        if (isset($_GET['page'])) {
		    $pageno = $_GET['page'];
		}

		$no_of_records_per_page = 9;
		$offset = ($pageno-1) * $no_of_records_per_page; 


		$total_pages_sql = $sql;
		$result = $db->query($total_pages_sql);
		$total_rows = $result->num_rows;
		$total_pages = ceil($total_rows / $no_of_records_per_page);

		$sql .= " LIMIT $offset, $no_of_records_per_page";
		//End - Pagination


		$query = $db->query($sql);
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
				

				$image_frontend = $img_path.$image;
				

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/blogs/dummy.jpg';
				}

				$blg = array(
		            'id' => $id,
		            'title' => $title,
		            'content' => $content,
		            'image' => $image_frontend,
		            'created_time' => $created_time,
		            'updated_time' => $updated_time,
		            'user_id' => $user_id,
		            'status' => $status,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,
		        ); 

				array_push($blg_arr, $blg);

			}
		}

		$db->close();

        return array(
        	'list' => $blg_arr,
            'total_pages' => $total_pages,
        );  

	}

	//Blogs- Homepage
    public function new_blogs($limit = null){

        include DB;

        $blg_arr = array();


        $sql = "SELECT * FROM `blog_posts` WHERE `status` = '1' ORDER BY created_time DESC";

        if ( !is_null($limit) ) {
        	$sql .= " LIMIT $limit";
        }

		$query = $db->query($sql);
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

				$img_path = 'assets/blogs/'.$id.'/';
				

				$image_frontend = $img_path.$image;
				

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/blogs/dummy.jpg';
				}

				$blg = array(
		            'id' => $id,
		            'title' => $title,
		            'content' => $content,
		            'image' => $image_frontend,
		            'created_time' => $created_time,
		            'updated_time' => $updated_time,
		            'user_id' => $user_id,
		            'status' => $status,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,
		        ); 

				array_push($blg_arr, $blg);

			}
		}

		$db->close();

        return $blg_arr; 

	}


	

	

}

?>