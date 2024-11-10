<?php
require 'config.php';


$list = '';


if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $page_title = 'Payments: ORDER #'.$id;

    $od = new Orders();
    $payments = $od->order_payments($id);

    foreach ($payments as $payment) {
      $no++;
      $payment_id = $payment['id'];
      $user_id = $payment['user_id'];
      $amount = $payment['amount'];
      $payment_date = $payment['payment_date'];
      $created = date('Y-m-d h:i A',strtotime($payment['created']));
      $status = $payment['status'];
      $amount = $payment['amount'];


      if ( $status == 1 ) {
      $status = "Confirmed";
      $status_label = "success";
      
      }else if( $status == 2 ) {
      $status = "Rejected";
      $status_label = "danger";
      
      }else  {
      $status = "Pending Approve";
      $status_label = "warning";   
      }

      $ou = new Users();
      $full_name = $ou->user($user_id)['full_name'];

      $no = str_pad($no, 3,0,STR_PAD_LEFT);


      $list .= <<<EOD
      <tr>
        <td>$no</</td>
        <td>$full_name</td>
        <td class="text-center">$created</td>
        <td class="text-center"><span class="badge badge-$status_label">$status</span></td>
        <td class="text-right">
         <a class="btn btn-info btn-xs" href="payment-view?id=$payment_id">
            <i class="fa fa-search"></i>
          </a>
        </td>
      </tr>
      EOD;


    }

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

      <!-- Default box -->
      <div class="box">
        <div class="box-body">
          
        	<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<th>#</th>
						<th>Client Name</th>
						<th class="text-center">Created</th>
						<th class="text-center">Status</th>
						<th class="text-center">Actions</th>
					</tr>
					<?php echo $list; ?>
				</table>
			</div>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'include/footer.php'; ?>
     

</div>
<!-- ./wrapper -->


	<?php include 'include/script.php'; ?>
<!--
	<script>
    $(document).ready(function () {
        $('.switch-product').on('change', function () {
            var id = $(this).data('id');
            var this_label = '#status-'+id;
            $.ajax({
                url: 'ajax/ajax-product.php',
                type: 'POST',
                data: 'type=product_status&id=' + id,
                success: function (data) {

                	$(this_label).html('<span class="label label-'+data.label+'">'+data.type+'</span>');

                    $.toast({
                        heading: 'Status Changed!',
                        text: 'Product status changed!',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
        });

    });
	</script>
-->
</body>
</html>
