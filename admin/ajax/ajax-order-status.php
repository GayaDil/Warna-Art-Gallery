<?php
require '../../App/connection.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

/* ADD NEW ORDER STATUS*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_order_status' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['status_type']) <= 0 ) {
        $validate = false;
        $message = 'status_type field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

    $type = $db->real_escape_string($_POST['status_type']);
    $label = $db->real_escape_string($_POST['label']);

    $db->query("INSERT INTO `order_status`( `type`, `label`) VALUES ('$type', '$label')");

    //Redirect URL
    $return_url = 'order-statuses';
    $message = 'New Order Status Added';
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


/* UPDATE ORDER STATUS*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_order_status' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['status_type']) <= 0 ) {
        $validate = false;
        $message = 'status_type field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

        $id = $db->real_escape_string($_POST['temp_id']);
        $type = $db->real_escape_string($_POST['status_type']);
        $label = $db->real_escape_string($_POST['label']);

        $db->query("UPDATE `order_status` SET `type`= '$type',`label`= '$label' WHERE `id`= '$id'");

        //Redirect URL
        $return_url = 'order-statuses'; 
        $message = 'Order Status Updated';
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