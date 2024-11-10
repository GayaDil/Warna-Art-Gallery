<?php
require 'config.php';


if ( isset($_GET['id'])) {
    $order_id = $_GET['id'];

    /*---------------------------order details from order tb------------------------*/

    $od = new Orders();
    $artist_id = $od->order($order_id)['artist_id'];
    $full_name = $od->order($order_id)['full_name'];
    $customer_id = $od->order($order_id)['user_id'];
    $note = $od->order($order_id)['note'];
    $phone = $od->order($order_id)['phone'];
    $order_created = date('d-F-Y h:i A', strtotime($od->order($order_id)['created']));
    $status_id = $od->order($order_id)['status'];

    $au = new Users();
    $artist_name = $au->user($artist_id)['full_name'];

    $os = new Orders();
    $status = $os->order_status($status_id)['type'];
    $status_label = $os->order_status($status_id)['label'];

    $op = new Orders();
    $items = $op->order_products($order_id)['items'];
    $sub_total = $op->order_products($order_id)['general']['sub_total_label'];
    $order_total = $op->order_products($order_id)['general']['total'];
    $total = $op->order_products($order_id)['general']['total_label'];
    $rejected_total = $op->order_products($order_id)['general']['rejected_total'];
    $rejected_total_label = $op->order_products($order_id)['general']['rejected_total_label'];

    $page_title = 'Artist Payments : ORDER #'.$order_id;



    /*--------------- Product detatils----------*/
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
    $op_status = $item['status'];


    if ( $status_id > 1 ) {   

        if ( $op_status == 1 ) {
        $op_status = "Approved";
        $op_status_label = "success";
        }
        else{
        $op_status = "Rejected";
        $op_status_label = "danger";
        }

    }else{

        $op_status = "Awaiting artist approval";
        $op_status_label = "warning";

    }
    
 
    $list .= <<<EOD
    <tr>
    <td>$product_id</</td>
    <td style="width: 10%;"><a href="../product?id=$product_id"><img src=$image_backend></a></td>
    <td>$title</td>
    <td>$price_label</td>
    <td>$quantity</td>
    <td>$total_label</td>
    <td class="text-center"><span class="badge badge-$op_status_label">$op_status</span></td>

    <td class="text-right">
        <a class="btn btn-info btn-xs simple-ajax-modal " href="order-product-status-view?id=$id">
        <i class="fa fa-search"></i>
        </a>
    </td> 
  </tr>
  EOD;
}







$payment_list = '';
$order_totals = 0;
$query = $db->query("SELECT * FROM `orders` WHERE `status` IN (6,13) AND `artist_id` = '$artist_id' ");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
        $orders_id = $row['id'];
        $orders_status = $row['status'];

        $op = new Orders();
        $order_tot = $op->order_products($orders_id)['general']['total'];
        $order_tot_lable = number_format($order_tot,2);

        // Artist Payments

        $artist_paid = 0;
      
            if ( $orders_status == 13 ) {

                $ap = new ArtistPayments();
                $artist_paid = $ap->paid_amounts($orders_id);

            }


        


        $order_due = $order_tot - $artist_paid;
        $order_due_label = number_format($order_due, 2);
        $order_paid_label = ( $artist_paid > 0 ) ? number_format(-$artist_paid, 2) : number_format($artist_paid, 2);


        $payment_list .= <<<EOD
    <tr>
    <td class="text-center">$orders_id</</td>
    <td class="text-right">$order_tot_lable</td>
    <td class="text-right">$order_paid_label</td>
    <td class="text-right text-danger">$order_due_label</td>
  </tr>
  EOD;

        $order_totals = $order_totals + $order_tot - $artist_paid;


    }
}



