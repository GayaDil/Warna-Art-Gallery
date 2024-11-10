<?php
require 'config.php';

$ops = new Orders();
$order_products = $ops->order_products(2)['items'];

foreach ( $order_products as $op ) {


        $this_id = $op['id'];

        echo $this_id;

        $text .= $this_id;

        if ( !($op['status_user_id'] > 0) ) {

        	$sql = "UPDATE `order_products` SET `status_user_id`= '$this_user_id',`status_time`= '$now' WHERE `id`= '$this_id' ";

        	//echo $sql."<br>";
            //$db->query("UPDATE `order_products` SET `status_user_id`= '$this_user_id',`status_time`= '$now' WHERE `id`= '$this_id' ");
        }

    }

?>
