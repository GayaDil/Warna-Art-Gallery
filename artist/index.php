<?php
require 'config.php';
$page_title = 'Dashboard';
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
      <!-- Start - Notify if not verified -->
      <?php if ( $nic_verified != 1 ) : ?>
        <?php echo $nic_not_verified; ?>
      <?php endif; ?>
      <!-- End - Notify if not verified -->

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Title</h3>

          <ul class="box-controls pull-right">
			<li><a class="box-btn-close" href="#"></a></li>
			<li><a class="box-btn-slide" href="#"></a></li>	
			<li><a class="box-btn-fullscreen" href="#"></a></li>
		  </ul>
        </div>
        <div class="box-body">
          This is some text within a card block.
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
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
	

</body>
</html>
