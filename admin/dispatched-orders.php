<?php
require 'config.php';

$page_title = 'Dispatched Orders';

$list = '';

$or = new Orders();
$orders = $or->pending_collect()['list'];
$total_pages = $or->pending_collect()['total_pages'];

$no = 0;
foreach ($orders as $order) {

	$no++;
	$id = $order['id'];
	$artist_id = $order['artist_id'];

  $au = new Users();
  $artist_name = $au->user($artist_id)['full_name'];


  $os = new Orders();
  $status = $os->order_status($order['status'])['type'];
  $status_label = $os->order_status($order['status'])['label'];
	$created = date('Y-m-d h:i A',strtotime($order['created']));	

	$no = str_pad($no, 3,0,STR_PAD_LEFT);

 
  $list .= <<<EOD
  <tr>
  	<td>$no</</td>
  	<td class="text-center">$id</</td>
  	<td>$artist_name</td>
  	<td class="text-center">$created</td>
  	<td class="text-center"><span class="badge badge-$status_label">$status</span></td>
  	<td class="text-right">
  	 <a class="btn btn-info btn-xs" href="order-view?id=$id">
  			<i class="fa fa-search"></i>
  		</a>
      <a class="btn btn-primary btn-xs mark-as-order-received" href="javascript:void(0);" data-id=$id><span> Mark as order received</span></a>
  	</td>
  </tr>
  EOD;

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
						<th class="text-center">Order ID </th>
						<th>Name</th>
						<th class="text-center">Created</th>
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
