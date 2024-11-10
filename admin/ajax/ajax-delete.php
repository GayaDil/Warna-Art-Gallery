<?php
require '../../App/connection.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];



/* ADD NEW USER*/
if ( isset($_POST['type']) && $_POST['type'] == 'delete_blog' ) {

    $id = $_POST['id'];

    //Delete Record
    $db->query("DELETE FROM `blog_posts` WHERE `id` = '$id'");


    //Redirect URL
    $return_url = 'blogs';
    $message = 'Blog Has Been Deleted!';
    $status_type = 'success';

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