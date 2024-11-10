<?php
require '../../App/connection.php';
require '../../App/Users.php';
require '../../App/Mail.php';
session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

$app_url = 'http://localhost/warna2/3/';
$admin_email_address = 'e151041105@bit.uom.lk';

/* UPDATE USER*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user' ) {


    $return_url = '';
    $validate = true;

    if ( strlen($_POST['first_name']) <= 0 ) {
        $validate = false;
        $message = 'First Name field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

        $temp_id = $db->real_escape_string($_POST['temp_id']);
        $first_name = $db->real_escape_string($_POST['first_name']);
        $last_name = $db->real_escape_string($_POST['last_name']);
       /* $username = $db->real_escape_string($_POST['username']);*/
        $password = sha1($db->real_escape_string($_POST['password']));
       /* $password = $db->real_escape_string($_POST['password']);*/
        $image = $db->real_escape_string($_POST['image']);
        $phone = $db->real_escape_string($_POST['phone']);
        $designation = $db->real_escape_string($_POST['designation']);
        $address_1 = $db->real_escape_string($_POST['address_1']);
        $address_2 = $db->real_escape_string($_POST['address_2']);
        $town = $db->real_escape_string($_POST['town']);
        $state = $db->real_escape_string($_POST['state']);
        $postcode = $db->real_escape_string($_POST['postcode']);
        $country_id = $db->real_escape_string($_POST['country_id']);
        $facebook_url = $db->real_escape_string($_POST['facebook']);
        $linkedin_url = $db->real_escape_string($_POST['linkedin']);
        $instagram_url = $db->real_escape_string($_POST['instagram']);

        $sql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`image`='$image',`country_id`='$country_id', `designation`='$designation', `phone`='$phone',`address_1`='$address_1',`address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode',`facebook_url`='$facebook_url',`linkedin_url`='$linkedin_url',`instagram_url`='$instagram_url' WHERE `id`= '$temp_id'";

        if ( strlen($_POST['password']) > 0 ) {
            $sql = "UPDATE `users` SET `username`='$username',`password`='$password',`first_name`='$first_name',`last_name`='$last_name',`image`='$image',`country_id`='$country_id', `designation`='$designation', `phone`='$phone',`address_1`='$address_1',`address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode'  WHERE `id`= '$temp_id'";
        }
        
        $db->query($sql);

        //Redirect URL
        $return_url = 'profile';
        $message = 'User Updated';
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


