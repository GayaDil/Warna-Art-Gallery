<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);


class Products{


	//Product
    public function product($product_id){

        include DB;

		$query = $db->query("SELECT * FROM `products` WHERE `id` = '$product_id' ");
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


				$img_path = '../assets/artworks/'.$id.'/';
				$img_path_front = 'assets/artworks/'.$id.'/';
				$image_backend = $img_path.$image;
				$image_frontend = $img_path_front.$image;

				if ( !file_exists($image_backend) ) {
					$image_backend = '../assets/artworks/dummy.jpg';
				}

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/artworks/dummy.jpg';
				}
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'user_id' => $user_id,
            'category_id' => $category_id,
            'medium_id' => $medium_id,
            'post_method' => $post_method,
            'bid_start_time' => $bid_start_time,
            'bid_end_time' => $bid_end_time,
            'title' => $title,
            'description' => $description,
            'price_label' => $price_label,
            'price' => $price,
            'quantity' => $quantity,
            'orientation' => $orientation,
            'dimension_id' => $dimension_id,
            'dimension_x' => $dimension_x,
            'dimension_y' => $dimension_y,
            'dimension_label_id' => $dimension_label_id,
            'artwork_date' => $artwork_date,
            'image_name' => $image,
            'image' => $image_backend,
            'image_front' => $image_frontend,
            'status' => $status,
            'admin_status' => $admin_status,
            'created' => $created,
        ); 

	}

	//Dimension Type
	public function dimension($dimension_id){

        include DB;

		$query = $db->query("SELECT * FROM `dimensions` WHERE `id` = '$dimension_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){				
				$id = $row['id'];
				$type = $row['type'];
				$status = $row['status'];
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'type' => $type,
            'status' => $status,
        ); 

	}

	//Dimension Label Type
    public function dimension_label($dimension_label_id){

        include DB;

		$query = $db->query("SELECT * FROM `dimension_custom_label` WHERE `id` = '$dimension_label_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){				
				$id = $row['id'];
				$type = $row['type'];
				$status = $row['status'];
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'type' => $type,
            'status' => $status,
        ); 

	}



	//Bid

	//Setup default bit addition amount
	public function bid_addition_amount(){
		return 100;
	}


	/*
	0 - pending
	1 - accepeted bid
	2 - rejected bid
	*/

	//Bid Product
    public function bid($product_id){

        include DB;

        $now = date('Y-m-d H:i:s', time());

        $data_arr = array();

		$query = $db->query("SELECT * FROM `bid` WHERE `product_id` = '$product_id' ORDER BY `amount` DESC");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$product_id = $row['product_id'];
				$user_id = $row['user_id'];
				$amount = $row['amount'];
				$status = $row['status'];
				$created = $row['created'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];

				$data = array(
		            'id' => $id,
		            'product_id' => $product_id,
		            'user_id' => $user_id,            
		            'amount' => $amount,
		            'status' => $status,
		            'created' => $created,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,
		        ); 

		        array_push($data_arr, $data);
			}
		}

		$db->close();

		//Check due time
		$bid_status = 0;

		$bid_start_time = date('Y-m-d H:i:s', strtotime($this->product($product_id)['bid_start_time']));
		$bid_end_time = date('Y-m-d H:i:s', strtotime($this->product($product_id)['bid_end_time']));		

		if ( $now > $bid_start_time && $bid_end_time > $now ) {
			$bid_status = 1;
		}


        return array(
            'data' => $data_arr,
            'bid_status' => $bid_status,
        ); 

	}

	//Getting current ongoing highest bid
	public function current_ongoing_bid($product_id){

		include DB;

        $now = date('Y-m-d H:i:s', time());

		$query = $db->query("SELECT * FROM `bid` WHERE `product_id` = '$product_id' AND `status` = 0 ORDER BY `created` DESC LIMIT 1");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$product_id = $row['product_id'];
				$user_id = $row['user_id'];
				$amount = $row['amount'];
				$status = $row['status'];
				$created = $row['created'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];
			}
		}else{
			$amount = $this->product($product_id)['price'];
		}

		$db->close();

        return array(
            'id' => $id,
            'product_id' => $product_id,
            'user_id' => $user_id,            
            'amount' => $amount,
            'status' => $status,
            'created' => $created,
            'status_user_id' => $status_user_id,
            'status_time' => $status_time,
        ); 

	}


	//Getting current ongoing highest bid
	public function user_last_highest_bid($user_id, $product_id){

		include DB;

		$query = $db->query("SELECT * FROM `bid` WHERE `product_id` = '$product_id' AND `user_id` = '$user_id' ORDER BY `created` DESC LIMIT 1");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$product_id = $row['product_id'];
				$user_id = $row['user_id'];
				$amount = $row['amount'];
				$status = $row['status'];
				$created = $row['created'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];
			}
		}else{
			$amount = 0;
		}

		$db->close();

        return array(
            'id' => $id,
            'product_id' => $product_id,
            'user_id' => $user_id,            
            'amount' => $amount,
            'status' => $status,
            'created' => $created,
            'status_user_id' => $status_user_id,
            'status_time' => $status_time,
        ); 

	}



}

?>