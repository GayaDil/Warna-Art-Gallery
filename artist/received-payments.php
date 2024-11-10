<?php
require 'config.php';

$page_title = 'Received Payments';

$list = '';

$ap = new ArtistPayments();
$artist_payments = $ap->all_payments($this_user_id);



$no = 0;
foreach ($artist_payments as $artist_payment) {

  $no++;
  $order_id = $artist_payment['order_id'];
  $created = $artist_payment['created'];
  $amount = $artist_payment['total_paid'];

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
  <td class="text-center">$order_id</</td>
  <td class="text-center">$created</td>
  <td class="text-right">$amount_label</td>
  <td class="text-right">
   <a class="btn btn-info btn-xs" href="payment-view?id=$order_id">
      <i class="fa fa-search"></i>
    </a>
     
  </td>
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
            <th class="text-center">Order ID </th>
            <th class="text-center">Created</th>
            <th class="text-center">Total</th>
            <th class="text-right">Actions</th>
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
