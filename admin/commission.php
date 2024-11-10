<?php
require 'config.php';

$page_title = 'Update Commission';


$comm = new ArtistPayments();
$commission = $comm->commission();






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
        <div class="col-md-6 ml-auto mr-auto">
          <div class="box">
            <form method="POST" id="form-commission">
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">

                      <h5 class="mb-20">Current Commission: <span class="text-danger"><?php echo $commission; ?>%</span></h5>
                      <label>Update order commission</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="commission" id="commission" value="<?php echo $commission; ?>">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <a href="javascript:void(0);" class="btn btn-primary" id="update-commission">SAVE</a>
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
	

</body>
</html>
