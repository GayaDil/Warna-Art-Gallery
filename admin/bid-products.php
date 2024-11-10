<?php
require 'config.php';

$page_title = 'My Artworks';

$list = '';

//Start - Pagination
$pageno = 1;
if (isset($_GET['page'])) {
$pageno = $_GET['page'];
}

$no_of_records_per_page = 20;
$offset = ($pageno-1) * $no_of_records_per_page; 

$sql = "SELECT * FROM `products` WHERE  `post_method` = '2' ORDER BY `id` DESC";

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
		$user_id = $row['user_id'];
		$category_id = $row['category_id'];
		$title = $row['title'];
		$image = $row['image'];
		$bid_start_time = $row['bid_start_time'];
		$bid_end_time = $row['bid_end_time'];
		$status = $row['status'];
		$admin_status = $row['admin_status'];

		$oa = new Users();
  	$full_name = $oa->user($user_id)['full_name'];


		//Check due time
		$bid_start_time = date('Y-m-d H:i:s', strtotime($bid_start_time));
		$bid_end_time = date('Y-m-d H:i:s', strtotime($bid_end_time));

		if ( $bid_start_time > $now ) {
			$bid_status = "Upcoming ";
      $bid_status_label = "warning";

		}elseif ( $now > $bid_start_time && $bid_end_time > $now ) {
			$bid_status = "Ongonig";
      $bid_status_label = "success";

		}elseif ($bid_end_time < $now) {
			$bid_status = "Overdue";
    	$bid_status_label = "danger";
		}




		$query_c = $db->query("SELECT * FROM `categories` WHERE `id` = '$category_id'");
		$row_c = $query_c->fetch_assoc();
		$category = $row_c['type'];


		$img_path = '../assets/artworks/'.$id.'/';
		$image = $img_path.$image;

		if ( !file_exists($image) ) {
			$image = '../assets/artworks/dummy.jpg';
		}



		//Row Number
    $list_no = $no;
    if ( $pageno > 1 ) {
      $list_no = $offset + $no;
    }

    /* pads a string to a new length*/
    /* STR_PAD_LEFT - Pad to the left side of the string*/
    $list_no = str_pad($list_no, 3,0,STR_PAD_LEFT);

    $time_left = date('Y-m-d H:i:s', strtotime($bid_end_time));
			

$list .= <<<EOD
<tr>
	<td>$list_no</</td>
	<td style="width:10%;"><img src="$image" class="" alt="User Image" ></</td>
	<td>$title</td>
	<td>$full_name</td>
	<td>$category</td>
	<td class="text-center"><span class="label label-$bid_status_label">$bid_status</span></td>
	
	<td>
    <span class="amount text-danger" data-bid-end-time="$time_left" ><i class="fa fa-clock-o"></i> 
      <label for="" class="text-danger bid-countdown">
          <span class="bid-days"></span>
          <span class="bid-hours"></span>
          <span class="bid-minutes"></span>
          <span class="bid-seconds"></span>                        
      </label>                                            
    </span> 
  </td>


	<td class="text-right">
    <a class="btn btn-info btn-xs" href="bid-product?id=$id">
			<i class="fa fa-search"></i>
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
							<th>Name</th>
							<th>Category</th>
							<th class="text-center">Bid Status</th>
							<th class="text-center">Status</th>
							<th class="text-center">Actions</th>
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
                url: 'ajax/ajax-artwork.php',
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
