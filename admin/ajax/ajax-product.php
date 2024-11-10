<?php
require '../../App/connection.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];


/* ADD PRODUCT*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_new_product' ) {

    $return_url = '';
    $validate = true;

    if ( strlen($_POST['title']) <= 0 ) {
        $validate = false;
        $message = 'Title field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['image']) <= 0 ) {
        $validate = false;
        $message = 'Image required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['price']) <= 0 ) {
        $validate = false;
        $message = 'Price field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {

        $category_id = $db->real_escape_string($_POST['category_id']);
        $medium_id = $db->real_escape_string($_POST['medium_id']);
        $title = $db->real_escape_string($_POST['title']);
        $orientation = $db->real_escape_string($_POST['orientation']);
        $dimension_id = $db->real_escape_string($_POST['dimension_id']);
        $dimension_x = $db->real_escape_string($_POST['dimension_x']);
        $dimension_y = $db->real_escape_string($_POST['dimension_y']);
        $dimension_label_id = $db->real_escape_string($_POST['dimension_label_id']);
        $artwork_date = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['artwork_date'])));
        $post_method = $db->real_escape_string($_POST['post_method']);
        $bid_start_time = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['bid_start_time'])));
        $bid_end_time = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['bid_end_time'])));
        $price = $db->real_escape_string($_POST['price']);
        $quantity = $db->real_escape_string($_POST['quantity']);
        $description = $db->real_escape_string($_POST['description']);
        $image = $db->real_escape_string($_POST['image']);

        // Remove whitespaces
        $price = trim($price);
        $price = str_replace(' ', '', $price);

        $db->query("INSERT INTO `products`(`user_id`, `category_id`, `medium_id`, `post_method`, `bid_start_time`, `bid_end_time`, `title`, `description`, `price`, `quantity`, `orientation`, `dimension_id`, `dimension_x`, `dimension_y`, `dimension_label_id`, `image`, `artwork_date`, `status`, `admin_status`, `created`) VALUES ('$this_user_id', '$category_id', '$medium_id', '$post_method', '$bid_start_time', '$bid_end_time', '$title', '$description', '$price', '$quantity', '$orientation', '$dimension_id', '$dimension_x', '$dimension_y', '$dimension_label_id', '$image', '$artwork_date', '1', '1', '$now')");
        $last_id = $db->insert_id;

        //Create artwork folder
        $folder_path = '../../assets/artworks/'.$last_id;
        mkdir($folder_path);


        $tmp_img = '../../assets/artworks/temp/'.$image;
        $original_img = $folder_path.'/'.$image;

        if ( strlen($image) > 2 ) {
            rename($tmp_img, $original_img);
        }


        //Redirect URL
        $return_url = 'products';
        $message = 'Artwork added!';
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

/* UPDATE ARTWORK*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_product2' ) {

    $temp_id = $db->real_escape_string($_POST['temp_id']);
    $category_id = $db->real_escape_string($_POST['category_id']);
    $title = $db->real_escape_string($_POST['title']);
    $orientation = $db->real_escape_string($_POST['orientation']);
    $dimension_id = $db->real_escape_string($_POST['dimension_id']);
    $dimension_x = $db->real_escape_string($_POST['dimension_x']);
    $dimension_y = $db->real_escape_string($_POST['dimension_y']);
    $dimension_label_id = $db->real_escape_string($_POST['dimension_label_id']);
    $artwork_date = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['artwork_date'])));
    $post_method = $db->real_escape_string($_POST['post_method']);
    $bid_start_time = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['bid_start_time'])));
    $bid_end_time = date('Y-m-d H:i:s', strtotime($db->real_escape_string($_POST['bid_end_time'])));
    $price = $db->real_escape_string($_POST['price']);
    $quantity = $db->real_escape_string($_POST['quantity']);
    $description = $db->real_escape_string($_POST['description']);
    $image = $db->real_escape_string($_POST['image']);

    // Remove whitespaces
    $price = trim($price);
    $price = str_replace(' ', '', $price);
    

   $db->query("UPDATE `products` SET `category_id`= '$category_id',`post_method`='$post_method',`bid_start_time`='$bid_start_time',`bid_end_time`='$bid_end_time',`title`='$title',`description`='$description',`price`='$price',`quantity`='$quantity',`orientation`='$orientation',`dimension_id`='$dimension_id',`dimension_x`='$dimension_x',`dimension_y`='$dimension_y',`dimension_label_id`='$dimension_label_id',`image`='$image',`artwork_date`='$artwork_date' WHERE `id`= '$temp_id'");


   

    //Redirect URL
    $return_url = 'product?id='.$temp_id;

    //Return Responses
    $response = [
        'message' => 'Product Updated',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}

/* UPDATE PRODUCT*/
/*
if ( isset($_POST['type']) && $_POST['type'] == 'update_product' ) {

    $temp_id = $db->real_escape_string($_POST['temp_id']);
    $role_id = $db->real_escape_string($_POST['role_id']);
    $first_name = $db->real_escape_string($_POST['first_name']);
    $last_name = $db->real_escape_string($_POST['last_name']);
    $username = $db->real_escape_string($_POST['username']);
    $password = sha1($db->real_escape_string($_POST['password']));
    $email = $db->real_escape_string($_POST['email']);
    

    $sql = "UPDATE `users` SET `role_id`= '$role_id',`username`='$username',`email`='$email',`first_name`='$first_name',`last_name`='$last_name' WHERE `id`= '$temp_id'";

    if ( strlen($_POST['password']) > 0 ) {
        $sql = "UPDATE `users` SET `role_id`= '$role_id',`username`='$username',`password`='$password',`email`='$email',`first_name`='$first_name',`last_name`='$last_name' WHERE `id`= '$temp_id'";
    }
    

   $db->query($sql);

    //Redirect URL
    $return_url = 'users';

    //Return Responses
    $response = [
        'message' => 'User Updated',
        'status_type' => 'success',
        'url' => $return_url,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}  */


/* CHANGE PRODUCT STATUS*/
if (isset($_POST['type']) && $_POST['type'] == 'product_status') {

    $table = 'products';

    $id = $_POST['id'];

    $query = $db->query("SELECT * FROM $table WHERE `id` = '$id' ");
    $rowCount = $query->num_rows;
    if ($rowCount > 0) {
        while ($row = $query->fetch_assoc()) {
            $status = $row['status'];
            $admin_status = $row['admin_status'];
        }
    }


    if ($admin_status == 1) {
        $db->query("UPDATE $table SET `admin_status`= 0 WHERE `id` = '$id' ");
        $label = 'danger';
        $type = 'Disabled by Admin';
    } elseif ($admin_status == 0) {
        $db->query("UPDATE $table SET `admin_status`= 1 WHERE `id` = '$id' ");
        $label = 'success';
        $type = 'Active';
    }


     /*   if ( $admin_status == 0 ) {
            $label = 'danger';
            $type = 'Disabled by Admin';
        }
    */


    //Return Responses
    $response = [
        'label' => $label,
        'type' => $type,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);

}


?>