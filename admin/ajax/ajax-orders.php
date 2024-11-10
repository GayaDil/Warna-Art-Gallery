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

//ADD ORDR INQUIRY
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

        $type_id = 1;

        $db->query("INSERT INTO `order_inquiry`( `type_id`, `order_id`, `user_id`, `subject`, `note`, `status`, `created`) VALUES ('$type_id','$id','$this_user_id','$subject', '$note', '1','$now') ");
        $last_id = $db->insert_id;

        //mail


        $op = new Orders();
        $cust_name = $op->order($id)['full_name'];
        $email = $op->order($id)['email'];

        $link = $app_url.'order-inquiry?id='.$last_id;

        $email_title = $subject;
        $emailcontent = $note;

        $cust_template = file_get_contents('../email/order-approve.tpl');
        $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
        $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
        $cust_template = str_replace("<!-- #{emailcontent} -->", $emailcontent, $cust_template);
        $cust_template = str_replace("<!-- #{Link} -->", $link, $cust_template);


        $cust_mail_subject = $title;;            

        $mail = new Mail();

     
        $mail->send($cust_name, $admin_email_address, $cust_mail_subject, $cust_template );





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

//UPDATE ORDER INQUIRY
if ( isset($_POST['type']) && $_POST['type'] == 'update_order_payment' ) {

    $id = $db->real_escape_string($_POST['id']);
    $status = $db->real_escape_string($_POST['status']);
    $amount = $db->real_escape_string($_POST['amount']);
    $description = $db->real_escape_string($_POST['description']);


    $db->query("UPDATE `payments` SET `amount`='$amount',`description`='$description',`status`='$status',`status_user_id`='$this_user_id',`status_time`='$now' WHERE `id`= '$id' ");



        //Redirect URL
       
        $message = 'Payment Updated';
        $status_type = 'success';


    //Return Responses
    $response = [
        'message' => $message,
        'status_type' => $status_type,
  
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

//sEND CONTACT INQUIRY
if ( isset($_POST['type']) && $_POST['type'] == 'send_contact_inquiry' ) {


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


        $ci = new Users();
        $full_name = $ci->contact_inquiries($id)['full_name'];
        $email = $ci->contact_inquiries($id)['email'];

        

        //Send Notification email to User
        
        $user_template = file_get_contents('../../email/order-dispatched-customer.tpl');

        $email_title = $subject;
        $email_content = $note;


        $user_template = str_replace("<!-- #{emailTitle} -->", $email_title, $user_template);
        $user_template = str_replace("<!-- #{userFullName} -->", $full_name, $user_template);
        $user_template = str_replace("<!-- #{emailContent} -->", $email_content, $user_template);


        $cust_mail_subject = $email_title;            

        $mail = new Mail();
        $mail->send($full_name, $email, $cust_mail_subject, $user_template );










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


/*UPDATE COMMISSION PERCENTAGE*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_commission' ) {

    

    $commission = $db->real_escape_string($_POST['commission']);


    $message = '';
    $validate = true;


    if ( strlen($_POST['commission']) <= 0 ) {
        $validate = false;
        $message = 'commission feild is required!';
        $status_type = 'error';
    }



    if ( $validate == true ) {

        $db->query("UPDATE `commission` SET `percentage`='$commission' WHERE `id`= 1 ");

        //Redirect URL
        $return_url = 'commission';
        $message = 'Commission updated!';
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

?>