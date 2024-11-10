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

  /*$op = new Orders();
  $items = $op->order_products($id)['items'];
  $total = $op->order_products($id)['general']['total_label'];*/

  $op = new Orders();
  $items = $op->order_products($id)['items'];
  $sub_total = $op->order_products($id)['general']['sub_total_label'];
  $total = $op->order_products($id)['general']['total_label'];
  $rejected_total = $op->order_products($id)['general']['rejected_total'];
  $rejected_total_label = $op->order_products($id)['general']['rejected_total_label'];


  $oa = new Users();
  $a_full_name = $oa->user($artist_id)['full_name'];
  $a_email = $oa->user($artist_id)['email'];
  $a_phone = $oa->user($artist_id)['phone'];
  $a_image = $oa->user($artist_id)['image'];

  $os = new Orders();
  $status = $os->order_status($status_id)['type'];
  $status_label = $os->order_status($status_id)['label'];

  }

  /* Product detatils*/
  $list = '';
  foreach ($items as $item) {

  $no++;
  $item_id = $item['id'];
  
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
        <a class="btn btn-info btn-xs simple-ajax-modal " href="order-product-status-view?id=$item_id">
        <i class="fa fa-search"></i>
        </a>
    </td>
  
  
  </tr>
  EOD;

}



$prog = new Orders();
$progresses = $prog->order_progress($id);


$progress_list = '';
foreach( $progresses As $progress ){

  $pg_status = $progress['status_type'];
  $pg_status_label = $progress['status_label'];
  $pg_created = date('d-F-Y h:i A', strtotime($progress['created']));
  $pg_user = $progress['user'];
  $pg_note = $progress['note'];

$progress_list .= <<<EOD
<tr>
    <td class="text-center"><span class="badge badge-$pg_status_label">$pg_status</span></td>
    <td class="text-center">$pg_created</td>
    <td class="text-center">$pg_user</td>
    <td>$pg_note</td>
  </tr>
EOD;
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
                <a href="order-update?id=<?php echo $id; ?>" class="btn btn-primary btn-sm pull-right"><i class="fa fa-pencil"></i> EDIT</a>
                
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
            <div class="box-header with-border">
              <h4 class="box-title">Artist Details</h4>
            </div>
            <div class="box-body">
              <!-- -->
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="row">
                    <div class="col-md-6 mr-auto ml-auto">
                      <img src="<?php echo $a_image; ?>" class="img-fluid" alt="user-image">
                    </div>                    
                  </div>
                  <h4 class="mt-20"><a href="user-view?id=<?php echo $artist_id; ?>"><?php echo $a_full_name; ?></a></h4>
                </div>
              </div>

              <div class="table-responsive mt-20">
                <table class="table">
                  <?php if ( isset( $a_email ) ) :?>
                  <tr>
                    <td>Email</td>
                    <td><b><?php echo $a_email; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_phone ) ) :?>
                  <tr>
                    <td>Contact</td>
                    <td><b><?php echo $a_phone; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_address_1 ) ) :?>
                  <tr>
                    <td>Address 1</td>
                    <td><b><?php echo $a_address_1; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_address_2 ) ) :?>
                  <tr>
                    <td>Address 2</td>
                    <td><b><?php echo $a_address_2; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_town ) ) :?>
                  <tr>
                    <td>Town</td>
                    <td><b><?php echo $a_town; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_state ) ) :?>
                  <tr>
                    <td>State</td>
                    <td><b><?php echo $a_state; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $a_country ) ) :?>
                  <tr>
                    <td>Country</td>
                    <td><b><?php echo $a_country; ?></b></td>
                  </tr>
                  <?php endif;?>

                </table>
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




      <div class="row">
        <div class="col-md-12">
          <div class="box">       
            <div class="box-header with-border">
              <h4 class="box-title">Order Progress</h4>
            </div>
            <div class="box-body">
              <div class="table-responsive">
                <table class="table">
                      <tr>
                        <th class="text-center">Status</th>
                        <th class="text-center">Created</th>
                        <th class="text-center">Created User</th>
                        <th >Note</th>
                      </tr>

                      <?php echo $progress_list; ?>
                      
                      
                      
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
