<?php
require '../App/connection.php';
require '../App/Products.php';
require '../App/Cart.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

/* Place Bid*/
if ( isset($_POST['type']) && $_POST['type'] == 'place_bid' ) {

    $product_id = $db->real_escape_string($_POST['product_id']);
    $amount = $db->real_escape_string($_POST['amount']);

    // Remove whitespaces
    $amount = trim($amount);
    $amount = str_replace(' ', '', $amount);

    $validate = 0;

    $b = new Products();
    $bid_addition_amount = $b->bid_addition_amount();


    //check end time
    $bs = new Products();
    $bid_status = $bs->bid($product_id)['bid_status'];

    if ( $bid_status == 0 ) {
        $validate++;

        $msg_header = 'Unable to place bid!';
        $msg_body = 'The Bid due time has been ended or the bid has not started yet.';
        $msg_type = 'error';
    }

    //check current highest bid
    $cb = new Products();
    $highest_amount = $cb->current_ongoing_bid($product_id)['amount'];
    $highest_amount = $highest_amount + $bid_addition_amount;


    if ( $amount < $highest_amount ) {
        $validate++;

        $msg_header = 'Unable to place bid!';
        $msg_body = 'Bidding amount should be minimum Rs. '.number_format($highest_amount, 2);
        $msg_type = 'error';
    }


    if ( $validate == 0 ) {

        $db->query("INSERT INTO `bid`(`product_id`, `user_id`, `amount`, `status`, `created`) VALUES ('$product_id', '$this_user_id', '$amount', '0', '$now')");

        $msg_header = 'Bid Placed!';
        $msg_body = 'Your bid has been placed!';
        $msg_type = 'success';
    }

        
    
    //Return Responses
    $response = [
        'msg_header' => $msg_header,
        'msg_body' => $msg_body,
        'msg_type' => $msg_type,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}




?>