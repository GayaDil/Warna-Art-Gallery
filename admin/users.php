<?php
require 'config.php';

$page_title = 'All Users';

$list = '';


//Start - Pagination
$pageno = 1;
if (isset($_GET['page'])) {
$pageno = $_GET['page'];
}

$no_of_records_per_page = 40;
$offset = ($pageno-1) * $no_of_records_per_page; 

$sql = "SELECT * FROM `users` ORDER BY `id` DESC";

$total_pages_sql = $sql;
$result = $db->query($total_pages_sql);
$total_rows = $result->num_rows;
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql .= " LIMIT $offset, $no_of_records_per_page";
//End - Pagination

$query = $db->query($sql);
$rowCount = $query->num_rows;
if($rowCount > 0){
	$no = 0;
	while($row = $query->fetch_assoc()){
		$no++;
		$id = $row['id'];
		$role_id = $row['role_id'];
		$name = $row['first_name']. ' ' .$row['last_name'];
		$email = $row['email'];
		$status = $row['status'];

		$checked = ( $status == 1 ) ? 'checked' : '';

		if ( $status == 1 ) {
			$status = "active";
			$status_label = "success";
		}else{
			$status = "Inactive";
			$status_label = "warning";
		}

		if ( $role_id == 1 ) {
			$role = "Admin";
			
		}else if( $role_id == 2 ) {
			$role = "Artist";
			
		}else  {
			$role = "User";
			
		}

		//Row Number
		$list_no = $no;
		if ( $pageno > 1 ) {
			$list_no = $offset + $no;
		}

$list .= <<<EOD
<tr>
	<td>$list_no</</td>
	<td>$role</td>
	<td>$name</td>
	<td>$email</td>
	<td class="text-center" id="status-$id"><span class="label label-$status_label">$status</span></td>
	<td class="text-right">
		<label class="switch switch-border switch-success">
        <input class="switch-user" data-id="$id" type="checkbox" $checked >
        <span class="switch-indicator"></span>
        <span class="switch-description"></span>
    </label>
    <a class="btn btn-info btn-xs" href="user-view?id=$id">
			<i class="fa fa-search"></i>
		</a>
    <a class="btn btn-info btn-xs" href="user?id=$id">
			<i class="fa fa-edit"></i>
		</a>
	</td>
</tr>
EOD;

	}
}

$pg = new Paginations();
$prev_url = $pg->pagination($total_pages)['paginate_prev_url'];
$next_url = $pg->pagination($total_pages)['paginate_next_url'];

$pagination = <<<EOD
<div class="row">
  <div class="col-md-12">
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" $prev_url >Previous</a></li>
        <li class="page-item"><a class="page-link" $next_url >Next</a></li>
      </ul>
    </nav>
  </div>          
</div>
EOD;



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
							<th>Role</th>
							<th>Name</th>
							<th>Email</th>
							<th>Status</th>
							<th>Actions</th>
					</tr>
					<?php echo $list; ?>
				</table>
			</div>

		    <!-- Start - pagination -->
		    <?php echo $pagination; ?> 
		    <!-- End - pagination -->

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

	<script>
    $(document).ready(function () {
        $('.switch-user').on('change', function () {
            var id = $(this).data('id');
            var this_label = '#status-'+id;
            $.ajax({
                url: 'ajax/ajax-users.php',
                type: 'POST',
                data: 'type=user_status&id=' + id,
                success: function (data) {

                	$(this_label).html('<span class="label label-'+data.label+'">'+data.type+'</span>');

                    $.toast({
                        heading: 'Status Changed!',
                        text: 'User status changed!',
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