/* UPDATE USER BANK*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_bank' ) {


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
        $return_url = 'profile';
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


/* Upload Profile Picture*/
if ( isset($_POST['type']) && $_POST['type'] == 'upload_profile_picture' ) {


    $img_path = '../../assets/artists/'.$this_user_id.'/';

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


    $file_with_path = '../assets/artists/'.$this_user_id.'/'.$file_name;

    //Return Responses
    $response = [
        'filename' => $file_name,
        'status' => 'Image uploaded!',
        'file_with_path' => $file_with_path,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* UPDATE USER PASSWORD*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user_password' ) {

    $u = new Users();
    $password = $u->user($this_user_id)['password'];
    
    $cu_password = sha1($db->real_escape_string($_POST['current_password']));
    $new_password = sha1($db->real_escape_string($_POST['new_password']));
    $re_password = sha1($db->real_escape_string($_POST['re_password']));

    $message = '';
    $validate = true;

    //Validate existing password
    if( $password != sha1($_POST['current_password']) ){
        $validate = false;
        $message .= 'Wrong Password!';
        $status_type = 'error';
    }

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
        $db->query("UPDATE `users` SET `password`='$new_password'  WHERE `id`= '$this_user_id'");
        $message = 'Password updated!';
        $status_type = 'success';
        unset($_SESSION['user']);
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
if ( isset($_POST['type']) && $_POST['type'] == 'update_user_email' ) {

    $u = new Users();
    $password = $u->user($this_user_id)['password'];
    $first_name = $u->user($this_user_id)['first_name'];
    $last_name = $u->user($this_user_id)['last_name'];
    
    $e_password = sha1($db->real_escape_string($_POST['e_password']));
    $new_email = $db->real_escape_string($_POST['new_email']);

    $message = '';
    $validate = true;

    //Validate password
    if( $password != sha1($_POST['e_password']) ){
        $validate = false;
        $message = 'Wrong Password!';
        $status_type = 'error';
    }


    //Check exist Email
    $query = $db->query("SELECT * FROM `users` WHERE `email` = '$new_email'");
    $rowCount = $query->num_rows;

    if( $rowCount > 0 ){
        $validate = false;
        $message = 'Email address already exist!';
        $status_type = 'error';
    }

    

    if ( $validate == true ) {
        $email_verified_link = 'warna'.time();
        $email_verified_link = sha1($email_verified_link);

        /*$db->query("UPDATE `users` SET `email`='$new_email', `email_verified`= 0, `email_verified_link`='$email_verified_link' WHERE `id`= '$this_user_id' AND `password` = '$password' ");*/

        $db->query("UPDATE `users` SET `new_email`='$new_email', `email_verified`= 0, `email_verified_link`='$email_verified_link' WHERE `id`= '$this_user_id' AND `password` = '$password' ");

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



/* ADD OTHER INFORMATION*/
if ( isset($_POST['type']) && $_POST['type'] == 'save_info' ) {

    //Getting All existing ids
    $exist_ids = array();
    $query = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$this_user_id'");
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

                $db->query("INSERT INTO `artist_informations`(`user_id`, `type_id`, `description`, `status`, `created`) VALUES ('$this_user_id', '$info_type_id', '$info_data', '1', '$now')");

            }

            //Update exist record
            if ( $this_id != 0 ) {

                array_push($new_ids, $this_id);

                $db->query("UPDATE `artist_informations` SET `type_id`= '$info_type_id',`description`= '$info_data' WHERE `id`= '$this_id' ");
                
            }

        }
                    

        $index++;
    }


    //Delete not existing records
    foreach ($exist_ids as $ei) {
        if ( !in_array($ei, $new_ids) ) {
            $db->query("DELETE FROM `artist_informations` WHERE `id` = '$ei'");
        }
    }


    //Return Responses
    $response = [
        'message' => 'User Added',
        'status_type' => 'success',
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* MANAGE SERVICES*/
if ( isset($_POST['type']) && $_POST['type'] == 'save_artist_services' ) {

    //Getting All existing ids
    $exist_services = array();
    $query = $db->query("SELECT * FROM `artist_services` WHERE `user_id` = '$this_user_id'");
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
            $db->query("INSERT INTO `artist_services`( `user_id`, `service_id`, `status`) VALUES ('$this_user_id', '$ns', '1')");
        }
    }

    //Delete if not existing
    foreach ($exist_services as $es ) {
        if ( !in_array($es, $new_services)) {
            $db->query("DELETE FROM `artist_services` WHERE `user_id` = '$this_user_id' AND `service_id` = '$es'");
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


/* ADD ID IMAGE*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_id_image' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['image']) <= 0 ) {
        $validate = false;
        $message = 'required to upload an image!';
        $status_type = 'error';
    }
    
    if ( $validate ) {


        $image = $db->real_escape_string($_POST['image']);
        $db->query("UPDATE `users` SET `id_image` = '$image', `nic` = '0' WHERE `id` = '$this_user_id' ");


       

        //TO ADMIN

        $admin_mail_subject = 'New User Verification Request Received';

        $page_link = $app_url.'admin/nic-view?id='.$this_user_id;

        $admin_template = file_get_contents('../../email/nic-verification-request-admin.tpl');
        $admin_template = str_replace("<!-- #{Link} -->", $page_link, $admin_template);

        $mail = new Mail();

        $admin_name = 'Admin';
        $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );



        //Redirect URL
        $return_url = 'index';
        $message = 'Image Added';
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