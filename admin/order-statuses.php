<?php
require 'config.php';

$page_title = 'All Order Statuses';

$list = '';

$query = $db->query("SELECT * FROM `order_status`");
$rowCount = $query->num_rows;
if($rowCount > 0){
	$no = 0;
	while($row = $query->fetch_assoc()){
		$no++;
		$id = $row['id'];
		$type = $row['type'];
		$label = $row['label'];


$list .= <<<EOD
<tr>
	<td>$no</</td>
	<td class="text-left"><span class="badge badge-$label">$type</span></td>
	<td class="text-right">
    <a class="btn btn-info btn-xs" href="order-status?id=$id">
			<i class="fa fa-edit"></i>
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
							<th>Type</th>
							<th>Actions</th>
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

</body>
</html>
