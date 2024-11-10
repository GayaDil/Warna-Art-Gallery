<?php
require '../../App/connection.php';


session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

/* Order Product Status  */
if ( isset($_POST['type']) && $_POST['type'] == 'order_product_status' ) {

    $id = $_POST['id'];

    $query = $db->query("SELECT * FROM `order_products` WHERE `id` = '$id' ");
    $rowCount = $query->num_rows;
    if ($rowCount > 0) {
        while ($row = $query->fetch_assoc()) {
            $status = $row['status'];
        }
    }


    if ($status == 1) {
        $db->query("UPDATE `order_products` SET `status`= 0, `status_user_id`= '$this_user_id', `status_time`= '$now' WHERE `id` = '$id' ");
    } elseif ($status == 0) {
        $db->query("UPDATE `order_products` SET `status`= 1, `status_user_id`= '$this_user_id', `status_time`= '$now' WHERE `id` = '$id' ");
    }


}




?>