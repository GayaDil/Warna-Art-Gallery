<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);

if (!class_exists('Products')) {
	require 'Products.php';
}



class Orders{


	// Ordered customer
    public function order($order_id){

        include DB;

        /* Perform query & get the result set  */
        /* $db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);*/
        /* $query == result set*/
		$query = $db->query("SELECT * FROM `orders` WHERE `id` = '$order_id'");

		/*Return the number of rows in a result set*/
		$rowCount = $query->num_rows;
		
		if($rowCount > 0){

			/*fetches a result row as an associative array*/
			while($row = $query->fetch_assoc()){ 
			
				$id = $row['id'];
				/*$bid_id = $row['bid_id'];*/
				$user_id = $row['user_id'];
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$b_phone = $row['b_phone'];
				$email = $row['b_email'];
				$town = $row['town'];
				$state = $row['state'];
				$postcode = $row['postcode'];
				$country_id = $row['country_id'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$note = $row['note'];
				$status = $row['status'];
				$created = $row['created'];
				$payment_method = $row['payment_method'];
				$payment_method = "Bank Transfer ";

				$full_name = $first_name . ' ' .$last_name;

			}
		}

		/* Close a previously opened database connection */
		$db->close();

		/* array() is used to Creates an array. $response is the name of the created array*/
		$response = array(
            'id' => $id,
            'user_id' => $user_id,
            'artist_id' => $artist_id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'full_name' => $full_name,
            'email' => $email,
            'phone' => $b_phone,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'town' => $town,
            'state' => $state,
            'postcode' => $postcode,
            'country_id' => $country_id,
            'note' => $note,
            'status' => $status,
            'created' => $created,
            'payment_method' => $payment_method,
        );

        return $response; 

	}


	/*
	Type ID
	1	-	Artist
	2	-	User
	*/

	//All Orders
    public function all_orders($user_id = null, $type_id = null){

        include DB;

        /*Creates an array*/
        $order_arr = array();


        $sql = "SELECT * FROM `orders` ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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

        /* Perform query & get the result set  */
		$query = $db->query($sql);

		/*Return the number of rows in a result set*/
		$rowCount = $query->num_rows;

		if($rowCount > 0){

			/*fetches a result row as an associative array*/
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$user_id = $row['user_id'];
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;

				//$os = new Orders();
				//$status_t = $os->order_status($status)['type'];
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				/* inserts one or more elements to the end of an array.*/
				/* inserts $ord after $order_arr*/
				array_push($order_arr, $ord);

			}
		}

		/*closes db connection*/
		$db->close();
 
        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
            'offset' => $offset,
            'pageno' => $pageno,

        );

	}


	//All Orderd Products
    public function order_products($order_id){

        include DB;

        /* creates an array*/
        $prod_arr = array();
        $total = 0;
        $rejected_total = 0;

        /* performe query and take result set */
		$query = $db->query("SELECT * FROM `order_products` WHERE `order_id` = '$order_id'");
		/* number of rows in result set*/
		$rowCount = $query->num_rows;
		if($rowCount > 0){

			/*fetches a result row as an associative array*/
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$order_id = $row['order_id'];
				$product_id = $row['product_id'];
				$unit_price = $row['unit_price'];
				$quantity = $row['quantity'];
				$status = $row['status'];
				$note = $row['note'];
				$created = $row['created'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];

				$pr = new Products();
				$image = $pr->product($product_id)['image_name'];
				$title = $pr->product($product_id)['title'];				

				$prod_total = $unit_price * $quantity;

				//if rejected
				if ( $status == 0 ) {
					$rejected_total = $rejected_total + $prod_total;
				}

				$total = $total + $prod_total;

				$price_label = number_format($unit_price,2);
				$prod_total_label = number_format($prod_total,2);

				$img_path = 'assets/artworks/'.$product_id.'/';
				$img_backend_path = '../assets/artworks/'.$product_id.'/';

				$image_frontend = $img_path.$image;
				$image_backend = $img_backend_path.$image;

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/artworks/dummy.jpg';
				}			

				if ( !file_exists($image_backend) ) {
					$image_backend = '../assets/artworks/dummy.jpg';
				}

				$prod = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'product_id' => $product_id,
		            'quantity' => $quantity,
		            'title' => $title,
		            'price' => $unit_price,
		            'price_label' => $price_label,
		            'total' => $prod_total,
		            'total_label' => $prod_total_label,
		            'image_name' => $image,
		            'image' => $image_frontend,
		            'image_backend' => $image_backend,
		            'status' => $status,
		            'note' => $note,
		            'created' => $created,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,

		        ); 

				/* inserts $prod array to the end of $prod_arr array.*/
				array_push($prod_arr, $prod); 
			}
		}

		$sub_total = $total;
		$total = $total - $rejected_total;

		$sub_total_label = number_format($sub_total,2);
		$rejected_total_label = number_format(-$rejected_total,2);
		$total_label = number_format($total,2);
		/* close db connection*/
		$db->close();

		$general = array(
			'sub_total' => $sub_total,
            'sub_total_label' => $sub_total_label,
            'total' => $total,
            'total_label' => $total_label,
            'rejected_total' => $rejected_total,
            'rejected_total_label' => $rejected_total_label,
        );

		$all = array(
            'items' => $prod_arr,
            'general' => $general,
        );

        return $all; 
	}



	//Order Product
    public function order_product($order_product_id){

        include DB;

        /* performe query and take result set */
		$query = $db->query("SELECT * FROM `order_products` WHERE `id` = '$order_product_id'");

		/* number of rows in result set*/
		$rowCount = $query->num_rows;
		if($rowCount > 0){

			/*fetches a result row as an associative array*/
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$order_id = $row['order_id'];
				$product_id = $row['product_id'];
				$unit_price = $row['unit_price'];
				$quantity = $row['quantity'];
				$status = $row['status'];
				$note = $row['note'];
				$created = $row['created'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];		

				$pr = new Products();
				$image = $pr->product($product_id)['image_name'];
				$title = $pr->product($product_id)['title'];
				
				$prod_total = $unit_price * $quantity;

				$price_label = number_format($unit_price,2);
				$prod_total_label = number_format($prod_total,2);

				$img_path = 'assets/artworks/'.$product_id.'/';
				$img_backend_path = '../assets/artworks/'.$product_id.'/';

				$image_frontend = $img_path.$image;
				$image_backend = $img_backend_path.$image;

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/artworks/dummy.jpg';
				}			

				if ( !file_exists($image_backend) ) {
					$image_backend = '../assets/artworks/dummy.jpg';
				}

				/*$this - same class method*/
				$order_status = $this->order($order_id)['status'];

				if ( $order_status == 1 ) {
					$status_text = "Awaiting approval";
                  	$status_label = "warning";
				}else{
					if ( $status == 1 ) {
		                  $status_text = "Approved";
		                  $status_label = "success";
	                }
	                else{
	                  	$status_text = "Rejected";
	                  	$status_label = "danger";
	                }
				}				

				$prod = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'product_id' => $product_id,
		            'quantity' => $quantity,
		            'title' => $title,
		            'price' => $unit_price,
		            'price_label' => $price_label,
		            'total' => $prod_total,
		            'total_label' => $prod_total_label,
		            'image' => $image_frontend,
		            'image_backend' => $image_backend,
		            'status_id' => $status,
		            'status' => $status_text,
		            'status_label' => $status_label,
		            'note' => $note,
		            'created' => $created,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,
		        
		        ); 
		
			}
		}

		/* close db connection*/
		$db->close();

        return $prod; 
	}


	//Order Status Type
    public function order_status($status_id){

        include DB;

        /* perform query and take result set*/
	    $query = $db->query("SELECT * FROM `order_status` WHERE `id` = '$status_id' ");
	    
	    /* return number of rowcount in the result set*/
	    $rowCount = $query->num_rows;
	    if($rowCount > 0){

	    	/*fetches a result row as an associative array*/
	      	while($row = $query->fetch_assoc()){        
	        $id = $row['id'];
	        $type = $row['type'];
	        $label = $row['label'];
	      }
	    }

	    /* close db connection*/
    	$db->close();

    	/* return multiple values from a function */
        return array(
            'id' => $id,
            'type' => $type,
            'label' => $label,
        ); 

  	}



  	/*
	Type ID
	1	-	Artist
	2	-	User
	*/

	//All Order Pending -Artist- approvals
    public function pending_approval($user_id = null, $type_id = null){

        include DB;

        $status_id = 1;

        /* creats an array*/
        $order_arr = array();

        /* query assign to a varible*/
        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();


        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );

	}


	//All Order Pending -Artist- approvals count
    public function pending_approval_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 1;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}




	//All Order Pending -Payments- Customer
    public function pending_payment($user_id = null, $type_id = null){

        include DB;

        $status_id = 2;

        /* creats an array*/
        $order_arr = array();

        /* query assign to a varible*/
        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();


        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );

	}


	//All Order Pending -Payments- count
    public function pending_payment_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 2;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}




	//All Order Pending -Payment- approvals
    public function pending_payment_approval($user_id = null, $type_id = null){

        include DB;

        $status_id = 3;

        $order_arr = array();

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }



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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();

 
        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );


	}

	//All Order Pending -Payment- approvals count
    public function pending_payment_approval_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 3;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}


	//All order payments
	public function order_payments($order_id){

		include DB;

        $payment_arr = array();

        $query = $db->query("SELECT * FROM `payments` WHERE `order_id` = '$order_id' ORDER BY `id` DESC");

        $rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				$id = $row['id'];
				$order_id = $row['order_id'];
				$user_id = $row['user_id'];
				$amount = $row['amount'];
				$payment_date = $row['payment_date'];
				$description = $row['description'];
				$created = $row['created'];
				$image = $row['image'];
				$status = $row['status'];
				$status_user_id = $row['status_user_id'];
				$status_time = $row['status_time'];

				$img_backend_path = '../assets/artworks/images/payment_submissions/';
				$image_backend = $img_backend_path.$image;

				$payment = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'user_id' => $user_id,
		            'amount' => $amount,
		            'payment_date' => $payment_date,
		            'description' => $description,
		            'created' => $created,
		            'image' => $image,
		            'image_backend' => $image_backend,
		            'status' => $status,
		            'note' => $note,
		            'status_user_id' => $status_user_id,
		            'status_time' => $status_time,

		        ); 

		        array_push($payment_arr, $payment);

		    }
		}

		$db->close();
		return $payment_arr; 	
	}


	public function order_paid_total($order_id){

		include DB;

        $total = 0;

        $query = $db->query("SELECT SUM(amount) AS total FROM `payments` WHERE `order_id` = '$order_id' AND `status` = 1");
        $rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				$total = $row['total'];
		    }
		}

		$db->close();
		return $total; 	
	}



	//All Order Pending Artist -Shipments-
    public function pending_shipments($user_id = null, $type_id = null){

        include DB;

        $status_id = 4;

        $order_arr = array();

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();


        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );
 

	}


	//All Order Pending payment -Shipments count-
    public function pending_shipments_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 4;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}




	//All Order Pending -collect- 
    public function pending_collect($user_id = null, $type_id = null){

        include DB;

        $status_id = 5;

        $order_arr = array();

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();


        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );
 

	}


	//All Order Pending -collect- count-
    public function pending_collect_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 5;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}






	//All Artist pending payments-
    public function artist_pending_payments($user_id = null, $type_id = null){

        include DB;

        $status_id = 6;

        $order_arr = array();

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }

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
				$artist_id = $row['artist_id'];
				$first_name = $row['b_first_name'];
				$last_name = $row['b_last_name'];
				$email = $row['b_email'];
				$phone = $row['b_phone'];
				$address_1 = $row['b_address_1'];
				$address_2 = $row['b_address_2'];
				$status = $row['status'];
				$created = $row['created'];


				$full_name = $first_name . ' ' .$last_name;
				
				$ord = array(
		            'id' => $id,
		            'user_id' => $user_id,
		            'artist_id' => $artist_id,
		            'first_name' => $first_name,
		            'last_name' => $last_name,
		            'full_name' => $full_name,
		            'email' => $email,
		            'phone' => $phone,
		            'address_1' => $address_1,
		            'address_2' => $address_2,
		            'status' => $status,
		            'created' => $created,
		            'status_t' => $status_t,
		        ); 

				array_push($order_arr, $ord);

			}
		}


		$db->close();


        return array(
        	'list' => $order_arr,
            'total_pages' => $total_pages,
        );
 

	}


	//All Artist pending payments- count-
    public function artist_pending_payments_count($user_id = null, $type_id = null){

        include DB;

        $status_id = 6;

        $sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' ORDER BY `id` DESC";

        if ( isset($user_id) ) {

        	if ( $type_id == 1 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND `artist_id` = '$user_id' ORDER BY `id` DESC";
        	}elseif ( $type_id == 2 ) {
        		$sql = "SELECT * FROM `orders` WHERE `status` = '$status_id' AND  `user_id` = '$user_id' ORDER BY `id` DESC";
        	}
        	
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}



	//Order Inquiries
    public function order_inquiries($order_id = null){

        include DB;

         /* creats an array*/
        $data_arr = array();

        $last_subject_available = false;


        if ( !isset($order_id) ) {

        	$last_subject_available = true;

        	$sql = "SELECT * FROM `order_inquiry` GROUP BY `order_id` ORDER BY `created` DESC";

	        //Start - Pagination
	        $pageno = 1;
	        if (isset($_GET['page'])) {
			    $pageno = $_GET['page'];
			}

			$no_of_records_per_page = 2;
			$offset = ($pageno-1) * $no_of_records_per_page; 


			$total_pages_sql = $sql;
			$result = $db->query($total_pages_sql);
			$total_rows = $result->num_rows;
			$total_pages = ceil($total_rows / $no_of_records_per_page);

			$sql .= " LIMIT $offset, $no_of_records_per_page";
			//End - Pagination
        }			





		if (isset($order_id)) {
        	$sql = "SELECT * FROM `order_inquiry` WHERE `order_id` = '$order_id'";

        	$total_pages = 0;
            $offset = 0;
            $pageno = 0;
        }


		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$type_id = $row['type_id'];
				$order_id = $row['order_id'];
				$user_id = $row['user_id'];
				$subject = $row['subject'];
				$note = $row['note'];
				$status = $row['status'];
				$created = $row['created'];

				$last_subject = '';
				if ( isset($last_subject_available) ) {
					$last_subject = $this->order_inquiry_subject($order_id);
				}
				
				$data = array(
		            'id' => $id,
		            'type_id' => $type_id,
		            'order_id' => $order_id,
		            'user_id' => $user_id,
		            'subject' => $subject,
		            'last_subject' => $last_subject,
		            'note' => $note,
		            'status' => $status,
		            'created' => $created,
		        ); 

				array_push($data_arr, $data);

			}
		}


		$db->close();


        return array(
        	'list' => $data_arr,
        	'count' => $rowCount,
        	'total_pages' => $total_pages,
            'offset' => $offset,
            'pageno' => $pageno,
        );

	}
	


	//Order Inquiries
    public function order_inquiries_unread_count(){

        include DB;
		$query = $db->query("SELECT * FROM `order_inquiry` WHERE `status` = '0'");
		$rowCount = $query->num_rows;
		$db->close();
        return $rowCount;

	}


	private function order_inquiry_subject($order_id){

		include DB;
		$query = $db->query("SELECT * FROM `order_inquiry` WHERE `order_id` = '$order_id' AND `type_id` = 2 ORDER BY `id` DESC LIMIT 1");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				$subject = $row['subject'];
			}
		}

		$db->close();
        return $subject;

	}


	public function order_inquiry_mark_as_read($order_id){

		include DB;
		$query = $db->query("SELECT * FROM `order_inquiry` WHERE `order_id` = '$order_id' AND `status` = 0");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				$id = $row['id'];
				$db->query("UPDATE `order_inquiry` SET `status`= 1 WHERE `id` = '$id'");
			}
		}

		$db->close();
		
        return true;

	}




	//Order Progress
    public function order_progress($order_id = null){

        include DB;

         /* creats an array*/
        $data_arr = array();

		$query = $db->query("SELECT * FROM `order_progress` WHERE `order_id` = '$order_id'");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
			
				$id = $row['id'];
				$order_id = $row['order_id'];
				$user_id = $row['user_id'];
				$status = $row['status'];
				$created = $row['created_time'];
				$note = $row['note'];

				$status_type = $this->order_status($status)['type'];
				$status_label = $this->order_status($status)['label'];

				$ou = new Users();
				$user_full_name = $ou->user($user_id)['full_name'];
				
				$data = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'user_id' => $user_id,
		            'user' => $user_full_name,
		            'status' => $status,
		            'created' => $created,
		            'note' => $note,
		            'status_type' => $status_type,
		            'status_label' => $status_label,
		        ); 

				array_push($data_arr, $data);

			}
		}


		$db->close();


        return $data_arr;

	}

}

?>