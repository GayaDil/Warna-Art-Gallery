<?php
require 'config.php';
$page_title = 'Identity Verification';

$img_upload_url = 'modal-id-image-upload.php';

if ( $nic_verified == 1 ) {
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
			            	<form method="POST" id="form-nic">
			              	<!-- /.box-header -->
			                <div class="box-body">
			                  	<div class="row">
		                          	<div class="col-sm-12 text-center">
			                            <div class="form-group">
			                            	<input type="hidden" id="uploaded-image" name="image" value="">
			                              <a href="<?php echo $img_upload_url; ?>" class="simple-ajax-modal btn btn-info btn-sm">Upload Image</a>
			                            </div>
			                            <p>Upload your id proof to verify your Warna artist account. </p>
			                            <code>*Accept only NIC/ Driving Licence/ Passport</code>
		                          	</div>
			                  	</div>
			                </div>
			                <div class="box-footer text-right">
			                	<a href="profile" class="btn btn-info btn-sm ">SKIP</a>
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
	<?php include 'include/script.php'; ?>
</body>
</html>