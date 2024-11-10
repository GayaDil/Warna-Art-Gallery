<?php
require_once 'config.php';

if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $od = new Orders();
    $artist_id = $od->order($id)['artist_id'];
    $full_name = $od->order($id)['full_name'];
    $customer_id = $od->order($id)['user_id'];
    $email = $od->order($id)['email'];
    $phone = $od->order($id)['phone'];
    $note = $od->order($id)['note'];
    $address_l1 = $od->order($id)['address_1'];

    $town = $od->order($id)['town'];
    $state = $od->order($id)['state'];
    $postcode = $od->order($id)['postcode'];
    $country_id = $od->order($id)['country_id'];
    $status = $od->order($id)['status'];



    // Get All status ids in to array
    $all_order_statuses_arr = array();


    $aos = new Orders();
    $order_statuses =  $aos->order_progress($id);

    foreach ( $order_statuses as $order_status ) {
        array_push($all_order_statuses_arr, $order_status['status']);
    }

    /* //status allow array
    $status_notallow_arr = array(6,13);*/

    //check if status id 6 avaible
    if ( in_array(6, $all_order_statuses_arr) ) {   
        $status = 7;
    }




    $created = date('d-F-Y h:i A', strtotime($od->order($id)['created']));

    $country = new Users();
    $country_name = $country->country($country_id)['name'];

    $address = $od->order($id)['address_1'].'<br>'.$od->order($id)['address_2'].'<br>'.$od->order($id)['town'].'<br>'.$od->order($id)['state'].'<br>'.$od->order($id)['postcode'].'<br>'.$country_name;

    /*$op = new Orders();
    $items = $op->order_products($id)['items'];
    $total = $op->order_products($id)['general']['total_label'];*/

    $op = new Orders();
    $items = $op->order_products($id)['items'];
    $sub_total = $op->order_products($id)['general']['sub_total_label'];
    $order_total = $op->order_products($id)['general']['total'];
    $total = $op->order_products($id)['general']['total_label'];
    $rejected_total = $op->order_products($id)['general']['rejected_total'];
    $rejected_total_label = $op->order_products($id)['general']['rejected_total_label'];


    $oa = new Users();
    $a_full_name = $oa->user($artist_id)['full_name'];
    $a_image = $oa->user($artist_id)['image_front'];

    $os = new Orders();
    $status_type = $os->order_status($status)['type'];
    $status_label = $os->order_status($status)['label'];
}

$page_title = "Order -" ."$id";

/* Product detatils*/
$list = '';
foreach ($items as $item) {

$op_id = $item['id'];

$product_id = $item['product_id'];
$image = $item['image'];
$title = $item['title'];
$price_label = $item['price_label'];
$quantity = $item['quantity'];
$total_label = $item['total_label'];
$op_status = $item['status'];
  

if ( $status > 1 ) {   

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
    <td class="vertical-middle">$product_id</</td>
    <td class="vertical-middle" style="width: 10%;"><img src=$image></td>
    <td class="vertical-middle">$title</td>
    <td class="vertical-middle">$price_label</td>
    <td class="vertical-middle">$quantity</td>
    <td class="vertical-middle">$total_label</td>
    <td class="text-center vertical-middle"><span class="badge badge-$op_status_label">$op_status</span></td>
  
    <td class="text-right vertical-middle">
        <a class="btn btn-outline btn-info btn-xs simple-ajax-modal " href="order-product-status-view?id=$op_id">
        <i class="fa fa-search"></i>
        </a>
    </td>
  </tr>
  EOD;
}


$paid_amount = 0;
$query = $db->query("SELECT SUM(amount) AS tot FROM `payments` WHERE `order_id` = '$id' AND `status` = 1");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
        $paid_amount = $row['tot'];

    }
}


$balance_payment = $order_total - $paid_amount;


//Payment submit button allowed status ids
$payment_submit_arr = array(2,9,11);



if ( $customer_id != $this_user_id ) {
    header('location:./');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'include/head.php'; ?>
</head>
<body class="hold-transition skin-info fixed dark">
    <!-- Site wrapper -->
    <div class="wrapper frontend">
        <?php include 'include/header.php'; ?>
        <!-- Content Wrapper. Contains page content -->

        <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="d-flex align-items-center">
                <div class="mr-auto">
                    <h1 class="page-title"><a href="artists">Warna Gallery</a></h1>
                </div>
                <div class="right-title">
                    <a href="orders" class="btn btn-outline btn-primary">All Orders</a>
                    <a href="order-inquiry?id=<?php echo $id; ?>" class="btn btn-outline btn-primary ml-10">Inquiry</a>
                </div>
            </div>
        </div> 

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-4">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Order Details</h4>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <td>Order ID</td>
                                        <td><?php echo $id; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td><span class="badge badge-<?php echo $status_label; ?>"><?php echo $status_type; ?></span></td>
                                    </tr>
                                    <tr>
                                        <td>Order Time</td>
                                        <td><?php echo $created; ?></b></td>
                                    </tr>
                                    <tr>
                                        <td>Customer Name</td>
                                        <td><b><?php echo $full_name; ?></b></td>
                                    </tr>

                                    <?php if ( isset( $email ) ) :?>
                                    <tr>
                                        <td>Email</td>
                                        <td><b><?php echo $email; ?></b></td>
                                    </tr>
                                    <?php endif;?>

                                    <?php if ( isset( $phone ) ) :?>
                                    <tr>
                                        <td>Contact</td>
                                        <td><b><?php echo $phone; ?></b></td>
                                    </tr>
                                    <?php endif;?>

                                    
                                    <tr>
                                        <td>Billing Address</td>
                                        <td><b><?php echo $address; ?></b></td>
                                    </tr>
                                 

                                    <tr>
                                        <td>Payment method</td>
                                        <td><b>Bank Transfer</b></td>
                                    </tr>

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
                <div class="col-md-8">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Order Products</h4>
                            <?php if ( $balance_payment > 0 && in_array($status, $payment_submit_arr) ) :?>
                            <a class="btn btn-primary btn-sm pull-right" href="payment-submit?id=<?php echo $id; ?>"><span>Submit your payment</span></a>
                            <?php endif;?>

                            <?php if ( $status == 5 ) :?>
                            <a class="btn btn-primary btn-sm pull-right mark-as-order-received" href="javascript:void(0);" data-id="<?php echo $id; ?>"><span> Mark as order received</span></a>
                            <?php endif;?>
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
                                </table>
                            </div>

                            <div class="row mt-20">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>   
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
                                                    <td class="text-right text-primary"><strong><span class="amount">Rs. <?php echo number_format($balance_payment, 2); ?></span></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                                    
                        </div>
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
