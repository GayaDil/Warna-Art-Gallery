<?php
require 'config.php';



$list = '';

if ( isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $page_title = 'Payment View: Order ID#'.$order_id;

    $ap = new ArtistPayments();
    $artist_payments = $ap->payments($this_user_id,$order_id);


    $no = 0;
    foreach ($artist_payments as $artist_payment) {

        $no++;
        $payment_id = $artist_payment['id'];
        $created = $artist_payment['created'];
        $amount = $artist_payment['amount'];

        $amount_label = number_format($amount,2);

        //Row Number
        $list_no = $no;
        if ( $pageno > 1 ) {
            $list_no = $offset + $no;
        }

        $list_no = str_pad($list_no, 3,0,STR_PAD_LEFT);

     
        $list .= <<<EOD
        <tr>
          <td>$list_no</</td>
          <td class="text-center">$payment_id</</td>
          <td class="text-center">$created</td>
          <td class="text-right">$amount_label</td>
        </tr>
        EOD;

    }


    //total received amount
    $pa = new ArtistPayments();
    $total_received = $pa->paid_amounts($order_id);

    $total_received_label = number_format($total_received,2);

    //order total
    $op = new Orders();
    $sub_total = $op->order_products($order_id)['general']['sub_total_label'];
    $order_total = $op->order_products($order_id)['general']['total'];
    $order_total_label = $op->order_products($order_id)['general']['total_label'];
    $rejected_total = $op->order_products($order_id)['general']['rejected_total'];
    $rejected_total_label = $op->order_products($order_id)['general']['rejected_total_label'];
    

    //Commission
    $comm = new ArtistPayments();
    $commission = $comm->commission();

    $order_commission = $order_total* $commission/100;

    $payable_amount = $order_total - $order_commission;

    $due_payment = $payable_amount - $total_received;
 

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
                <div class="col-md-12">
                    <!-- Default box -->
                    <div class="box">
                        <div class="box-body">
                          
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Payment ID </th>
                                        <th class="text-center">Created</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                    <?php echo $list; ?>
                                </table>
                            </div>

                            <div>
                                <table class="table">
                                      <tbody class="text-right">   
                                          
                                            <tr >
                                                <th>Total</th>
                                                <td class="text-right"><strong><span class="amount text-danger">Rs. <?php echo $total_received_label; ?></span></strong></td>
                                            </tr>
                                      </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>

                <div class="col-md-6">
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
                                    <th>Order Total</th>
                                    <td class="text-right "><strong><span class="amount">Rs. <?php echo $order_total_label; ?></span></strong></td>
                                </tr>
                                <tr >
                                    <th>Commission <span class="text-primary"><?php echo $commission; ?>%</span></th>
                                    <td class="text-right "><strong><span class="amount"> -<?php echo number_format($order_commission, 2); ?></span></strong></td>
                                </tr>
                                <tr >
                                    <th>Payable Amount</th>
                                    <td class="text-right"><strong><span class="amount">Rs. <?php echo number_format($payable_amount, 2); ?></span></strong></td>
                                </tr>
                                <tr >
                                    <th>Received Amount</th>
                                    <td class="text-right"><strong><span class="amount">Rs. <?php echo $total_received_label; ?></span></strong></td>
                                </tr>
                                <tr >
                                    <th>Due</th>
                                    <td class="text-right text-danger"><strong><span class="amount">Rs. <?php echo number_format($due_payment, 2); ?></span></strong></td>
                                </tr>
                            </tbody>
                        </table>
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


</body>
</html>
