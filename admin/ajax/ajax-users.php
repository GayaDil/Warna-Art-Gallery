<?php
require '../../App/connection.php';
require '../../App/Users.php';
require '../../App/Mail.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

$app_url = 'http://localhost/warna2/3/';
$admin_email_address = 'e151041105@bit.uom.lk';

/* ADD NEW USER*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_new_user' ) {

    $return_url = '';
    $validate = true;


    if ( strlen($_POST['first_name']) <= 0 ) {
        $validate = false;
        $message = 'first Name field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['password']) <= 0 ) {
        $validate = false;
        $message = 'Password field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['email']) <= 0 ) {
        $validate = false;
        $message = 'Email field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

        $role_id = $db->real_escape_string($_POST['role_id']);
        $first_name = $db->real_escape_string($_POST['first_name']);
        $last_name = $db->real_escape_string($_POST['last_name']);
        $username = $db->real_escape_string($_POST['username']);
        $password = sha1($db->real_escape_string($_POST['password']));
        $email = $db->real_escape_string($_POST['email']);
        $image = $db->real_escape_string($_POST['image']);
        /*$password = sha1($db->real_escape_string($_POST['password']));*/
       
        $designation = $db->real_escape_string($_POST['designation']);
        $phone = $db->real_escape_string($_POST['phone']);
        $address_1 = $db->real_escape_string($_POST['address_1']);
        $address_2 = $db->real_escape_string($_POST['address_2']);
        $town = $db->real_escape_string($_POST['town']);
        $state = $db->real_escape_string($_POST['state']);
        $postcode = $db->real_escape_string($_POST['postcode']);
        $country_id = $db->real_escape_string($_POST['country_id']);
        $facebook_url = $db->real_escape_string($_POST['facebook']);
        $linkedIn_url = $db->real_escape_string($_POST['linkedin']);
        $instagram_url = $db->real_escape_string($_POST['instagram']);

        $db->query("INSERT INTO `users`( `role_id`, `username`, `password`, `email`, `first_name`, `last_name`, `image`, `status`, `created`) VALUES ('$role_id', '$username', '$password', '$email', '$first_name', '$last_name', '$image', '1', '$now')");
        $last_id = $db->insert_id;


        //Create artwork folder
        $folder_path = '../../assets/artists/'.$last_id;
        mkdir($folder_path);


        $tmp_img = '../../assets/artists/temp/'.$image;
        $original_img = $folder_path.'/'.$image;

        if ( strlen($image) > 2 ) {
            rename($tmp_img, $original_img);
        }

        //Redirect URL
        $return_url = 'users';
        $message = 'User Added';
        $status_type = 'success';

    }

    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}




/* UPDATE USER*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user' ) {


    $return_url = '';
    $validate = true;


    if ( strlen($_POST['first_name']) <= 0 ) {
        $validate = false;
        $message = 'first Name field required!';
        $status_type = 'error';
    }

    
    if ( $validate ) {

        $temp_id = $db->real_escape_string($_POST['temp_id']);
        $role_id = $db->real_escape_string($_POST['role_id']);
        $first_name = $db->real_escape_string($_POST['first_name']);
        $last_name = $db->real_escape_string($_POST['last_name']);
        $username = $db->real_escape_string($_POST['username']);
        /*$password = sha1($db->real_escape_string($_POST['password']));*/
        $image = $db->real_escape_string($_POST['image']);
        $designation = $db->real_escape_string($_POST['designation']);
        $phone = $db->real_escape_string($_POST['phone']);
        $address_1 = $db->real_escape_string($_POST['address_1']);
        $address_2 = $db->real_escape_string($_POST['address_2']);
        $town = $db->real_escape_string($_POST['town']);
        $state = $db->real_escape_string($_POST['state']);
        $postcode = $db->real_escape_string($_POST['postcode']);
        $country_id = $db->real_escape_string($_POST['country_id']);
        $facebook_url = $db->real_escape_string($_POST['facebook']);
        $linkedIn_url = $db->real_escape_string($_POST['linkedin']);
        $instagram_url = $db->real_escape_string($_POST['instagram']);
       

        $sql = "UPDATE `users` SET `role_id`= '$role_id',`first_name`='$first_name',`last_name`='$last_name',`image`='$image',`country_id`='$country_id', `designation`='$designation', `phone`='$phone',`address_1`='$address_1',`address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode',`facebook_url`='$facebook_url',`linkedin_url`='$linkedin_url',`instagram_url`='$instagram_url' WHERE `id`= '$temp_id'";       

       $db->query($sql);

        //Redirect URL
        $return_url = 'users';
        $message = 'User updated!';
        $status_type = 'success';

    }

    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


