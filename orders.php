<?php
require_once 'config.php';


if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}



$page_title = "Orders";

$list = '';

$or = new Orders();
$orders = $or->all_orders($this_user_id, 2)['list'];
$total_pages = $or->all_orders($this_user_id, 2)['total_pages'];

foreach ($orders as $order) {

    $id = $order['id'];
    $artist_id = $order['artist_id'];
    $this_status = $order['status'];
    $created = date('Y-m-d h:i A',strtotime($order['created'])); 

    $oa = new Users();
    $artist_name = $oa->user($artist_id)['full_name']; 



    // Get All status ids in to array
    $all_order_statuses_arr = array();


    $aos = new Orders();
    $order_statuses =  $aos->order_progress($id);

    foreach ( $order_statuses as $order_status ) {
        array_push($all_order_statuses_arr, $order_status['status']);
    }

    /* //status allow array
    $status_notallow_arr = array(6,13);*/

    //check if status id 6 avaible
    if ( in_array(6, $all_order_statuses_arr) ) {   
        $this_status = 7;
    }


    $os = new Orders();
    $status = $os->order_status($this_status)['type'];
    $status_label = $os->order_status($this_status)['label'];


       
    


    /* pads a string to a new length*/
    /* STR_PAD_LEFT - Pad to the left side of the string*/
    $no = str_pad($no, 3,0,STR_PAD_LEFT);


    $edit_btn = '';

    //status allow array
    $allow_arr = array(1,2,3,4);

    if ( in_array($this_status, $allow_arr) ) {
        $edit_btn = '<a class="btn btn-outline btn-info btn-xs" href="order?id='.$id.'">
        <i class="fa fa-edit"></i>
    </a>';
    }

    



 
$list .= <<<EOD
<tr>
    <td class="text-center">$id</</td>
    <td class="text-center">$artist_name</td>
    <td class="text-center">$created</td>
    <td class="text-center"><span class="badge badge-$status_label">$status</span></td>
    <td class="text-right">
     <a class="btn btn-outline btn-info btn-xs btn " href="order-view?id=$id">
        <i class="fa fa-search"></i>
    </a>
    $edit_btn
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
        <li class="page-item"><a class="page-link " $prev_url >Previous</a></li>
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
<body class="hold-transition skin-info fixed dark">
    <!-- Site wrapper -->
    <div class="wrapper frontend">
        <?php include 'include/header.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header mt-20">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1 class="page-title"><a href="cart">Warna <b>Profile</b></a></h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    
                    <div class="col-12 col-md-3"> 
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">                        
                                        <tbody>
                                            <tr>
                                                <td ><a href="orders" class="custom-active"><i class="fa fa-bullhorn "></i>  My Orders</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="profile" ><i class="fa fa-bullhorn"></i>  General Details</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-email" ><i class="fa fa-bullhorn"></i>  Update Email</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-password" ><i class="fa fa-bullhorn"></i>  Update Password</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                                
                    </div>
                    <div class="col-12 col-md-9">
                    <div class="box">
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tr>
                                        <th class="text-center">Order ID</th>
                                        <th class="text-center">Artist Name</th>
                                        <th class="text-center">Created</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Actions</th>
                                  </tr>
                                  <?php echo $list; ?>
                                </table>
                            </div>
                        </div>
                        <!-- Start - pagination -->
                        <?php echo $pagination; ?> 
                        <!-- End - pagination -->
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
