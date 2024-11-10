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


// ADD ORDER INQUIRY
if ( isset($_POST['type']) && $_POST['type'] == 'add_order_inquiry' ) {


    $validate = true;


    if ( strlen($_POST['subject']) <= 0 ) {
        $validate = false;
        $message = 'subject is required!';
        $status_type = 'error';
        $status_header = 'Opps!';
    }

    if ( strlen($_POST['note']) <= 0 ) {
        $validate = false;
        $message = 'Note field required!';
        $status_type = 'error';
        $status_header = 'Opps!';
    }


    if ( $validate ) {

        $id = $db->real_escape_string($_POST['id']);
        $subject = $db->real_escape_string($_POST['subject']);
        $note = $db->real_escape_string($_POST['note']);

        $type_id = 2;

        $db->query("INSERT INTO `order_inquiry`( `type_id`, `order_id`, `user_id`, `subject`, `note`, `status`, `created`) VALUES ('$type_id','$id','$this_user_id','$subject', '$note', '0','$now') ");


        //mail
        $reciever_name = 'Admin';
        $link = $app_url.'order-inquiries';

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
           
            $message = 'Inquiry submitted';
            $status_type = 'success';
            $status_header = 'Done!';
    }

    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
        'status_header' => $status_header,
  
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}






/*UPDATE SHIPPING DETAILS*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_shipping' ) {

    $validate = true;

    if ( strlen($_POST['first_name']) <= 0 ) {
        $validate = false;
        $message = 'First name field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['last_name']) <= 0 ) {
        $validate = false;
        $message = 'Last name required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['email']) <= 0 ) {
        $validate = false;
        $message = 'Email field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['phone']) <= 0 ) {
        $validate = false;
        $message = 'Phone field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['address_1']) <= 0 ) {
        $validate = false;
        $message = 'Address_1 field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['address_2']) <= 0 ) {
        $validate = false;
        $message = 'Address_1 field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['town']) <= 0 ) {
        $validate = false;
        $message = 'Town field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['state']) <= 0 ) {
        $validate = false;
        $message = 'State field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['country_id']) <= 0 ) {
        $validate = false;
        $message = 'Country field required!';
        $status_type = 'error';
    }
    if ( strlen($_POST['postcode']) <= 0 ) {
        $validate = false;
        $message = 'Postcode field required!';
        $status_type = 'error';
    }
  
 
    if ( $validate ) {

        $order_id = $db->real_escape_string($_POST['temp_id']);
        $first_name = $db->real_escape_string($_POST['first_name']);
        $last_name = $db->real_escape_string($_POST['last_name']);
        $email = $db->real_escape_string($_POST['email']);
        $phone = $db->real_escape_string($_POST['phone']);
        $address_1 = $db->real_escape_string($_POST['address_1']);
        $address_2 = $db->real_escape_string($_POST['address_2']);
        $town = $db->real_escape_string($_POST['town']);
        $state = $db->real_escape_string($_POST['state']);
        $country_id = $db->real_escape_string($_POST['country_id']);
        $postcode = $db->real_escape_string($_POST['postcode']);
        $payment_method = $db->real_escape_string($_POST['payment_method']);
        $note = $db->real_escape_string($_POST['note']);
     
        //General = 1
        //Bid = 2
        $post_method = 1;

        $payment_method = 1;


        $db->query("UPDATE `orders` SET `post_method`='$post_method',`payment_method`='$payment_method',`b_first_name`='$first_name',`b_last_name`='$last_name',`b_email`='$email',`b_phone`='$phone',`b_address_1`='$address_1',`b_address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode',`country_id`='$country_id',`status`='1',`note`='$note' WHERE `id`='$order_id'");



        //Redirect URL
        $return_url = 'orders';
        $message = 'Shipping details updated!';
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