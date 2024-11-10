<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);

if (!class_exists('Products')) {
	require 'Products.php';
}



class ArtistPayments{


	//Artist -Payments
    public function all_payments($artist_id = null){

        include DB;

        $data_arr = array();

        $sql = "SELECT * FROM `artist_payments`";

        if ( isset($order_id) ) {
        		$sql .= "  WHERE `artist_id` = '$artist_id'";     	
        }

        $sql .= " GROUP BY order_id ORDER BY `id` DESC"; 


		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
		
				$id = $row['id'];
				$order_id = $row['order_id'];
				$artist_id = $row['artist_id'];
				$amount = $row['amount'];
				$note = $row['note'];
				$status = $row['status'];
				$status_user_id = $row['status_user_id'];
				$created = $row['created'];	

				$total_paid = $this->paid_amounts($order_id);	

				
				$data = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'artist_id' => $artist_id,
		            'amount' => $amount,
		            'total_paid' => $total_paid,
		            'note' => $note,
		            'status' => $status,
		            'status_user_id' => $status_user_id,
		            'created' => $created,
		        ); 

				array_push($data_arr, $data);

			}
		}


		$db->close();


        return $data_arr;
 

	}

	//Artist -Payments
    public function payments($artist_id, $order_id = null){

        include DB;

        $data_arr = array();

        $sql = "SELECT * FROM `artist_payments` WHERE `artist_id` = '$artist_id'";

        if ( isset($order_id) ) {
        		$sql .= " AND `order_id` = '$order_id'";     	
        }

        $sql .= " ORDER BY `id` DESC"; 


		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
		
				$id = $row['id'];
				$order_id = $row['order_id'];
				$artist_id = $row['artist_id'];
				$amount = $row['amount'];
				$note = $row['note'];
				$status = $row['status'];
				$status_user_id = $row['status_user_id'];
				$created = $row['created'];		

				
				$data = array(
		            'id' => $id,
		            'order_id' => $order_id,
		            'artist_id' => $artist_id,
		            'amount' => $amount,
		            'note' => $note,
		            'status' => $status,
		            'status_user_id' => $status_user_id,
		            'created' => $created,
		        ); 

				array_push($data_arr, $data);

			}
		}


		$db->close();


        return $data_arr;
 

	}



	public function paid_amounts($order_id){

		include DB;

        $total = 0;

		$query = $db->query("SELECT SUM(amount) AS total FROM `artist_payments` WHERE `order_id` = '$order_id' AND `status` = '1'");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){		
				$total = $row['total'];
			}
		}

		$db->close();

        return $total;

	}





	//Commission 
    public function commission(){

        include DB;

		$query = $db->query("SELECT * FROM `commission` LIMIT 1");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){				
				$id = $row['id'];
				$percentage = $row['percentage'];
			}
		}

		$db->close();

        return $percentage;

	}





}

?>