<?php
require 'config.php';

$note_area_style = 'style="display:none;"';

//Note available array
$note_av_arr = array(11,12);



if (isset($_POST['update'])) {
  
    $order_id = $db->real_escape_string($_POST['temp_id']);
    $status_id = $db->real_escape_string($_POST['status_id']);
    $note = $db->real_escape_string($_POST['note']);

  

    if(  in_array($status_id, $note_av_arr) ){
      $db->query("UPDATE `orders` SET `status`= '$status_id', `note` = '$note'  WHERE `id` = '$order_id' ");


        //Order canceled
        if ( $status_id == 12 ) {




            //Send Notification email to Customer
            $cust_template = file_get_contents('../email/order-canceled-user.tpl');

            $op = new Orders();
            $cust_name = $op->order($order_id)['full_name'];
            $email = $op->order($order_id)['email'];
            $artist_id = $op->order($order_id)['artist_id'];

            $email_title = 'Order canceled!';
            $email_content = 'Sorry,  Order ID #' .str_pad($order_id, 5, 0, STR_PAD_LEFT). ' has been canceled';

            $cust_template = str_replace("<!-- #{emailTitle} -->", $email_title, $cust_template);
            $cust_template = str_replace("<!-- #{userFullName} -->", $cust_name, $cust_template);
            $cust_template = str_replace("<!-- #{emailContent} -->", $email_content, $cust_template);
            $cust_template = str_replace("<!-- #{rejectedReason} -->", $note, $cust_template);

            $cust_mail_subject = $email_title;            

            $mail = new Mail();
            $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );





            //Send Notification email to Artist
            $au = new Users();
            $artist_name = $au->user($artist_id)['full_name'];
            $artist_email = $au->user($artist_id)['email'];

            $artist_template = file_get_contents('../email/order-canceled-user.tpl');

            $email_title = 'Order canceled!';
            $email_content = 'Sorry,  Order ID #' .str_pad($order_id, 5, 0, STR_PAD_LEFT). ' has been canceled';

            $artist_template = str_replace("<!-- #{emailTitle} -->", $email_title, $artist_template);
            $artist_template = str_replace("<!-- #{userFullName} -->", $artist_name, $artist_template);
            $artist_template = str_replace("<!-- #{emailContent} -->", $email_content, $artist_template);
            $artist_template = str_replace("<!-- #{rejectedReason} -->", $note, $artist_template);

            $artist_mail_subject = $email_title;            

            $mail = new Mail();
            $mail->send($artist_name, $artist_email, $artist_mail_subject, $artist_template );




            //update product quantity - product table
            $op = new Orders();
            $items = $op->order_products($order_id)['items'];

            foreach ($items as $item) {

                $op_id = $item['id'];
                $product_id = $item['product_id'];
                $quantity = $item['quantity'];
                $op_status = $item['status'];

                $pr = new Products();
                $product_qty = $pr->product($product_id)['quantity'];

                $update_qty = $product_qty + $quantity;

                $db->query("UPDATE `products` SET `quantity`='$update_qty' WHERE `id`='$product_id'");

            }
        }

    }else{
        $db->query("UPDATE `orders` SET `status`= '$status_id' WHERE `id` = '$order_id' ");
    }


    header('location:orders');

}



if ( isset($_GET['id'])) {
    $get_id = $_GET['id'];

    $page_title = 'Manage Order #'.$get_id;

    $save_btn = '<button type="submit" name="update" class="btn btn-primary">SAVE</a>';
    $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

    $od = new Orders();
    $status_id = $od->order($get_id)['status'];

    $status_list = '';
    $query = $db->query("SELECT * FROM `order_status`");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){
            $id = $row['id'];
            $type = $row['type'];

            $status_selected = ( $id == $status_id ) ? 'selected' : '';

            $status_list .= '<option value="'.$id.'" '.$status_selected.'>'.$type.'</option>';
        }
    }



    if(  in_array($status_id, $note_av_arr) ){
        $note_area_style = 'style="display:block;"';
    }

    /* Product detatils*/
    /*
    $op = new Orders();
    $items = $op->order_products($get_id)['items'];

    
    $list = '';
    foreach ($items as $item) {

    $no++;
    $id = $item['id'];
    
    $product_id = $item['product_id'];
    $image_backend = $item['image_backend'];
    $title = $item['title'];
    $price_label = $item['price_label'];
    $quantity = $item['quantity'];
    $total_label = $item['total_label'];
    $a_status = $item['status'];



    if ( $status_id > 1 ) {

      if ( $a_status == 1 ) {
        $a_status = "Artist approved";
        $a_status_label = "success";
      }
      else{
        $a_status = "Artist rejected";
        $a_status_label = "danger";
      }

    }else{

      $a_status = "Awaiting artist approval";
      $a_status_label = "warning";

    }
      
   
    $list .= <<<EOD
    <tr>
      <td>$product_id</</td>
      <td style="width: 10%;"><img src=$image_backend></td>
      <td>$title</td>
      <td>$price_label</td>
      <td>$quantity</td>
      <td>$total_label</td>
      <td class="text-center"><span class="badge badge-$a_status_label">$a_status</span></td>

      <td class="text-right">
          <a class="btn btn-info btn-xs" href="order?id=$id">
        <i class="fa fa-edit"></i>
      </a>
      
    </td>

    </tr>
    EOD;

    }*/


}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>
</head>
<body class="hold-transition skin-info fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <?php include 'include/header.php'; ?>
  
  <!-- Left side column. contains the logo and sidebar -->
  <?php include 'include/sidebar.php'; ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="page-title"><?php echo $page_title; ?></h3>
            </div>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-6 ml-auto mr-auto">
          <div class="box">
            <form method="POST" id="form-category">
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Order Status</label>
                      <select class="form-control" name="status_id" id="status">
                        <?php echo $status_list; ?>
                      </select>                    
                    </div>
                    <div class="form-group" id="note-area" <?php echo $note_area_style; ?> >
                     <textarea class="form-control" rows="6" name="note" placeholder="Enter something here..."></textarea>
                    </div>
                  </div>
                  <div class="col-md-12">                
                    <?php echo $temp_input; ?>
                    <?php echo $save_btn; ?>
                  </div>
                </div>

<!--

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <div class="form-group">
                        <label>Product Status</label>
                        <select class="form-control" name="status_id">
                          <?php echo $p_status_list; ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">                
                    <?php echo $temp_input; ?>
                    <?php echo $save_btn; ?>
                  </div>
                </div>
-->

              </div>
              
            <!-- /.box-body -->
            </form>
          </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'include/footer.php'; ?>    

</div>
<!-- ./wrapper -->


    <?php include 'include/script.php'; ?>
    <script type="text/javascript"></script>

  <script>
    
    $(document).ready(function(){

      $('#status').on('change', function(e){
        e.preventDefault();

        var id = $(this).val();
        $('#note-area').hide();

        if( id == 11 || id == 12){
          $('#note-area').show();
        }


      });

    });

  </script>
</body>
</html>
