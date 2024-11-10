<?php
require 'config.php';

$page_title = 'Order Inquiries';

$list = '';

$or = new Orders();
$inquirires = $or->order_inquiries()['list'];
$total_pages = $or->order_inquiries()['total_pages'];
$offset = $or->order_inquiries()['offset'];
$pageno = $or->order_inquiries()['pageno'];


$no = 0;
foreach ($inquirires as $inquiry) {

  $no++;
  $order_id = $inquiry['order_id']; 
  $last_subject = $inquiry['last_subject']; 
  $created = date('Y-m-d h:i A',strtotime($inquiry['created']));  



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
  <td>$list_no</</td>
  <td class="text-center">$order_id</</td>
  <td>$last_subject</td>
  <td class="text-center">$created</td>
  <td class="text-center"><span class="badge badge-$status_label">$status</span></td>
  <td class="text-right">
   <a class="btn btn-info btn-xs" href="order-inquiry?id=$order_id">
      <i class="fa fa-search"></i>
    </a>
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
						<th>Order ID</th>
            <th>Subject</th>
            <th>Created</th>
						<th>Action</th>
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

</body>
</html>
