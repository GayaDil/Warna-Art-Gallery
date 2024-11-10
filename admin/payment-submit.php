<?php
require 'config.php';




if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$page_title =  "Payment Submit";

if ( isset($_GET['id'])) {
    $get_id = $_GET['id'];

    $temp_input = '';
    $save_btn = '<a href="javascript:void(0);" class="btn btn-outline btn-info pull-right add-payment-admin">SAVE</a>';
    $img_upload_url = 'modal-payment-image-upload.php';
    $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

}

$od = new Orders();
$customer_id = $od->order($get_id)['user_id'];





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
                  <div class="col-md-5 ml-auto mr-auto">
                        <div class="box">
                            <form method="POST" id="form-payment">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="row">
                                        <div class="col-md-12 text-center"> 
                                            <h2 class="mb-20">Submit Order Payment</h2>            
                                            <p>Upload Scanned copy of the bank slip confirming that you have paid the required amount.</p>
                                            <span class="text-primary text-left font-size-12">*Please ensure that your name, Order ID and contact no is mentioned in the bank slip</span>
                                        </div>
                                        <div class="col-md-12 text-center mt-50">
                                            <div class="form-group text-left">
                                                <a href="<?php echo $img_upload_url; ?>" class="simple-ajax-modal btn btn-outline btn-info btn-sm">Upload Bank Deposit Slip</a>
                                                <span class="ml-20" id="upload-status-msg"></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="payment_amount" class="pull-left">Amount Paid *</label>
                                            <input type="text" class="form-control text-right" name="payment_amount" id="payment_amount" placeholder="Enter Amount"  value="<?php echo $payment_amount; ?>" required /> 
                                        </div>
                                        <div class="form-group  col-md-6">
                                            <label for="example-date-input" class="pull-left">Date of payment *</label>
                                            <input class="form-control" type="date" value="<?php echo $payment_date; ?>" name="payment_date" id="example-date-input">
                                        </div> 
                                        <div class="form-group col-md-12">
                                            <label for="payment_description" class="pull-left">Description</label>
                                            <textarea name="payment_description" class="form-control " id="payment_description" placeholder="Description..." rows="2" cols="5"></textarea> 
                                        </div>
                                        <div class="form-group  col-md-12">
                                          <input type="hidden" id="payment-image" name="image" value="<?php echo $image; ?>" required />
                                          <div class="col-md-12 ">                
                                            <?php echo $temp_input; ?>
                                            <?php echo $save_btn; ?>
                                          </div>
                                        </div>
                                </div>
                            </div>
                          <!-- /.box-body -->
                          </form>
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
