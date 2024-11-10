<?php
error_reporting(0);
session_start();
define('DB', 'connection.php');
define('USER_ID', $_SESSION['user']['id']);
define('USER_ROLE', $_SESSION['user']['role']);


class Users{


	//Users
    public function user($user_id){

        include DB;

		$query = $db->query("SELECT * FROM `users` WHERE `id` = '$user_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$role_id = $row['role_id'];
				$username = $row['username'];
				$password = $row['password'];
				$first_name = $row['first_name'];
				$last_name = $row['last_name'];
				$email = $row['email'];
				$new_email = $row['new_email'];
				$phone = $row['phone'];
				$designation = $row['designation'];
				$address_1 = $row['address_1'];
				$address_2 = $row['address_2'];
				$town = $row['town'];
				$state = $row['state'];
				$postcode = $row['postcode'];
				$country_id = $row['country_id'];
				$status = $row['status'];
				$nic = $row['nic'];
				$account_number = $row['account_number'];
				$bank = $row['bank'];
				$branch_name = $row['branch_name'];
				$branch_code = $row['branch_code'];
				$created = $row['created'];
				$image = $row['image'];
				$facebook_url = $row['facebook_url'];
				$linkedin_url = $row['linkedin_url'];
				$instagram_url = $row['instagram_url'];
				


				$id_image_name = $row['id_image'];

				$email_verified = $row['email_verified'];
				$email_verified_link = $row['email_verified_link'];
				$email_verified_time = $row['email_verified_time'];


				$full_name = $first_name . ' ' .$last_name;


				$id_image = '../assets/images/id_verifications/'.$id_image_name.'';


				$img_path = 'assets/artists/'.$user_id.'/';
				$img_backend_path = '../assets/artists/'.$user_id.'/';

				$image_frontend = $img_path.$image;
				$image_backend = $img_backend_path.$image;

				if ( !file_exists($image_frontend) ) {
					$image_frontend = 'assets/artists/dummy.png';
				}			
				
				if ( !file_exists($image_backend) ) {
					$image_backend = '../assets/artists/dummy.png';
				}


				$countr = new Users();
				$country_name = $countr->country($country_id)['name'];



			}
		}

		//Check ID image extension
		$id_image_status = ( pathinfo($id_image_name, PATHINFO_EXTENSION) == 'jpg' ) ? 1 : 0;

		$db->close();

