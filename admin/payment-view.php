<?php
require 'config.php';


if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    /*---------------------------payment details from order tb------------------------*/

    $query = $db->query("SELECT * FROM `payments` WHERE `id` = '$id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){
            $order_id = $row['order_id'];
            $user_id = $row['user_id'];
            $payment_image_name = $row['image'];
            $amount = $row['amount'];
            $payment_date = $row['payment_date'];
            $description = $row['description'];
            $payment_created = date('d-F-Y h:i A', strtotime($row['created']));
            $payment_status = $row['status'];
            $status_user_id = $row['status_user_id'];
            $status_time = $row['status_time'];

            $amount = number_format($amount,2);

            $payment_image = '../assets/images/payment_submissions/'.$payment_image_name.'';

            if ( $payment_status == 1 ) {
                $payment_status_txt = "Confirmed";
                $payment_status_label = "success";
          
            }elseif( $payment_status == 2 ) {
                $payment_status_txt = "Rejected";
                $payment_status_label = "danger";
          
            }else  {
            $payment_status_txt = "Pending Approve";
            $payment_status_label = "warning";   
            }
        }
    } 

    /*---------------------------order details from order tb------------------------*/

    $od = new Orders();
    $artist_id = $od->order($order_id)['artist_id'];
    $full_name = $od->order($order_id)['full_name'];
    $customer_id = $od->order($order_id)['user_id'];
    $note = $od->order($order_id)['note'];
    $phone = $od->order($order_id)['phone'];
    $order_created = date('d-F-Y h:i A', strtotime($od->order($order_id)['created']));
    $status_id = $od->order($order_id)['status'];

    $os = new Orders();
    $status = $os->order_status($status_id)['type'];
    $status_label = $os->order_status($status_id)['label'];

    $op = new Orders();
    $sub_total = $op->order_products($order_id)['general']['sub_total_label'];
    $order_total = $op->order_products($order_id)['general']['total'];
    $total = $op->order_products($order_id)['general']['total_label'];
    $rejected_total = $op->order_products($order_id)['general']['rejected_total'];
    $rejected_total_label = $op->order_products($order_id)['general']['rejected_total_label'];

    $order_total_label = number_format($order_total,2);


    $page_title = 'Payments Approve: ORDER #'.$order_id;


    $paid_amount = 0;
    $query = $db->query("SELECT SUM(amount) AS tot FROM `payments` WHERE `order_id` = '$order_id' AND `status` != 2 ");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){
            $paid_amount = $row['tot'];

        }
    }


    $balance_payment = $order_total - $paid_amount;



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

            <?php if ( isset( $payment_image_name ) ): ?>

            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <div class="box-body">
                            


                            <?php if( $payment_status == 0 ): ?>
                            <h3 class="box-title">
                                Awaiting Order Payment Approval
                                <span class="btn btn-sm btn-success pull-right step_4_approve"  data-id="<?php echo $id; ?>" data-order-id="<?php echo $order_id; ?>" ><b><i class="mdi mdi-check"></i> APPROVE</b></span>
                                <span class="btn btn-sm btn-danger pull-right mr-10 step_4_reject"  data-id="<?php echo $id; ?>" data-order-id="<?php echo $order_id; ?>" ><b><i class="mdi mdi-window-close"></i> REJECT</b></span>
                            </h3>
                            <?php endif; ?>


                            <div class="">
                                <?php if ( $payment_status == 0 ) : ?>
                                <span class="badge badge-warning "><i class="mdi mdi-verified"></i>Not Verified</span>
                                <?php endif; ?>

                                <?php if( $payment_status == 1 ): ?>
                                    <span class="badge badge-success pull-right"><i class="mdi mdi-verified"></i> Verified</span>      
                                <?php endif; ?>

                                <?php if( $payment_status == 2 ): ?>
                                    <span class="badge badge-danger pull-right"><i class="mdi mdi-verified"></i> Rejectd</span>      
                                <?php endif; ?> 
                            </div>

                            <div class="box-body">
                                <div class="row">

                                    <div class="col-md-8">
                                        <img src="<?php echo $payment_image; ?>" class="img-fluid" >
                                    </div>

                                    <?php if( $payment_status == 0 ): ?>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="note">Note</label>
                                            <textarea class="form-control" rows="6" name="note" id="note" placeholder="Enter note here.."></textarea>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                </div>
                            </div>
                        </div>            
                    </div>
                </div>
            </div>

            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                <div class="box">       
                    <div class="box-header with-border">
                        <h4 class="box-title">Payment Details</h4>
                        <a href="modal-order-payment-edit?id=<?php echo $id; ?>" class="btn btn-primary btn-sm pull-right simple-ajax-modal"><i class="mdi mdi-pencil"></i> EDIT</a>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">

                            <?php if ( isset( $payment_status ) ) :?>
                            <tr>
                              <td>Status</td>
                              <td><span class="badge badge-<?php echo $payment_status_label; ?>"><?php echo $payment_status_txt; ?></span></td>
                            </tr>
                            <?php endif;?>

                            <?php if ( isset( $amount ) ) :?>
                            <tr>
                              <td>Amout Paid</td>
                              <td><b>Rs. <?php echo $amount; ?></b></td>
                            </tr>
                            <?php endif;?>

                            <?php if ( isset( $payment_date ) ) :?>
                            <tr>
                              <td>Payment Date</td>
                              <td><b><?php echo $payment_date; ?></b></td>
                            </tr>
                            <?php endif;?>

                            <?php if ( isset( $description ) ) :?>
                            <tr>
                              <td>Note</td>
                              <td><b><?php echo $description; ?></b></td>
                            </tr>
                            <?php endif;?>

                            <?php if ( isset( $payment_created ) ) :?>
                            <tr>
                              <td>Created Date</td>
                              <td><b><?php echo $payment_created; ?></b></td>
                            </tr>
                            <?php endif;?>
         
                          </table>
                        </div>
                    </div>
                </div>

                <div class="box">
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
                                <td class="text-right text-primary"><strong><span class="amount">Rs. <?php echo $total; ?></span></strong></td>
                            </tr>
                            <tr >
                                <th>Paid Amount</th>
                                <td class="text-right"><strong><span class="amount">Rs. <?php echo number_format(-$paid_amount, 2); ?></span></strong></td>
                            </tr>
                            <tr >
                                <th>Due</th>
                                <td class="text-right text-danger"><strong><span class="amount">Rs. <?php echo number_format($balance_payment, 2); ?></span></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                </div>

                <div class="col-md-6">
                <div class="box">       
                    <div class="box-header with-border">
                        <h4 class="box-title">Order Details</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                

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

                                <tr >
                                    <th>Total</th>
                                    <td ><strong><span class="amount">Rs. <?php echo $order_total_label; ?></span></strong></td>
                                </tr>

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
