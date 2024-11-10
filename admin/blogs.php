<?php
require 'config.php';

$page_title = 'All Blog Posts';

$list = '';

//Start - Pagination
$pageno = 1;
if (isset($_GET['page'])) {
$pageno = $_GET['page'];
}

$no_of_records_per_page = 20;
$offset = ($pageno-1) * $no_of_records_per_page; 

$sql = "SELECT * FROM `blog_posts` ORDER BY `id` DESC";

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
		$title = $row['title'];
		$user_id = $row['user_id'];
		$created_time = $row['created_time'];
		$status = $row['status'];
		
		$checked = ( $status == 1 ) ? 'checked' : '';

		if ( $status == 1 ) {
			$status = "active";
			$status_label = "success";
		}else{
			$status = "Inactive";
			$status_label = "warning";
		}

    //Row Number
    $list_no = $no;
    if ( $pageno > 1 ) {
      $list_no = $offset + $no;
    }

    /* pads a string to a new length*/
    /* STR_PAD_LEFT - Pad to the left side of the string*/
    $list_no = str_pad($list_no, 3,0,STR_PAD_LEFT);

$list .= <<<EOD
<tr>
	<td style="width:5%;">$list_no</</td>
	<td style="width:45%;">$title</td>
	<td class="text-center" style="width:20%;">$created_time</td>
	<td class="text-center" id="status-$id" style="width:10%;"><span class="label label-$status_label">$status</span></td>
	<td class="text-right" style="width:20%;">
		<label class="switch switch-border switch-success">
            <input class="switch-blog" data-id="$id" type="checkbox" $checked >
            <span class="switch-indicator"></span>
            <span class="switch-description"></span>
        </label>
        <a class="btn btn-info btn-xs" href="../blog?id=$id">
			<i class="fa fa-search"></i>
		</a>
        <a class="btn btn-info btn-xs" href="blog?id=$id">
			<i class="fa fa-edit"></i>
		</a>
		<a class="btn btn-danger btn-xs delete-blog" data-id="$id" href="javascript:void(0);">
			<i class="fa fa-trash"></i>
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
					<tr ><th class="text-right" colspan="5"><a class="btn btn-primary btn-sm" href="blog">Add new</a></th></tr>
					<tr>
						<th>#</th>
						<th>Title</th>
						<th class="text-center">Created</th>
						<th class="text-center">Status</th>
						<th class="text-right">Actions</th>
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
        $('.switch-blog').on('change', function () {
            var id = $(this).data('id');
            var this_label = '#status-'+id;
            $.ajax({
                url: 'ajax/ajax-blog.php',
                type: 'POST',
                data: 'type=blog_status&id=' + id,
                success: function (data) {

                	$(this_label).html('<span class="label label-'+data.label+'">'+data.type+'</span>');

                    $.toast({
                        heading: 'Status Changed!',
                        text: 'Blog status changed!',
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
