<?php
require 'config.php';

$page_title = 'All Artworks';

$list = '';


//Start - Pagination
$pageno = 1;
if (isset($_GET['page'])) {
    $pageno = $_GET['page'];
}

$no_of_records_per_page = 20;
$offset = ($pageno-1) * $no_of_records_per_page; 

$sql = "SELECT * FROM `products` ORDER BY `id` DESC";

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
		$category_id = $row['category_id'];
		$title = $row['title'];
		$image = $row['image'];
		$status = $row['admin_status'];
		$user_id = $row['user_id'];
		//$admin_status = $row['admin_status'];

		$query_c = $db->query("SELECT * FROM `categories` WHERE `id` = '$category_id'");
		$row_c = $query_c->fetch_assoc();
		$category = $row_c['type'];

		$query_d = $db->query("SELECT * FROM `users` WHERE `id` = '$user_id'");
		$row_d = $query_d->fetch_assoc();
		$name = $row_d['first_name']. ' ' .$row_d['last_name'];



		$checked = ( $status == 1 ) ? 'checked' : '';

		if ( $status == 1 ) {
			$status = "active";
			$status_label = "success";
		}else{
			$status = "Disabled by Admin";
			$status_label = "danger";
		}


		$img_path = '../assets/artworks/'.$id.'/';
		$image = $img_path.$image;

		if ( !file_exists($image) ) {
			$image = '../assets/artworks/dummy.jpg';
		}

$list .= <<<EOD
<tr>
	<td>$no</</td>
	<td style="width:10%;"><img src="$image" class="" alt="User Image" ></</td>
	<td>$title</td>
	<td>$category</td>
	<td>$name</td>
	<td class="text-center" id="status-$id"><span class="label label-$status_label">$status</span></td>
	<td class="text-right">
		<label class="switch switch-border switch-success">
            <input class="switch-product" data-id="$id" type="checkbox" $checked >
            <span class="switch-indicator"></span>
            <span class="switch-description"></span>
        </label>
        <a class="btn btn-info btn-xs" href="../product?id=$id" target="_blank">
			<i class="fa fa-search"></i>
		</a>
        <a class="btn btn-info btn-xs" href="product?id=$id">
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
							<th>Image</th>
							<th>Title</th>
							<th>Category</th>
							<th>Artist Name</th>
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

</body>
</html>
