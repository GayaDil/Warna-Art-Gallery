<?php
require 'config.php';
$page_title = 'Add New Service';

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-service">SAVE</a>';
$temp_input = '';

if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update Service';


  $ser = new Services();
  $service = $ser->service($get_id)['type'];

  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-service">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

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
      <div class="row">
        <div class="col-md-6 ml-auto mr-auto">
          <div class="box">
            <form method="POST" id="form-service">
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Service Name</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="service" value="<?php echo $service; ?>">
                    </div>
                  </div>
                  <div class="col-md-12">                
                    <?php echo $temp_input; ?>
                    <?php echo $save_btn; ?>
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