/*$or = new Orders();
$orders = $or->artist_pending_payments($artist_id, 1)['list'];
$total_pages = $or->artist_pending_payments($artist_id, 1)['total_pages'];

$order_totals = 0;
foreach ($orders as $order) {

    $order_ids = $order['id'];

    $op = new Orders();
    $order_totals = $op->order_products($order_ids)['general']['total'];

    $order_totals = $order_totals + $order_totals;

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
            <div class="row">
                <!--<div class="d-flex align-items-center"> -->         
                <div class="col-md-6 mr-auto">
                    <h3 class="page-title"><?php echo $page_title; ?></h3>
                </div>      
                <!--</div> -->
            </div>
        </div>

        <!-- Main content -->
        <section class="content">



            <div class="row">

                <div class="col-md-6">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Order Details</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table">
    
                                    <?php if ( isset( $artist_name ) ) :?>
                                    <tr>
                                        <td>Artist Name</td>
                                        <td><b><a href="user-view?id=<?php echo $artist_id; ?>" ><?php echo $artist_name; ?></a></b></td>
                                    </tr>
                                    <?php endif;?>


                                    <tr >
                                        <th>Payable Amount Of The Order</th>
                                        <td ><strong><span class="amount">Rs. <?php echo number_format($order_total,2); ?></span></strong></td>
                                    </tr>

                                    <?php if ( isset( $order_id ) ) :?>
                                    <tr>
                                        <td>Order ID</td>
                                        <td><b><?php echo $order_id; ?></b></td>
                                    </tr>
                                    <?php endif;?>

                                    <?php if ( isset( $status ) ) :?>
                                    <tr>
                                        <td>Status</td>
                                        <td><span class="badge badge-<?php echo $status_label; ?>"><?php echo $status; ?></span></td>
                                    </tr>
                                    <?php endif;?>


                                    <?php if ( isset( $order_created ) ) :?>
                                    <tr>
                                        <td>Order Created</td>
                                        <td><b><?php echo $order_created; ?></b></td>
                                    </tr>
                                    <?php endif;?>

                                    <?php if ( isset( $full_name ) ) :?>
                                    <tr>
                                        <td>Client Name</td>
                                        <td><b><a href="user-view?id=<?php echo $customer_id; ?>" ><?php echo $full_name; ?></a></b></td>
                                    </tr>
                                    <?php endif;?>

                                    <?php if ( isset( $note ) ) :?>
                                    <tr>
                                        <td>Note</td>
                                        <td><b><?php echo $note; ?></b></td>
                                    </tr>
                                <?php endif;?>
             
                              </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Payment Details</h4>                           
                        </div>
                        <div class="box-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Paid Amount</th>
                                        <th class="text-right">Payable Amount</th>
                                    </tr>
                                    <?php echo $payment_list; ?>                              
                              </table>
                            </div>

                            <?php if ( isset( $order_totals ) ) :?>  
                                <h5>Total payable amount for artist: <span class="pull-right text-danger"><b>Rs. <?php echo number_format($order_totals,2); ?></span></h5>  
                            <?php endif;?>
                        </div>
                    </div>
                    
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Payments</h4>
                        </div>
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control" id="artist-payment-subject">
                                            <option value="">-------------- Subject --------------</option>
                                            <option value="13">Hold and Pay</option>
                                            <option value="7">Full Amount</option>                                    
                                        </select>
                                    </div>
                                    
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control text-right"  id="artist-payment-amount" placeholder="enter amount...."></input>
                                    </div>
                                </div>

                                <div class="col-md-12">

                                    <div class="form-group">
                                        <textarea class="form-control" rows="4" id="artist-payment-note" placeholder="Enter note here...."></textarea>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12">

                                    <div class="form-group">
                                        <a href="javascript:void(0);" class="btn btn-outline btn-primary pull-right" id="artist-payment-step-7" data-id="<?php echo $order_id; ?>" data-artist-id="<?php echo $artist_id; ?>">Submit</a>
                                    </div>
                                    
                                </div>
                            </div>  
                            
                            
                            
                            
                        </div>
                    </div>

                    

                </div>

            </div>

            <div class="row">
                <div class="col-md-12">
                  <div class="box">       
                    <div class="box-header with-border">
                      <h4 class="box-title">Order Products</h4>
                    </div>
                    <div class="box-body">
                      <div class="table-responsive">
                        <table class="table">
                              <tr>
                                <th>Product ID</th>
                                <th>Image</th>
                                <th>Product Name</th>
                                <th>Unit</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Actions</th>
                              </tr>

                              <?php echo $list; ?>
                              
                              <!--
                              <?php foreach ($items as $item) : ?>
                              <tr>
                                <td><?php echo $item['product_id']; ?></td>
                                <td style="width: 10%;"><img src="<?php echo $item['image_backend']; ?>"></td>
                                <td><?php echo $item['title']; ?></td>
                                <td><?php echo $item['price_label']; ?></td>
                                <td><?php echo $item['quantity']; ?></td>
                                <td><?php echo $item['total_label']; ?></td>
                                <td class="text-center" id="status-<?php echo $item['id']; ?>"><span class="label label-<?php echo $item['$status_label']; ?>"><?php echo $item['status_type']; ?></span></td>

                              <?php endforeach; ?>
                            -->
                        </table>
                      </div>
                      <div>
                        <table class="table">
                              <tbody class="text-right">   
                                  <tr >
                                      <th>Sub Subtotal</th>
                                      <td class="text-right"><span class="amount">Rs. <?php echo $sub_total; ?></span></td>
                                  </tr>
                                  <?php if ( $rejected_total > 0 ) :?>
                                  <tr >
                                      <th>Reject Items</th>
                                      <td class="text-right"><span class="amount">Rs. <?php echo $rejected_total_label; ?></span></td>
                                  </tr>
                                  <?php endif;?>
                                  <tr >
                                      <th>Total</th>
                                      <td class="text-right"><strong><span class="amount">Rs. <?php echo $total; ?></span></strong></td>
                                  </tr>
                              </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
 
    

</div>
<!-- ./wrapper -->


    <?php include 'include/script.php'; ?>
    

</body>
</html>