        return array(
            'id' => $id,
            'role_id' => $role_id,
            'username' => $username,
            'password' => $password,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'new_email' => $new_email,
            'phone' => $phone,
            'designation' => $designation,
            'address_1' => $address_1,
            'address_2' => $address_2,
            'town' => $town,
            'state' => $state,
            'postcode' => $postcode,
            'country_id' => $country_id,
            'country_name' => $country_name,
            'status' => $status,
            'nic' => $nic,
            'created' => $created,
            'image_front' => $image_frontend,
            'image' => $image_backend,
            'image_name' => $image,
            'facebook_url' => $facebook_url,
            'linkedin_url' => $linkedin_url,
            'instagram_url' => $instagram_url,
            'email_verified' => $email_verified,
            'email_verified_link' => $email_verified_link,
            'email_verified_time' => $email_verified_time,
            'full_name' => $full_name,
            'id_image' => $id_image,
            'id_image_status' => $id_image_status,
            'id_image_name' => $id_image_name,
            'account_number' => $account_number,
            'bank' => $bank,
            'branch_name' => $branch_name,
            'branch_code' => $branch_code,
            
        ); 

	}

	//User Role
	public function user_role($role_id){

		switch ($role_id) {
			case 1:
				$role = 'Admin';
				break;
			case 2:
				$role = 'Artist';
				break;
			case 3:
				$role = 'User';
				break;
			default:
				$role = 'User';
				break;
		}


		return $role;

	}


	// User Country Type
	public function country($country_id){

        include DB;

		$query = $db->query("SELECT * FROM `countries` WHERE `id` = '$country_id' ");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
				$code = $row['code'];
				$name = $row['name'];
				$status = $row['status'];
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'code' => $code,
            'name' => $name,
            'status' => $status
        ); 

	}


	//Artists Information
    public function artist_information($user_id){

        include DB;

        /*Creates an array*/
        
        $ar_arr_2 = array();

		$sql = "SELECT 
		ai.type_id AS type_id,
		ait.type AS type
		FROM artist_informations AS ai INNER JOIN artist_information_types AS ait ON ait.id = ai.type_id
		WHERE ai.user_id = '$user_id' AND ai.status = '1' GROUP BY ai.type_id ";
		$queryTypeIds = $db->query($sql);
		$rowCountTypeIds = $queryTypeIds->num_rows;
		if($rowCountTypeIds > 0){
		    while($rowTypeIds = $queryTypeIds->fetch_assoc()){ 
		      	$this_type_id = $rowTypeIds['type_id'];
		      	$ait_type = $rowTypeIds['type'];    

		      	$ar_arr = array();
		      	$descriptions = '';
		      	$query = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$user_id' AND `type_id` = '$this_type_id' AND `status` = '1'");
		      	$rowCount = $query->num_rows;
		      	if($rowCount > 0){
		          	while($row = $query->fetch_assoc()){ 
		              	$temp_id = $row['id'];
		              	$description = $row['description'];
		              	
				        $arr = array(
				            'temp_id' => $temp_id,
				            'description' => $description,			            
				        ); 

						array_push($ar_arr, $arr);
		          	}
		      	}

		      	$ari = array(
			        'this_type_id' => $this_type_id,
			        'ait_type' => $ait_type,
			        'data' => $ar_arr,        
			    ); 

	    		array_push($ar_arr_2, $ari);


			}
		}

		$db->close();      	
	
        return  $ar_arr_2; 

	}



	//Artist Services
    public function artist_services($user_id){

        include DB;

        /*Creates an array*/        
        $services = array();
  
		$sql = "SELECT
		ast.id AS id,
		ast.user_id AS user_id,
		ast.service_id AS service_id,
		ast.status AS status,
		s.type AS type
		FROM artist_services AS ast INNER JOIN services AS s ON ast.service_id = s.id
		WHERE ast.user_id = '$user_id'";
		$query = $db->query($sql);
		$rowCount = $query->num_rows;
		if($rowCount > 0){
		    while($row = $query->fetch_assoc()){ 
		      	$id = $row['id'];
		      	$user_id = $row['user_id'];
		      	$service_id = $row['service_id'];
		      	$type = $row['type'];
		      	$status = $row['status'];

		      	$arr = array(
			        'id' => $id,
			        'user_id' => $user_id,
			        'service_id' => $service_id,
			        'type' => $type,
			        'status' => $status,         
			    ); 

	    		array_push($services, $arr);


			}
		}

		$db->close();      	
	
        return  $services; 

	}


	//All  Pending NIC approvals count
    public function pending_nic_approval_count(){

        include DB;

		$sql = "SELECT * FROM `users` WHERE `role_id` = 2 AND `nic` != 1 AND `id_image` IS NOT NULL ORDER BY `id` DESC";

		$query = $db->query($sql);
		$rowCount = $query->num_rows;

		$db->close();


        return $rowCount; 

	}



	//Artist rates
    public function artist_ratings($artist_id){

        include DB;

        $one = 0;      
        $two = 0;      
        $three = 0;      
        $four = 0;      
        $five = 0;   

        $tot = 0;   
        

		$query = $db->query("SELECT * FROM `ratings` WHERE `rate_artist_id` = '$artist_id'");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
		    while($row = $query->fetch_assoc()){ 
		      	$rate = $row['rate'];
		      	$tot = $tot + $rate;


		      	if ( $rate == 1 ) {
      	      		$one++;
      	      	} 

      	      	if ( $rate == 2 ) {
      	      		$two++;
      	      	}

      	      	if ( $rate == 3 ) {
      	      		$three++;
      	      	}

      	      	if ( $rate == 4 ) {
      	      		$four++;
      	      	}

      	      	if ( $rate == 5 ) {
      	      		$five++;
      	      	}      	
			}
		}

		$db->close(); 

		$percentage = $rowCount * 5;
		$percentage = 100 / $percentage;
		$percentage = $percentage * $tot;
		$percentage = $percentage / 20;
	
        return  array(
			'count' => $rowCount,        	
			'total' => $tot,        	
			'percentage' => $percentage,        	
			'one' => $one,        	
			'two' => $two,        	
			'three' => $three,        	
			'four' => $four,        	
			'five' => $five,        	
        ); 

	}


	//contact inquiries
    public function contact_inquiries($user_id){

        include DB;

		$query = $db->query("SELECT * FROM `inquiry` ORDER BY `id` DESC");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				
				$id = $row['id'];
			    $first_name = $row['first_name'];
			    $last_name = $row['last_name'];
			    $full_name = $row['first_name']. ' ' .$row['last_name'];
			    $title = $row['title'];
			    $description = $row['description'];
			    $email = $row['email'];
			    $phone = $row['phone'];
			    $created = $row['created'];
			    $status = $row['status'];
			}
		}

		$db->close();

        return array(
            'id' => $id,
            'first_name' => $first_name,
            'last_name' => $last_name,
            'full_name' => $full_name,
            'title' => $title,
            'description' => $description,
            'email' => $email,
            'phone' => $phone,
            'created' => $created,
            'status' => $status,

      
        ); 

	}


	//contact inquiries
    public function contact_inquiries_unread_count(){

        include DB;

		$query = $db->query("SELECT * FROM `inquiry`  WHERE `status` = '0'");
		$rowCount = $query->num_rows;
		

		$db->close();

        $db->close();
        return $rowCount;

	}


	public function contact_inquiry_mark_as_read($inquiry_id){

		include DB;
		$query = $db->query("SELECT * FROM `inquiry` WHERE `id` = '$inquiry_id' AND `status` = 0");
		$rowCount = $query->num_rows;
		if($rowCount > 0){
			while($row = $query->fetch_assoc()){
				$id = $row['id'];
				$db->query("UPDATE `inquiry` SET `status`= 1 WHERE `id` = '$id'");
			}
		}

		$db->close();
		
        return true;

	}


}

?>