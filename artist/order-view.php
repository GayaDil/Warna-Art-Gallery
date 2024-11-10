<?php
require 'config.php';



if ( isset($_GET['id'])) {
  $id = $_GET['id'];

  $page_title = 'ORDER #'.$id;

  $od = new Orders();
  $artist_id = $od->order($id)['artist_id'];
  $full_name = $od->order($id)['full_name'];
  $email = $od->order($id)['email'];
  $phone = $od->order($id)['phone'];
  $note = $od->order($id)['note'];
  $address_l1 = $od->order($id)['address_1'];

  $town = $od->order($id)['town'];
  $state = $od->order($id)['state'];
  $postcode = $od->order($id)['postcode'];
  $country_id = $od->order($id)['country_id'];
  
  $status_id = $od->order($id)['status'];
  $created = date('d-F-Y h:i A', strtotime($od->order($id)['created']));

  $countr = new Users();
  $country_name = $countr->country($country_id)['name'];

  $address = $od->order($id)['address_1'].'<br>'.$od->order($id)['address_2'].'<br>'.$od->order($id)['town'].'<br>'.$od->order($id)['state'].'<br>'.$od->order($id)['postcode'].'<br>'.$country_name;




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

  /* Product detatils*/
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
    <td style="width: 10%;"><img src=$image_backend></td>
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



$shipping_accept_arr = array(4,5,6,7);


if ( $artist_id != $this_user_id ) {
    header('location:./');
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
                    <td>Country</td>
                    <td><b><?php echo $country_name; ?></b></td>
                  </tr>
                  <tr>
                    <td>Region</td>
                    <td><b><?php echo $state; ?></b></td>
                  </tr>

                </table>
              </div>
            </div>
          </div>
        </div>

        <?php if ( in_array($status_id, $shipping_accept_arr) ) : ?>
        <div class="col-md-6">
          <div class="box">       
            <div class="box-header with-border">
              <h4 class="box-title">Shipping Details</h4>
            </div>
            <div class="box-body">
              <!-- -->
              <div class="table-responsive">
                <table class="table">
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

                    <?php if ( isset( $address_l1 ) ) :?>
                    <tr>
                        <td>Billing Address</td>
                        <td><b><?php echo $address; ?></b></td>
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
        <?php endif;?>
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
                        <th>Status</th>
                        <?php if ( $status_id > 1 ) :?>
                        <th>Actions</th>
                        <?php endif;?>
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
