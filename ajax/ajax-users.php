<?php
require '../App/connection.php';
require '../App/Orders.php';
require '../App/Users.php';
require '../App/Mail.php';
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
        $phone = $db->real_escape_string($_POST['phone']);       
        $address_1 = $db->real_escape_string($_POST['address_1']);
        $address_2 = $db->real_escape_string($_POST['address_2']);
        $town = $db->real_escape_string($_POST['town']);
        $state = $db->real_escape_string($_POST['state']);
        $postcode = $db->real_escape_string($_POST['postcode']);
        $country_id = $db->real_escape_string($_POST['country_id']);

        $sql = "UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`country_id`='$country_id',`phone`='$phone',`address_1`='$address_1',`address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode' WHERE `id`= '$temp_id'";

        
        $db->query($sql);

        //Redirect URL
        $return_url = 'profile';
        $message = 'User details Updated';
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
        

        //set temporary notification session
        $_SESSION['password_update_notification'] = 'yes';

        unset($_SESSION['user']);

        // send email

        //Redirect URL
        $return_url = 'login';
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



/* UPDATE USER EMAIL*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_user_email' ) {

    $u = new Users();
    $password = $u->user($this_user_id)['password'];
    $first_name = $u->user($this_user_id)['first_name'];
    $last_name = $u->user($this_user_id)['last_name'];
    
    $e_password = sha1($db->real_escape_string($_POST['e_password']));
    $new_email = $db->real_escape_string($_POST['new_email']);

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

        $db->query("UPDATE `users` SET `new_email`='$new_email', `email_verified`= 0, `email_verified_link`='$email_verified_link' WHERE `id`= '$this_user_id' ");

        //Send Account verification email
        $reciever_name = $first_name.' '.$last_name;
        $mail_subject = 'Verify Your account';

        $email_verified_link = $app_url.'account-verify?verify_link='.$email_verified_link;

        $template = file_get_contents('../email/account-verification.tpl');
        $template = str_replace("<!-- #{userFullName} -->", $reciever_name, $template);
        $template = str_replace("<!-- #{verifyLink} -->", $email_verified_link, $template);


        $mail = new Mail();
        $mail->send($reciever_name, $new_email, $mail_subject, $template );


        //Redirect URL
        $return_url = 'update-email';
        $message = 'Email updated!';
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


// ADD ORDER INQUIRY
if ( isset($_POST['type']) && $_POST['type'] == 'add_inquiry' ) {


    $validate = true;


    if ( strlen($_POST['first_name']) <= 0 ) {
        $validate = false;
        $message = 'First name field required!';
        $status_type = 'error';
    }


    if ( strlen($_POST['email']) <= 0 ) {
        $validate = false;
        $message = 'Email field required!';
        $status_type = 'error';
    }


    if ( strlen($_POST['title']) <= 0 ) {
        $validate = false;
        $message = 'Title field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['description']) <= 0 ) {
        $validate = false;
        $message = 'Description field required!';
        $status_type = 'error';
    }


    if ( $validate ) {

        $first_name = $db->real_escape_string($_POST['first_name']);
        $last_name = $db->real_escape_string($_POST['last_name']);
        $email = $db->real_escape_string($_POST['email']);
        $phone = $db->real_escape_string($_POST['phone']);
        $title = $db->real_escape_string($_POST['title']);
        $description = $db->real_escape_string($_POST['description']);

        $type_id = 2;

        $db->query("INSERT INTO `inquiry`( `first_name`, `last_name`, `title`, `description`, `email`, `phone`, `status`, `created`) VALUES ('$first_name', '$last_name', '$title', '$description', '$email', '$phone', '0', '$now') ");


        // mail

        $reciever_name = 'Admin';
        $link = $app_url.'contact-inquiries';

        $email_title = $title;
        $emailcontent = $description;

        $admin_template = file_get_contents('../email/order-approve.tpl');
        $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);
        $admin_template = str_replace("<!-- #{userFullName} -->", $reciever_name, $admin_template);
        $admin_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $admin_template);
        $admin_template = str_replace("<!-- #{Link} -->", $link, $admin_template);


        $admin_mail_subject = $title;;            

        $mail = new Mail();

     
        $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );




            //Redirect URL
            $return_url = 'contact';           
            $message = 'Inquiry submitted';
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