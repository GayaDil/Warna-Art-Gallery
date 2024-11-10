<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);

if (!class_exists('Products')) {
	require 'Products.php';
}

class Cart{


	//All Cart Items
    public function all_cart(){

        include DB;
        $user_id = USER_ID;

        $prod_arr = array();
        $total = 0;

		$query = $db->query("SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];
				$created = $row['created'];
				$updated = $row['updated'];

				$pr = new Products();
				$price = $pr->product($product_id)['price'];
				$image = $pr->product($product_id)['image_front'];
				$title = $pr->product($product_id)['title'];				

				$prod_total = $price * $quantity;

				$total = $total + $prod_total;

				$price_label = number_format($price,2);
				$prod_total_label = number_format($prod_total,2);


				$prod = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'product_id' => $product_id,
		            'quantity' => $quantity,
		            'title' => $title,
		            'price' => $price,
		            'price_label' => $price_label,
		            'total' => $prod_total,
		            'total_label' => $prod_total_label,
		            'image' => $image,
		            'created' => $created,
		            'updated' => $updated,
		        ); 

				array_push($prod_arr, $prod);

			}
		}

		$total_label = number_format($total,2);

		$db->close();

		$general = array(
            'total' => $total,
            'total_label' => $total_label,
        );

		$all = array(
            'items' => $prod_arr,
            'general' => $general,
        );

        return $all; 

	}


	//All Cart Items
    public function cart_item($id){

        include DB;
		$query = $db->query("SELECT * FROM `cart` WHERE `id` = '$id'");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$product_id = $row['product_id'];
				$quantity = $row['quantity'];
				$created = $row['created'];
				$updated = $row['updated'];

				$pr = new Products();
				$price = $pr->product($product_id)['price'];
				$image = $pr->product($product_id)['image_front'];
				$title = $pr->product($product_id)['title'];				
				$product_quantity = $pr->product($product_id)['quantity'];

			}
		}

		$db->close();


        return array(
            'id' => $id,
            'user_id' => $user_id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'title' => $title,
            'price' => $price,
            'product_quantity' => $product_quantity,
            'image' => $image,
            'created' => $created,
            'updated' => $updated,
        ); 

	}


	//Cart count
	public function cart_count(){

		include DB;

		$count = 0;

		$user_id = USER_ID;

		if (isset($user_id)) {
			$query = $db->query("SELECT SUM(quantity) as count FROM `cart` WHERE `user_id` = '$user_id'");
			$rowCount = $query->num_rows;
			if($rowCount > 0){
				while($row = $query->fetch_assoc()){				
					$count = $row['count'];
				}
			}
		}

			

		return $count;


	}

	//Cart Total
	public function cart_total(){

		include DB;

		$count = '';

		$user_id = USER_ID;

		$total = 0;

		if (isset($user_id)) {
			$query = $db->query("SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
			$rowCount = $query->num_rows;
			if($rowCount > 0){
				while($row = $query->fetch_assoc()){				
					$product_id = $row['product_id'];
					$qty = $row['quantity'];

					$pr = new Products();
					$price = $pr->product($product_id)['price'];

					$tot = $price * $qty;

					$total = $total + $tot;
				}
			}
		}

			
		$total_label = number_format($total,2);
		
		return array(
            'total' => $total,
            'total_label' => $total_label,
        );


	}

	//Add to Cart
	public function add_to_cart($product_id,$quantity){

		include DB;
		$user_id = USER_ID;


		$query = $db->query("SELECT * FROM `cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'");
		$rowCount = $query->num_rows;
		$row = $query->fetch_assoc();
		if($rowCount > 0){		
			$tmp_id = $row['id'];	
			$tmp_qty = $row['quantity'];

			$quantity = $quantity + $tmp_qty;

			$db->query("UPDATE `cart` SET `quantity`= '$quantity', `updated` = '$now' WHERE `id`= '$tmp_id'");
		}else{

			$ai = new Products();
			$artist_id = $ai->product($product_id)['user_id'];			

			$db->query("INSERT INTO `cart`( `user_id`, `artist_id`, `product_id`, `quantity`, `created`) VALUES ('$user_id', '$artist_id', '$product_id', '$quantity', '$now')");
		}

	}

	//Update Cart
	public function update_cart($cart_id,$quantity){

		include DB;
		$user_id = USER_ID;


		$query = $db->query("SELECT * FROM `cart` WHERE `id` = '$cart_id'");
		$rowCount = $query->num_rows;
		$row = $query->fetch_assoc();
		if($rowCount > 0){		
			$tmp_id = $row['id'];	
			$product_id = $row['product_id'];

			$pr = new Products();
			$price = $pr->product($product_id)['price'];

			$total = $price * $quantity;

			$db->query("UPDATE `cart` SET `quantity`= '$quantity', `updated` = '$now' WHERE `id`= '$tmp_id'");
		}


		$total_label = number_format($total,2);
		return array(
            'total' => $total,
            'total_label' => $total_label,
        );


	}

	//Clear Cart
	public function clear_cart(){

		include DB;
		$user_id = USER_ID;

		if (isset($user_id)) {
			$query = $db->query("SELECT * FROM `cart` WHERE `user_id` = '$user_id'");
			$rowCount = $query->num_rows;
			if($rowCount > 0){
				while($row = $query->fetch_assoc()){				
					$id = $row['id'];
					$db->query("DELETE FROM `cart` WHERE `id` = '$id'");
				}
			}
		}

	}


}

?>