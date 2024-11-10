<?php
require '../../App/connection.php';

session_start();
$this_user_id = $_SESSION['user']['id'];
//$this_user_role_id = $_SESSION['user']['role'];

/* ADD NEW BLOG*/
if ( isset($_POST['type']) && $_POST['type'] == 'add_new_blog' ) {

    
    $return_url = '';
    $validate = true;

    if ( strlen($_POST['title']) <= 0 ) {
        $validate = false;
        $message = 'Title field required!';
        $status_type = 'error';
    }

    if ( strlen($_POST['content']) <= 0 ) {
        $validate = false;
        $message = 'Content field required!';
        $status_type = 'error';
    }
    
    if ( $validate ) {
        $title = $db->real_escape_string($_POST['title']);
        $content = $db->real_escape_string($_POST['content']);
        $image = $db->real_escape_string($_POST['image']);

        $db->query("INSERT INTO `blog_posts`( `title`, `content`, `image`, `created_time`, `user_id`, `status` ) VALUES ('$title', '$content', '$image', '$now','$this_user_id', '1')");
        $last_id = $db->insert_id;


        /*//Create blog picture folder
        $folder_path = '../../assets/blogs/'.$last_id;
        mkdir($folder_path);


        $tmp_img = '../../assets/blogs/temp/'.$image;
        $original_img = $folder_path.'/'.$image;

        if ( strlen($image) > 2 ) {
            rename($tmp_img, $original_img);
        }*/

        //Redirect URL
        $return_url = 'blogs';
        $message = 'Blog Post Added';
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


/* CHANGE BLOG POST STATUS*/
if (isset($_POST['type']) && $_POST['type'] == 'blog_status') {

    $id = $_POST['id'];

    $query = $db->query("SELECT * FROM `blog_posts` WHERE `id` = '$id' ");
    $rowCount = $query->num_rows;
    if ($rowCount > 0) {
        while ($row = $query->fetch_assoc()) {
            $status = $row['status'];
        }
    }


    if ($status == 1) {
        $db->query("UPDATE `blog_posts` SET `status`= 0 WHERE `id` = '$id' ");
        $label = 'warning';
        $type = 'Inactive';
    } elseif ($status == 0) {
        $db->query("UPDATE `blog_posts` SET `status`= 1 WHERE `id` = '$id' ");
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


/* UPDATE BLOG POST*/
if ( isset($_POST['type']) && $_POST['type'] == 'update_blog' ) {


    $return_url = '';
    $validate = true;

    if ( strlen($_POST['title']) <= 0 ) {
        $validate = false;
        $message = 'Title field required!';
        $status_type = 'error';
    }

    if ( strlen(strip_tags($_POST['content'])) <= 5 ) { //strip html tags
        $validate = false;
        $message = 'Content field required!';
        $status_type = 'error';
    }

    if ( $validate ){    

        $temp_id = $db->real_escape_string($_POST['temp_id']);
        $title = $db->real_escape_string($_POST['title']);
        $content = $db->real_escape_string($_POST['content']);
        $updated_time = $db->real_escape_string($_POST['updated_time']);
        $user_id = $db->real_escape_string($_POST['user_id']);
        $image = $db->real_escape_string($_POST['image']);
       

        $sql = "UPDATE `blog_posts` SET `title`= '$title',`content`='$content',`updated_time`='$now',`user_id`='$this_user_id',`image`='$image' WHERE `id`= '$temp_id'";

       $db->query($sql);

        //Redirect URL
        $return_url = 'Blogs';
        $message = 'Blog Post Added';
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


/* Upload Blog Picture*/
if ( isset($_POST['type']) && $_POST['type'] == 'upload_blog_image' ) {


    $img_path = '../../assets/blogs/';

    $img = $_POST['image']; 
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $image_name = time() . '_temp.png';
    $upload_path = $img_path . $image_name;
    file_put_contents($upload_path, $data);



    if ( file_exists($upload_path)) {

        $file_name = 'w_'.time() . '.jpg';
        $file_name_with_path = $img_path . $file_name;
        $image = imagecreatefrompng($upload_path);
        imagejpeg($image, $file_name_with_path, 80);
        imagedestroy($image);

        unlink($upload_path);
        $status = 'Image Uploaded!';
    }


    $file_with_path = '../assets/blogs/'.$file_name;

    //Return Responses
    $response = [
        'filename' => $file_name,
        'status' => 'Image uploaded!',
        'file_with_path' => $file_with_path,
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}


?>