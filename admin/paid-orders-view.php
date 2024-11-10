<?php
require 'config.php';


if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $page_title = 'ORDER #'.$id;

    /*--order--*/

    $od = new Orders();
    $artist_id = $od->order($id)['artist_id'];
    $customer_id = $od->order($id)['user_id'];
    $full_name = $od->order($id)['full_name'];
    $email = $od->order($id)['email'];
    $phone = $od->order($id)['phone'];

    $town = $od->order($id)['town'];
    $state = $od->order($id)['state'];
    $postcode = $od->order($id)['postcode'];
    $country_id = $od->order($id)['country_id'];
    $note = $od->order($id)['note'];
    $payment_method = $od->order($id)['payment_method'];
    $status_id = $od->order($id)['status'];
    $created = date('d-F-Y h:i A', strtotime($od->order($id)['created']));

    $countr = new Users();
    $country_name = $countr->country($country_id)['name'];

    $address = $od->order($id)['address_1'].'<br>'.$od->order($id)['address_2'].'<br>'.$od->order($id)['town'].'<br>'.$od->order($id)['state'].'<br>'.$od->order($id)['postcode'].'<br>'.$country_name;

    /*--orderproducts--*/
    
    $op = new Orders();
    $items = $op->order_products($id)['items'];
    $total = $op->order_products($id)['general']['total_label'];

    $oa = new Users();
    $a_full_name = $oa->user($artist_id)['full_name'];
    $a_email = $oa->user($artist_id)['email'];
    $a_phone = $oa->user($artist_id)['phone'];

    $os = new Orders();
    $status = $os->order_status($status_id)['type'];
    $status_label = $os->order_status($status_id)['label'];

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
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <h3 class="box-title">
                            Awaiting Order Dispatch
                            <span class="btn btn-sm btn-success pull-right step_5_approve" data-id="<?php echo $id; ?>"><b><i class="mdi mdi-check"></i> DISPATCHED</b></span>
                            <span class="btn btn-sm btn-danger pull-right mr-10 step_5_reject" data-id="<?php echo $id; ?>"><b><i class="mdi mdi-window-close"></i> CANCEL</b></span>
                        </h3>
                    </div>            
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="box">       
                    <div class="box-header with-border">
                        <h4 class="box-title">Order Details</h4>
                    </div>
                    <div class="box-body">
                        <div class="progress progress-sm active">
                            <div class="progress-bar progress-bar-danger progress-bar-striped" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                <span class="sr-only">80% Complete</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                  <td>Status</td>
                                  <td><span class="badge badge-<?php echo $status_label; ?>"><?php echo $status; ?></span></td>
                                </tr>

                                <tr>
                                  <td>Order Time</td>
                                  <td><?php echo $created; ?></b></td>
                                </tr>

                                <tr>
                                  <td>Artist Name</td>
                                  <td><b><a href="user-view?id=<?php echo $artist_id; ?>" ><?php echo $a_full_name; ?></a></b></td>
                                </tr>

                                <tr>
                                  <td>Customer Name</td>
                                  <td><b><a href="user-view?id=<?php echo $customer_id; ?>" ><?php echo $full_name; ?></a></b></td>
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
                       


                                <?php if ( isset( $note ) ) :?>
                                <tr>
                                    <td>Note</td>
                                    <td><b><?php echo $note; ?></b></td>
                                </tr>
                                <?php endif;?>
                                
                                <tr>
                                    <td>Payment method</td>
                                    <td><b>Bank Transfer</b></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box">      
                    <div class="box-body">
                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control" rows="6" name="note" id="note" placeholder="Enter note here.."></textarea>
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
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                                <?php foreach ($items as $item) : ?>
                                <tr>
                                    <td><?php echo $item['product_id']; ?></td>
                                    <td style="width: 10%;"><a href="../product?id=<?php echo $item['product_id']; ?>"><img title="<?php echo $item['image_name']; ?>" src="<?php echo $item['image_backend']; ?>"></a></td>
                                    <td><?php echo $item['title']; ?></td>
                                    <td><?php echo $item['price_label']; ?></td>
                                    <td><?php echo $item['quantity']; ?></td>
                                    <td><?php echo $item['total_label']; ?></td>
                                </tr>
                                <?php endforeach; ?>
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
