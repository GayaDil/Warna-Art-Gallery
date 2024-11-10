<?php
require 'config.php';

if ( isset($_GET['id'])) {

  $get_id = $_GET['id'];
  $page_title = 'Manage Order #'.$get_id;
  $op = new Orders();
  $items = $op->order_products($get_id)['items'];


  $od = new Orders();
  $order_status = $od->order($get_id)['status'];
  $artist_id = $od->order($get_id)['artist_id'];


  //status allow array
  $allow_arr = array(1);

  if ( !in_array($order_status, $allow_arr) ) {
      header('location:./');
  }


}


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
    <div class="d-flex align-items-center">
      <div class="mr-auto">
        <h3 class="page-title"><?php echo $page_title; ?></h3>
      </div>
    </div>
  </div>

    <!-- Main content -->
    <section class="content">

      <?php if ( $order_status == 1 ) : ?>
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-body">
              <h3 class="box-title">
                Awaiting Approval
                <span class="btn btn-sm btn-success pull-right step_2_approve" data-id="<?php echo $get_id; ?>"><b><i class="mdi mdi-check"></i> APPROVE</b></span>
                <span class="btn btn-sm btn-danger pull-right mr-10 step_2_reject" data-id="<?php echo $get_id; ?>"><b><i class="mdi mdi-window-close"></i> REJECT</b></span>
              </h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <h4 class="box-title">Order Products</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Actions</th>
                      </tr>
                      <?php foreach ($items as $item) : ?>
                      <tr>
                        <td><?php echo $item['product_id']; ?></td>
                        <td style="width: 10%;"><img src="<?php echo $item['image_backend']; ?>"></td>
                        <td><?php echo $item['title']; ?></td>
                        <td><?php echo $item['price_label']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td><?php echo $item['total_label']; ?></td>
                        <td>
                          <label class="switch switch-border switch-success">
                              <input class="switch-op-status" data-id="<?php echo $item['id']; ?>" type="checkbox" <?php echo ( $item['status'] == 1 ) ? 'checked' : ''; ?> >
                              <span class="switch-indicator"></span>
                              <span class="switch-description"></span>
                          </label>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>              
          </div>
        </div>
      </div>
      <?php endif; ?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'include/footer.php'; ?>    

</div>
<!-- ./wrapper -->


  <?php include 'include/script.php'; ?>

  <script>
    $(document).ready(function () {
        $('.switch-op-status').on('change', function () {
            var id = $(this).data('id');
            $.ajax({
                url: 'ajax/ajax-orders.php',
                type: 'POST',
                data: 'type=order_product_status&id=' + id,
                success: function (data) {
                    $.toast({
                        heading: 'Changed!',
                        text: 'Ordered Product status changed!',
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
  

</body>
</html>