/* UPLOAD PROFILE PICTURE*/
if ( isset($_POST['type']) && $_POST['type'] == 'upload_profile_picture' ) {

    $artist_id = $_POST['user_id'];


    $img_path = '../../assets/artists/'.$artist_id.'/';

    $img = $_POST['image']; 
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $image_name = time() . '_temp.png';
    $upload_path = $img_path . $image_name;
    file_put_contents($upload_path, $data);





    if ( file_exists($upload_path)) {

        $file_name = 'w_'.time() . '.jpg';
        $file_name_with_path = $img_path . $file_name;
        $image = imagecreatefrompng($upload_path);
        imagejpeg($image, $file_name_with_path, 80);
        imagedestroy($image);

        unlink($upload_path);
        $status = 'Image Uploaded!';
    }


    $file_with_path = '../assets/artists/'.$artist_id.'/'.$file_name;

    //Return Responses
    $response = [
        'filename' => $file_name,
        'status' => 'Image uploaded!',
        'file_with_path' => $file_with_path,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}




/* CHANGE USER STATUS*/
if (isset($_POST['type']) && $_POST['type'] == 'user_status') {

    $id = $_POST['id'];

    $query = $db->query("SELECT * FROM `users` WHERE `id` = '$id' ");
    $rowCount = $query->num_rows;
    if ($rowCount > 0) {
        while ($row = $query->fetch_assoc()) {
            $status = $row['status'];
        }
    }


    if ($status == 1) {
        $db->query("UPDATE `users` SET `status`= 0 WHERE `id` = '$id' ");
        $label = 'warning';
        $type = 'Inactive';
    } elseif ($status == 0) {
        $db->query("UPDATE `users` SET `status`= 1 WHERE `id` = '$id' ");
        $label = 'success';
        $type = 'Active';
    }



    //Return Responses
    $response = [
        'label' => $label,
        'type' => $type,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

}



/* ADD OTHER INFORMATION*/
if ( isset($_POST['type']) && $_POST['type'] == 'save_info' ) {


    $user_id = $db->real_escape_string($_POST['temp_id']);

    //Getting All existing ids
    $exist_ids = array();
    $query = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$user_id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){    
            $id = $row['id'];
            array_push($exist_ids, $id);
        }
    }


    $ids = $_POST['this_id'];
    $new_ids = array();

    $index = 0;
    foreach ( $ids as $this_id ) {

        $info_type_id = $db->real_escape_string($_POST['info_type_id'][$index]);
        $info_data = $db->real_escape_string($_POST['info_data'][$index]);

        if ( isset($info_data) ) {
            
            //Insert new record
            if ( $this_id == 0 ) {

                $db->query("INSERT INTO `artist_informations`(`user_id`, `type_id`, `description`, `status`, `created`) VALUES ('$user_id', '$info_type_id', '$info_data', '1', '$now')");

            }

            //Update exist record
            if ( $this_id != 0 ) {

                array_push($new_ids, $this_id);

                $db->query("UPDATE `artist_informations` SET `type_id`= '$info_type_id',`description`= '$info_data' WHERE `id`= '$this_id' ");
                
            }

        }
                    

        $index++;
    }


    foreach ($exist_ids as $ei) {
        if ( !in_array($ei, $new_ids) ) {
            $db->query("DELETE FROM `artist_informations` WHERE `id` = '$ei'");
        }
    }


    //Redirect URL
    $return_url = 'users';

    //Return Responses
    $response = [
        'message' => 'User Information Added',
        'status_type' => 'success',
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}




/* MANAGE SERVICES*/
if ( isset($_POST['type']) && $_POST['type'] == 'save_artist_services' ) {

    $user_id = $db->real_escape_string($_POST['temp_id']);

    //Getting All existing ids
    $exist_services = array();
    $query = $db->query("SELECT * FROM `artist_services` WHERE `user_id` = '$user_id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){    
            $temp_service_id = $row['service_id'];
            array_push($exist_services, $temp_service_id);
        }
    }


    $new_services = $_POST['services'];

    //Insert if new type
    foreach ($new_services as $ns) {
        if ( !in_array($ns, $exist_services) ) {
            $db->query("INSERT INTO `artist_services`( `user_id`, `service_id`, `status`) VALUES ('$user_id', '$ns', '1')");
        }
    }

    //Delete if not existing
    foreach ($exist_services as $es ) {
        if ( !in_array($es, $new_services)) {
            $db->query("DELETE FROM `artist_services` WHERE `user_id` = '$user_id' AND `service_id` = '$es'");
        }
    }

    //Return Responses
    $response = [
        'message' => 'Services Updated!',
        'status_type' => 'success',
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}




/* User NIC VERIFICATION*/
if ( isset($_POST['type']) && $_POST['type'] == 'verify_nic' ) {


    $user_id = $db->real_escape_string($_POST['temp_id']);
    $image_name = $db->real_escape_string($_POST['image_name']);
    $note = $db->real_escape_string($_POST['note']);

    $db->query("UPDATE `users` SET `nic`= '1', `nic_verified_time`= '$now', `nic_note` = '$note' WHERE `id`= '$user_id'");

    //Start - Send Email
    $u = new Users();
    $full_name = $u->user($user_id)['full_name'];
    $email = $u->user($user_id)['email'];

    $page_link = $app_url.'artist/product';

    $template = file_get_contents('../../email/nic-verified.tpl');
    $template = str_replace("<!-- #{userFullName} -->", $full_name, $template);
    $template = str_replace("<!-- #{Link} -->", $page_link, $template);

    $mail_subject = 'NIC Approved!';


    $mail = new Mail();
    $mail->send($full_name, $email, $mail_subject, $template );
    //END - Send Email

    $message = 'User NIC is verified!';
    $status_type = 'success';

    //Redirect URL
    $return_url = 'pending-nic-approve';

    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* User NIC REJECTION*/
if ( isset($_POST['type']) && $_POST['type'] == 'reject_nic' ) {


    $user_id = $db->real_escape_string($_POST['temp_id']);
    $image_name = $db->real_escape_string($_POST['image_name']);
    $note = $db->real_escape_string($_POST['note']);

    $db->query("UPDATE `users` SET `nic`= '2', `nic_verified_time`= '$now', `nic_note` = '$note' WHERE `id`= '$user_id'");

    //Start - Send Email
    $u = new Users();
    $full_name = $u->user($user_id)['full_name'];
    $email = $u->user($user_id)['email'];

    $template = file_get_contents('../../email/nic-rejected.tpl');
    $template = str_replace("<!-- #{userFullName} -->", $full_name, $template);
    $template = str_replace("<!-- #{rejectedReason} -->", $note, $template);


    $mail_subject = 'NIC Verification Failed!';


    $mail = new Mail();
    $mail->send($full_name, $email, $mail_subject, $template );
    //END - Send Email

    $message = 'User NIC is rejected!';
    $status_type = 'success';

    //Redirect URL
    $return_url = 'pending-nic-approve';

    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* UPDATE USER PASSWORD*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user_password' ) {

    $temp_id = $db->real_escape_string($_POST['temp_id']);
    $new_password = sha1($db->real_escape_string($_POST['new_password']));
    $re_password = sha1($db->real_escape_string($_POST['re_password']));


    $message = '';
    $validate = true;


    //Check whether new passwords equal
    if ( $_POST['new_password'] != $_POST['re_password'] ) {

        $br = ( $validate == false ) ? ' and ' : '';
        $validate = false;
        $message .= $br.'Password do not match!';
        $status_type = 'error';
    }

    //Check min character limitation
    if ( strlen($_POST['new_password']) < 6 ) {

        $br = ( $validate == false ) ? ' and ' : '';
        $validate = false;
        $message .= $br.'Password must be minimum 6 characters.';
        $status_type = 'error';
    }

    if ( $validate == true ) {
        $db->query("UPDATE `users` SET `password`='$new_password'  WHERE `id`= '$temp_id'");
        $message = 'Password updated!';
        $status_type = 'success';
  
    }

    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* UPDATE USER EMAIL*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user_email_admin' ) {

    

    $temp_id = $db->real_escape_string($_POST['temp_id']);
    $new_email = $db->real_escape_string($_POST['new_email']);


    $u = new Users();
    $first_name = $u->user($temp_id)['first_name'];
    $last_name = $u->user($temp_id)['last_name'];
    $email = $u->user($temp_id)['email'];


    $message = '';
    $validate = true;


    

    
    //Check exist Email
    $query = $db->query("SELECT * FROM `users` WHERE `email` = '$new_email' || `new_email` = '$new_email' ");
    $rowCount = $query->num_rows;

    if( $rowCount > 0 ){
        $validate = false;
        $message = 'Email address already exist!';
        $status_type = 'error';
    }


    if ( strlen($_POST['new_email']) <= 0 ) {
        $validate = false;
        $message = 'Email field required!';
        $status_type = 'error';
    }



    if ( $validate == true ) {
        $email_verified_link = 'warna'.time();
        $email_verified_link = sha1($email_verified_link);


        $db->query("UPDATE `users` SET `new_email`='$new_email', `email_verified`= 0, `email_verified_link`='$email_verified_link' WHERE `id`= '$temp_id' ");

        //Send Account verification email
        $reciever_name = $first_name.' '.$last_name;
        $mail_subject = 'Verify Your account';

        $email_verified_link = $app_url.'account-verify?verify_link='.$email_verified_link;

        $template = file_get_contents('../../email/account-verification.tpl');
        $template = str_replace("<!-- #{userFullName} -->", $reciever_name, $template);
        $template = str_replace("<!-- #{verifyLink} -->", $email_verified_link, $template);


        $mail = new Mail();
        $mail->send($reciever_name, $new_email, $mail_subject, $template );


        //Redirect URL
        $return_url = 'profile';
        $message = 'Email updated!';
        $status_type = 'success';
        /*unset($_SESSION['user']);*/
    }

    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


/* UPDATE USER BANK*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_bank_admin' ) {


    $return_url = '';
    $validate = true;

    if ( strlen($_POST['account_number']) <= 0 ) {
        $validate = false;
        $message = 'Account Number field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['bank_name']) <= 0 ) {
        $validate = false;
        $message = 'Bank Name field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['branch_name']) <= 0 ) {
        $validate = false;
        $message = 'Branc Name field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['branch_code']) <= 0 ) {
        $validate = false;
        $message = 'Branch Code field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {


        $temp_id = $db->real_escape_string($_POST['temp_id']);
        $account_number = $db->real_escape_string($_POST['account_number']);
        $bank_name = $db->real_escape_string($_POST['bank_name']);
        $branch_name = $db->real_escape_string($_POST['branch_name']);
        $branch_code = $db->real_escape_string($_POST['branch_code']);


        $sql = "UPDATE `users` SET `account_number`='$account_number',`bank`='$bank_name',`branch_name`='$branch_name',`branch_code`='$branch_code' WHERE `id`= '$temp_id'";

        
        $db->query($sql);

        //Redirect URL
        $return_url = 'users';
        $message = 'Bank Details Updated';
        $status_type = 'success';

    }


    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



?>



