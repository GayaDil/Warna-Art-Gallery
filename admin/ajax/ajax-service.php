<?php
require '../../App/connection.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];


/* ADD NEW SERVICE*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_new_service' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['service']) <= 0 ) {
        $validate = false;
        $message = 'Service field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

        $type = $db->real_escape_string($_POST['service']);

        $db->query("INSERT INTO `services`(`type`, `status`) VALUES ('$type', '1')");

        //Redirect URL
        $return_url = 'services';
        $message = 'service Added';
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


/* UPDATE SERVICE*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_service' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['service']) <= 0 ) {
        $validate = false;
        $message = 'Service field required!';
        $status_type = 'error';
    }


    if ( $validate ){   

        $temp_id = $db->real_escape_string($_POST['temp_id']);
        $type = $db->real_escape_string($_POST['service']);

        $db->query("UPDATE `services` SET `type`= '$type' WHERE `id`= '$temp_id' ");

        //Redirect URL
        $return_url = 'services';
        $message = 'Service Updated!';
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


/* CHANGE SERVICR STATUS*/
if (isset($_POST['type']) && $_POST['type'] == 'service_status') {

    $table = 'services';

    $id = $_POST['id'];

    $query = $db->query("SELECT * FROM $table WHERE `id` = '$id' ");
    $rowCount = $query->num_rows;
    if ($rowCount > 0) {
        while ($row = $query->fetch_assoc()) {
            $status = $row['status'];
        }
    }


    if ($status == 1) {
        $db->query("UPDATE $table SET `status`= 0 WHERE `id` = '$id' ");
        $label = 'warning';
        $type = 'Inactive';
    } elseif ($status == 0) {
        $db->query("UPDATE $table SET `status`= 1 WHERE `id` = '$id' ");
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


?>