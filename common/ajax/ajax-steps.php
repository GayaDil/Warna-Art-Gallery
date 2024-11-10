<?php
require '../../App/connection.php';
require '../../App/Orders.php';
require '../../App/Users.php';
require '../../App/Mail.php';
session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];


$app_url = 'http://localhost/warna2/3/';
$admin_email_address = 'e151041105@bit.uom.lk';


/* APPROVE STEP 2*/
if ( isset($_POST['type']) && $_POST['type'] == 'approve_step_2' ) {

    $id = $db->real_escape_string($_POST['id']);
    $note = $db->real_escape_string($_POST['note']);

    $this_status = 2;

    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$id'");


    //Update status_user_id and Status_time on Order Products table
    $ops = new Orders();
    $order_products = $ops->order_products($id)['items'];

    foreach ( $order_products as $op ) {

        $this_id = $op['id'];
        if ( !($op['status_user_id'] > 0) ) {
            $db->query("UPDATE `order_products` SET `status_user_id`= '$this_user_id',`status_time`= '$now' WHERE `id`= '$this_id' ");
        }

    }
    


    //payments


    //Send Account verification email
    
    $reciever_name = 'Admin';
    $link = $app_url.'order-view?id='.$id;

    $email_title = 'Order approved';
    $emailcontent = 'Order ID'. $id . ' has been approved';

    $admin_template = file_get_contents('../email/order-approve.tpl');
    $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);
    $admin_template = str_replace("<!-- #{userFullName} -->", $reciever_name, $admin_template);
    $admin_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $admin_template);
    $admin_template = str_replace("<!-- #{Link} -->", $link, $admin_template);


    $admin_mail_subject = 'Order ID'. $id . ' has been approved';            

    $mail = new Mail();

    $admin_name = 'Admin';
    $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );




    //Send Account verification email to Customer


    $op = new Orders();
    $cust_name = $op->order($id)['full_name'];
    $email = $op->order($id)['email'];



    $link = $app_url.'order-view?id='.$id;

    $email_title = 'Order ID'. $id . ' has been approved.';
    $emailcontent = 'This order is waiting your payment';

    $cust_template = file_get_contents('../email/order-approve.tpl');
    $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
    $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
    $cust_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $cust_template);
    $cust_template = str_replace("<!-- #{Link} -->", $link, $cust_template);


    $cust_mail_subject = 'Order ID'. $id . ' has been approved';            

    $mail = new Mail();
    $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );






    //Redirect URL
    $return_url = 'orders';

    //Return Responses
    $response = [
        'message' => 'Order Approved!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

/* REJECT STEP 2*/
if ( isset($_POST['type']) && $_POST['type'] == 'reject_step_2' ) {

    $id = $db->real_escape_string($_POST['id']);
    $note = $db->real_escape_string($_POST['note']);

    $this_status = 8;

    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$id'");

    //Update status, status_user_id and Status_time on Order Products table
    $ops = new Orders();
    $order_products = $ops->order_products($id)['items'];

    foreach ( $order_products as $op ) {

        $this_id = $op['id'];
        $db->query("UPDATE `order_products` SET `status`= '0',`status_user_id`= '$this_user_id',`status_time`= '$now' WHERE `id`= '$this_id' ");

    }

    //Send Notification email to User
    //Email body goes here....
    

    //Redirect URL
    $return_url = 'orders';

    //Return Responses
    $response = [
        'message' => 'Order Rejected!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}







/* ADD PAYMENT-  USER-  STEP 3*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_payment' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['payment_amount']) <= 0 ) {
        $validate = false;
        $message = 'Amout field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['image']) <= 0 ) {
        $validate = false;
        $message = 'Image required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['payment_date']) <= 0 ) {
        $validate = false;
        $message = 'Payment Date field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {
     
        $order_id = $db->real_escape_string($_POST['temp_id']);
        $image = $db->real_escape_string($_POST['image']);
        $payment_date = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['payment_date'])));
        $payment_amount = $db->real_escape_string($_POST['payment_amount']);
        $payment_description = $db->real_escape_string($_POST['payment_description']);

        // Remove whitespaces
        $payment_amount = trim($payment_amount);
        $payment_amount = str_replace(' ', '', $payment_amount);


        $db->query("INSERT INTO `payments`(`order_id`, `user_id`, `amount`, `payment_date`, `description`, `created`, `image`, `status`) VALUES ('$order_id', '$this_user_id','$payment_amount','$payment_date','$payment_description', '$now','$image','0')");
        $last_id = $db->insert_id;
        

        //Add records to Order progress table
        $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '3', '$now', 'Payment submited')");


        //Change status on Orders table
         $db->query("UPDATE `orders` SET `status`= '3' WHERE `id` = '$order_id'");


        $payment_amount = number_format($payment_amount, 2);

        //START - Send Notification emails to CUSTOMER and ADMIN
        $cust_template = file_get_contents('../email/payment-submitted-customer.tpl');


        $op = new Orders();
        $cust_name = $op->order($order_id)['full_name'];
        $email = $op->order($order_id)['email'];

        $email_title = 'Thank you for your payment!';
        $emailcontent = 'You will receive a confirmation email shortly.';

        $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
        $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $cust_template);


        $cust_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $cust_template);
        $cust_template = str_replace("<!-- #{totalAmountPaid} -->", $payment_amount, $cust_template);
        $cust_template = str_replace("<!-- #{paymentCreatedTime} -->", date('d-F-Y h:i A', time()), $cust_template);
        $cust_template = str_replace("<!-- #{paymentCustomerName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{paymentNote} -->", $payment_description, $cust_template);

        $cust_mail_subject = 'Thank you for your payment!';            

        $mail = new Mail();
        $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );


        //send email to admin

        $admin_template = file_get_contents('../email/payment-submitted-customer.tpl');

        $email_title = 'New Payment Received!';
        $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);

        $admin_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $admin_template);
        $admin_template = str_replace("<!-- #{totalAmountPaid} -->", $payment_amount, $admin_template);
        $admin_template = str_replace("<!-- #{paymentCreatedTime} -->", date('d-F-Y h:i A', time()), $admin_template);
        $admin_template = str_replace("<!-- #{paymentCustomerName} -->", $cust_name, $admin_template);
        $admin_template = str_replace("<!-- #{paymentNote} -->", $payment_description, $admin_template);

        $admin_mail_subject = 'New Payment Received!';            

        $mail = new Mail();

        $admin_name = 'Admin';
        $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );



        //Redirect URL
        $return_url = 'payment-submitted?id='.$last_id;
        $message = 'Your Payment Has Been Submitted!';
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



/* ADD PAYMENT-  ADMIN-  STEP 3*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_payment_admin' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['payment_amount']) <= 0 ) {
        $validate = false;
        $message = 'Amout field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['image']) <= 0 ) {
        $validate = false;
        $message = 'Image required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['payment_date']) <= 0 ) {
        $validate = false;
        $message = 'Payment Date field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {
     
        $order_id = $db->real_escape_string($_POST['temp_id']);
        $image = $db->real_escape_string($_POST['image']);
        $payment_date = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['payment_date'])));
        $payment_amount = $db->real_escape_string($_POST['payment_amount']);
        $payment_description = $db->real_escape_string($_POST['payment_description']);


        $op = new Orders();
        $customer_id = $op->order($order_id)['user_id'];

        // Remove whitespaces
        $payment_amount = trim($payment_amount);
        $payment_amount = str_replace(' ', '', $payment_amount);


        $db->query("INSERT INTO `payments`(`order_id`, `user_id`, `amount`, `payment_date`, `description`, `created`, `image`, `status`) VALUES ('$order_id', '$customer_id','$payment_amount','$payment_date','$payment_description', '$now','$image','0')");
        $last_id = $db->insert_id;
        

        //Add records to Order progress table
        $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '3', '$now', 'Payment submited')");


        //Change status on Orders table
         $db->query("UPDATE `orders` SET `status`= '3' WHERE `id` = '$order_id'");


        $payment_amount = number_format($payment_amount, 2);

        //START - Send Notification emails to CUSTOMER and ADMIN
        $cust_template = file_get_contents('../email/payment-submitted-customer.tpl');


        $op = new Orders();
        $cust_name = $op->order($order_id)['full_name'];
        $email = $op->order($order_id)['email'];

        $email_title = 'Thank you for your payment!';
        $emailcontent = 'You will receive a confirmation email shortly.';

        $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
        $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $cust_template);


        $cust_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $cust_template);
        $cust_template = str_replace("<!-- #{totalAmountPaid} -->", $payment_amount, $cust_template);
        $cust_template = str_replace("<!-- #{paymentCreatedTime} -->", date('d-F-Y h:i A', time()), $cust_template);
        $cust_template = str_replace("<!-- #{paymentCustomerName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{paymentNote} -->", $payment_description, $cust_template);

        $cust_mail_subject = 'Thank you for your payment!';            

        $mail = new Mail();
        $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );


        //send email to admin

        $admin_template = file_get_contents('../email/payment-submitted-customer.tpl');

        $email_title = 'New Payment Received!';
        $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);

        $admin_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $admin_template);
        $admin_template = str_replace("<!-- #{totalAmountPaid} -->", $payment_amount, $admin_template);
        $admin_template = str_replace("<!-- #{paymentCreatedTime} -->", date('d-F-Y h:i A', time()), $admin_template);
        $admin_template = str_replace("<!-- #{paymentCustomerName} -->", $cust_name, $admin_template);
        $admin_template = str_replace("<!-- #{paymentNote} -->", $payment_description, $admin_template);

        $admin_mail_subject = 'New Payment Received!';            

        $mail = new Mail();

        $admin_name = 'Admin';
        $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );



        //Redirect URL
        $return_url = 'artist-approved-orders';
        $message = 'Your Payment Has Been Submitted!';
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









/* APPROVE STEP 4*/
if ( isset($_POST['type']) && $_POST['type'] == 'approve_step_4' ) {

    $payment_id = $db->real_escape_string($_POST['payment_id']);
    $order_id = $db->real_escape_string($_POST['order_id']);
    $note = $db->real_escape_string($_POST['note']);

    

    //Change status on Payments table
    $db->query("UPDATE `payments` SET `status`= '1', `status_user_id`= '$this_user_id', `status_time`= '$now' WHERE `id` = '$payment_id'");

    //Get order Total
    $ot = new Orders();
    $order_total = $ot->order_products($order_id)['general']['total'];

    // total paid amount of this order
    $op = new Orders();
    $paid_total = $op->order_paid_total($order_id);

    $due_amount = $order_total - $paid_total;

    


    if ( $due_amount > 0 ) {

        $this_status = 11;
        $note = 'Partial Payment approval:: '. $note;

        //Add records to Order progress table
        $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '$this_status', '$now', '$note')");


        //Change status on Orders table
        $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$order_id'");


        //Send Notification email to Customer
        
        $cust_template = file_get_contents('../../email/payment-confirmation-customer.tpl');


        $op = new Orders();
        $cust_name = $op->order($order_id)['full_name'];
        $email = $op->order($order_id)['email'];

        $email_title = 'Payment Approved!';
        $email_content = 'Thank you for your payment for order #'.str_pad($order_id, 5, 0, STR_PAD_LEFT);
        $email_content_due = '<p style="color: red; font-weight:600;">You have due amount of '.number_format($due_amount, 2).'</p>.';


        $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
        $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{emailContent} -->", $email_content, $cust_template);
        $cust_template = str_replace("<!-- #{emailContentDue} -->", $email_content_due, $cust_template);

        $cust_mail_subject = $email_title;            

        $mail = new Mail();
        $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );



    }else{

        $this_status = 4;

        $note = 'Payment approval:: '. $note;

        //Add records to Order progress table
        $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '$this_status', '$now', '$note')");


        //Change status on Orders table
        $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$order_id'");


        //Send Notification email to Customer
        
        $cust_template = file_get_contents('../../email/payment-confirmation-customer.tpl');


        $op = new Orders();
        $cust_name = $op->order($order_id)['full_name'];
        $email = $op->order($order_id)['email'];

        $email_title = 'Payment Approved!';
        $email_content = 'Thank you for your payment for order #'.str_pad($order_id, 5, 0, STR_PAD_LEFT);
        $email_content_due = '';


        $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
        $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{emailContent} -->", $email_content, $cust_template);
        $cust_template = str_replace("<!-- #{emailContentDue} -->", $email_content_due, $cust_template);

        $cust_mail_subject = $email_title;            

        $mail = new Mail();
        $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );




        //Send Notification email to Artist
        $oa = new Orders();
        $artist_id = $oa->order($order_id)['artist_id'];
        $customer_id = $oa->order($order_id)['user_id'];
        $address_1 = $oa->order($order_id)['address_1'];
        $address_2 = $oa->order($order_id)['address_2'];
        $town = $oa->order($order_id)['town'];
        $state = $oa->order($order_id)['state'];
        $postcode = $oa->order($order_id)['postcode'];
        $country_name = $oa->order($order_id)['country_name'];

        $ce = new Users();
        $artist_email = $ce->user($artist_id)['email'];
        $artist_name = $ce->user($artist_id)['first_name'].' '.$ce->user($artist_id)['last_name'];

        $artist_template = file_get_contents('../../email/pending-shipment-artist.tpl');
        $artist_view_btn = $app_url.'artist/order-view?id='.$order_id;

        $cust_address = $address_1.'</br> '.$address_2.'</br> '.$town.'</br> '.$state.'</br> '.$postcode.'</br> '.$country_name;

        $artist_template = str_replace("<!-- #{userFullName} -->", $artist_name, $artist_template);

        $artist_template = str_replace("<!-- #{viewButton} -->", $artist_view_btn, $artist_template);
        $artist_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $artist_template);
        $artist_template = str_replace("<!-- #{orderCustomerName} -->", $cust_name, $artist_template);
        $artist_template = str_replace("<!-- #{orderAddress} -->", $cust_address, $artist_template);


        $artist_mail_subject = 'You Have New Order Shipment Request'; 

        $mail = new Mail();
        $mail->send($artist_name, $artist_email, $artist_mail_subject, $artist_template );


    }

 

    //Redirect URL
    $return_url = 'order-payments?id='.$order_id;

    //Return Responses
    $response = [
        'message' => 'Payment Approved!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* REJECT STEP 4*/
if ( isset($_POST['type']) && $_POST['type'] == 'reject_step_4' ) {

    $payment_id = $db->real_escape_string($_POST['payment_id']);
    $order_id = $db->real_escape_string($_POST['order_id']);
    $note = $db->real_escape_string($_POST['note']);

    $this_status = 9;

    $note = 'Payment Reject '. $note;
    

    //Change status on Payments table
    $db->query("UPDATE `payments` SET `status`= '2', `status_user_id`= '$this_user_id', `status_time`= '$now' WHERE `id` = '$payment_id'");


    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$order_id'");



    //Send Notification email to Customer
    $cust_template = file_get_contents('../../email/payment-rejection-customer.tpl');

    $op = new Orders();
    $cust_name = $op->order($order_id)['full_name'];
    $email = $op->order($order_id)['email'];

    $email_title = 'Payment Rejected!';
    $email_content = 'Your payment for order #'.str_pad($order_id, 5, 0, STR_PAD_LEFT) .' has been rejected by Admin';

    $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
    $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
    $cust_template = str_replace("<!-- #{emailContent} -->", $email_content, $cust_template);
    $cust_template = str_replace("<!-- #{rejectedReason} -->", $note, $cust_template);

    $cust_mail_subject = $email_title;            

    $mail = new Mail();
    $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );



    

    //Redirect URL
    $return_url = 'order-payments?id='.$order_id;

    //Return Responses
    $response = [
        'message' => 'Payment Rejected!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}








/* APPROVE STEP 5*/
if ( isset($_POST['type']) && $_POST['type'] == 'approve_step_5' ) {

    $id = $db->real_escape_string($_POST['id']);
    $note = $db->real_escape_string($_POST['note']);

    $this_status = 5;

    $note = 'Order Dispatch:: '. $note;

    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$id'");






    //Send Notification email to Customer
    
    $cust_template = file_get_contents('../../email/order-dispatched-customer.tpl');


    $op = new Orders();
    $cust_name = $op->order($id)['full_name'];
    $email = $op->order($id)['email'];

    $email_title = 'Your order has shipped!!';
    $email_content = 'Your order ID #'.str_pad($id, 5, 0, STR_PAD_LEFT).' has shipped!!'. $note;


    $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
    $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
    $cust_template = str_replace("<!-- #{emailContent} -->", $email_content, $cust_template);

    $cust_mail_subject = $email_title;            

    $mail = new Mail();
    $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );






   //Send Notification email to Admin
    
    $admin_template = file_get_contents('../../email/order-dispatched-customer.tpl');

    $email_title = 'Order Dispatched!';
    $email_content = 'Order ID #' .str_pad($id, 5, 0, STR_PAD_LEFT). ' has shipped!!'. $note;

    $admin_name = 'Admin';
    $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);
    $admin_template = str_replace("<!-- #{userFullName} -->", $admin_name, $admin_template);
    $admin_template = str_replace("<!-- #{emailContent} -->", $email_content, $admin_template);
       
    $admin_mail_subject = 'Order ' .$id. ' Dispatched!';            

    $mail = new Mail();

    $admin_name = 'Admin';
    $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );







    //Redirect URL
    $return_url = 'order-pending-shipments';

    //Return Responses
    $response = [
        'message' => 'Order Dispatched!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



/* REJECT STEP 5*/
if ( isset($_POST['type']) && $_POST['type'] == 'reject_step_5' ) {

    $id = $db->real_escape_string($_POST['id']);
    $note = $db->real_escape_string($_POST['note']);

    $this_status = 10;

    $note = 'Shipment Cancel '. $note;
         

    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$id'");






    //Send Notification email to Admin
    
    $admin_template = file_get_contents('../../email/order-canceled-user.tpl');

    $op = new Orders();

    $email_title = 'Order canceled!';
    $email_content = 'Sorry,  Order ID #' .str_pad($id, 5, 0, STR_PAD_LEFT). ' has been canceled';
    $admin_name = 'Admin';

    $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);
    $admin_template = str_replace("<!-- #{userFullName} -->", $admin_name, $admin_template);
    $admin_template = str_replace("<!-- #{emailContent} -->", $email_content, $admin_template);
    $admin_template = str_replace("<!-- #{rejectedReason} -->", $note, $admin_template);

    $admin_mail_subject = $email_title;            

    $mail = new Mail();


    $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );
    





    //Redirect URL
    $return_url = 'order-pending-shipments';

    //Return Responses
    $response = [
        'message' => 'Shipment Canceled!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}








/* Customer Confirm STEP 6*/
if ( isset($_POST['type']) && $_POST['type'] == 'confirm_step_6' ) {

    $id = $db->real_escape_string($_POST['id']);
    $note = $db->real_escape_string($_POST['note']);




    $this_status = 6;

    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$id'");




    //Send Notification email to Artist
    
    $artist_template = file_get_contents('../../email/order-dispatched-customer.tpl');


    $op = new Orders();
    $artist_id = $op->order($id)['artist_id'];

    $ce = new Users();
    $artist_email = $ce->user($artist_id)['email'];
    $artist_name = $ce->user($artist_id)['first_name'].' '.$ce->user($artist_id)['last_name'];


    $email_title = 'Order collected !';
    $email_content = 'Order ID #' .str_pad($id, 5, 0, STR_PAD_LEFT). ' collected !';


    $artist_template = str_replace("<!-- #{emailTitle} -->", $email_title, $artist_template);
    $artist_template = str_replace("<!-- #{userFullName} -->", $artist_name, $artist_template);
    $artist_template = str_replace("<!-- #{emailContent} -->", $email_content, $artist_template);

    $artist_mail_subject = $email_title;            

    $mail = new Mail();
    $mail->send($artist_name, $artist_email, $artist_mail_subject, $artist_template );






   //Send Notification email to Admin
    
    $admin_template = file_get_contents('../../email/order-dispatched-customer.tpl');

    $email_title = 'Order collected !';
    $email_content = 'Order ID #' .str_pad($id, 5, 0, STR_PAD_LEFT). ' collected !!';

    $admin_name = 'Admin';
    $admin_template = str_replace("<!-- #{emailTitle} -->", $email_title, $admin_template);
    $admin_template = str_replace("<!-- #{userFullName} -->", $admin_name, $admin_template);
    $admin_template = str_replace("<!-- #{emailContent} -->", $email_content, $admin_template);
       
    $admin_mail_subject = 'Order ' .$id. ' collected!';            

    $mail = new Mail();

    
    $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );







    //Redirect URL
    $return_url = 'orders';

    //Return Responses
    $response = [
        'message' => 'Order Collected!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}






/* Artist Payment STEP 7*/
if ( isset($_POST['type']) && $_POST['type'] == 'artist-payment_step_7' ) {

    $order_id = $db->real_escape_string($_POST['id']);
    $artist_id = $db->real_escape_string($_POST['artist_id']);
    $this_status = $db->real_escape_string($_POST['status']);
    $amount = $db->real_escape_string($_POST['amount']);
    $note = $db->real_escape_string($_POST['note']);

    // Remove whitespaces
    $amount = trim($amount);
    $amount = str_replace(' ', '', $amount);

    $note = 'Artist Payment:: '. $note;
    

    //Add records to artist payments table
    $db->query("INSERT INTO `artist_payments`( `order_id`, `artist_id`, `amount`, `note`, `status`, `status_user_id`, `created`) VALUES ('$order_id','$artist_id','$amount','$note','1','$this_user_id','$now') ");


    //Add records to Order progress table
    $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$order_id', '$this_user_id', '$this_status', '$now', '$note')");

    //Change status on Orders table
    $db->query("UPDATE `orders` SET `status`= '$this_status' WHERE `id` = '$order_id'");





    //Send Notification email to Artist
    $ce = new Users();
    $artist_email = $ce->user($artist_id)['email'];
    $artist_name = $ce->user($artist_id)['full_name'];

    $op = new Orders();
    $total = $op->order_products($order_id)['general']['total_label'];

    $email_title = 'Payment Received !';

    $artist_template = file_get_contents('../../email/pending-shipment-artist.tpl');


    $artist_template = str_replace("<!-- #{emailTitle} -->", $email_title, $artist_template);
    $artist_template = str_replace("<!-- #{userFullName} -->", $artist_name, $artist_template);
    $artist_template = str_replace("<!-- #{emailContent} -->", $note, $artist_template);
    $artist_template = str_replace("<!-- #{orderId} -->", str_pad($order_id, 5, 0, STR_PAD_LEFT), $artist_template);
    $artist_template = str_replace("<!-- #{ordertotal} -->", $total, $artist_template);
    $artist_template = str_replace("<!-- #{amount} -->", $amount, $artist_template);


    $artist_mail_subject = $email_title; 

    $mail = new Mail();
    $mail->send($artist_name, $artist_email, $artist_mail_subject, $artist_template );













    //Redirect URL
    $return_url = 'order-pending-payments-approve';

    //Return Responses
    $response = [
        'message' => 'Payment Approved!',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


?>