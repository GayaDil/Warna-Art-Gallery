<?php
require '../App/connection.php';
require '../App/Products.php';
require '../App/Cart.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];

/* UPDATE CART*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_to_cart' ) {

    $id = $db->real_escape_string($_POST['id']);
    $quantity = $db->real_escape_string($_POST['quantity']);

    $pr = new Products();               
    $product_quantity = $pr->product($id)['quantity'];

    $count = '';

    if ( isset($this_user_id) ) {

        if ( $quantity > $product_quantity ) {

            $msg_header = 'Something Went Wrong!';
            $msg_body = 'Quantity can not be greater than '.$product_quantity;
            $msg_type = 'warning';

        }else{

            if( $quantity > 0 ){
                $atc = new Cart();
                $atc->add_to_cart($id, $quantity);
                

                $cc = new Cart();
                $count = $cc->cart_count();

                $msg_header = 'Cart Updated!';
                $msg_body = 'Artwork added to your cart!';
                $msg_type = 'success';
            }else{
                $msg_header = 'Something Went Wrong!';
                $msg_body = 'Quantity can not be empty or 0!';
                $msg_type = 'warning';
            }

        }
            
    }else{
        $msg_header = 'Unable to add!';
        $msg_body = 'Need to be logged in first!';
        $msg_type = 'error';
    }
    
    //Return Responses
    $response = [
        'msg_header' => $msg_header,
        'msg_body' => $msg_body,
        'msg_type' => $msg_type,
        'count' => $count,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


/* UPDATE CART QUANTITY*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_cart_quantity' ) {

    $id = $db->real_escape_string($_POST['id']);
    $quantity = $db->real_escape_string($_POST['quantity']); 

    $pq = new Cart();
    $product_quantity = $pq->cart_item($id)['product_quantity'];  

    $count = '';

    if ( isset($this_user_id) ) {       

        if ( $quantity > $product_quantity ) {

            $msg_header = 'Something Went Wrong!';
            $msg_body = 'Quantity can not be greater than '.$product_quantity;
            $msg_type = 'warning';

        }else{
            if( $quantity > 0 ){

                $atc = new Cart();
                $line_total = $atc->update_cart($id, $quantity)['total_label'];            
                
                $ct = new Cart();
                $total = $ct->cart_total()['total_label'];

                $cc = new Cart();
                $count = $cc->cart_count();

                $msg_header = 'Cart Updated!';
                $msg_body = 'Quantity Updated';
                $msg_type = 'success';

            }else{
                $msg_header = 'Something Went Wrong!';
                $msg_body = 'Quantity can not be empty or 0!';
                $msg_type = 'warning';
            }
        }

            
    }else{
        $msg_header = 'Unable to add!';
        $msg_body = 'Need to be logged in first!';
        $msg_type = 'error';
    }

    //Return Responses
    $response = [
        'msg_header' => $msg_header,
        'msg_body' => $msg_body,
        'msg_type' => $msg_type,
        'count' => $count,
        'sub_total' => $total,
        'total' => $total,
        'line_total' => $line_total,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

/* DELETE CART*/
if ( isset($_POST['type']) && $_POST['type'] == 'delete_cart_item' ) {

    $id = $db->real_escape_string($_POST['id']);
   
    $count = '';

    if ( isset($this_user_id) ) {

        $db->query("DELETE FROM `cart` WHERE `id` = '$id'");        

        $cc = new Cart();
        $count = $cc->cart_count();

        $ct = new Cart();
        $total = $ct->cart_total()['total_label'];

        $msg_header = 'Item Deleted!';
        $msg_body = 'Item deleted from your cart.';
        $msg_type = 'success';
    }else{
        $msg_header = 'Unable to Delete!';
        $msg_body = 'Need to be logged in first!';
        $msg_type = 'error';
    }
    
    //Return Responses
    $response = [
        'msg_header' => $msg_header,
        'msg_body' => $msg_body,
        'msg_type' => $msg_type,
        'count' => $count,
        'sub_total' => $total,
        'total' => $total,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}



?>