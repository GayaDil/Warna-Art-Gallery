<?php
require 'config.php';

if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $list = '';
    $no = 0;

    $query = $db->query("SELECT * FROM `bid` WHERE `product_id` = '$id' ORDER BY `amount` DESC ");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
      while($row = $query->fetch_assoc()){
        $no++;
        $bid_id = $row['id'];
        $amount = number_format($row['amount'], 2);
        $status = $row['status'];
        $created = date('Y-m-d h:i:s A', strtotime($row['created']));
        $status_user_id = $row['status_user_id'];
        $status_time = $row['status_time'];

        $this_bid_status = '';
        if ( $status == 1 ) {
          $this_bid_status = '<span class="label label-success">Winning Bid</span>';
        }elseif ( $status == 2 ) {
          $this_bid_status = '<span class="label label-danger">Declined</span>';
        }

$list .= <<<EOD
<tr>
  <td class="vertical-middle">$no</</td>
  <td class="vertical-middle">$created</</td> 
  <td class="vertical-middle text-right">$amount</</td>
  <td class="vertical-middle text-center">$this_bid_status</</td>               
</tr>
EOD;                 
      }
}



    $cb = new Products();
    $highest_amount = $cb->current_ongoing_bid($id)['amount'];

    $highest_amount_label = number_format($highest_amount,2);


    $bp = new Products();
    $image = $bp->product($id)['image'];
    $artist_id = $bp->product($id)['user_id'];
    $title = $bp->product($id)['title'];
    $price_label = $bp->product($id)['price_label'];
    $bid_start_time = $bp->product($id)['bid_start_time'];
    $bid_end_time = $bp->product($id)['bid_end_time'];

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



    if ( $artist_id != $this_user_id ) {
        header('location:./');

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


      <div class="row">
        <div class="col-md-12">
          <div class="box">

            <div class="box-body">
              <div class="row mb-10">
                <div class="col-12">
                  <h4 class="box-title">
                    <?php echo $title; ?>
                    <span class="pull-right font-size-14">Current Highest Bid: <span class="text-success"><?php echo $highest_amount_label; ?></span></span>
                  </h4>

                </div>
              </div>
              <div class="row mb-40">
                <div class="col-md-6">
                  <img src="<?php echo $image; ?>" class="img-fluid" alt="">
                </div>
                <div class="col-md-6">
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <td>Bid Status</td>
                        <td><span class="label label-<?php echo $bid_status_label; ?>"><?php echo $bid_status; ?></span></td>
                      </tr>
                      <tr>
                        <td>Time Left</td>
                        <td>
                          <span class="amount text-danger" data-bid-end-time="<?php echo date('Y-m-d H:i:s', strtotime($bid_end_time)); ?>" ><i class="fa fa-clock-o"></i> 
                            <label for="" class="text-danger bid-countdown">
                                <span class="bid-days"></span>
                                <span class="bid-hours"></span>
                                <span class="bid-minutes"></span>
                                <span class="bid-seconds"></span>                        
                            </label>                                            
                          </span> 
                        </td>
                      </tr>
                      <tr>
                        <td>Bid Start time</td>
                        <td><b><?php echo $bid_start_time; ?></b></td>
                      </tr>
                      <tr>
                        <td>Bid End time</td>
                        <td><b><?php echo $bid_end_time; ?></b></td>
                      </tr>
                      <tr>
                        <td>Price</td>
                        <td><b><?php echo $price_label; ?></b></td>
                      </tr>
                    </table>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12">
                  <h4 class="box-title">Product Bids</h4>
                  <div class="table-responsive">
                    <table class="table">
                      <tr>
                        <th>#</th>
                        <th>Bid placed time</th>
                        <th class="text-right">Amount</th>                        
                        <th class="text-center">Status</th>
                      </tr>
                      <?php echo $list; ?>
                    </table>
                  </div>
                </div>
              </div>
            </div>

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

  <script>
    $(document).ready(function () {
        $('.switch-op-status').on('change', function () {
            var id = $(this).data('id');
            $.ajax({
                url: 'ajax/ajax-orders.php',
                type: 'POST',
                data: 'type=order_product_status&id=' + id,
                success: function (data) {
                    $.toast({
                        heading: 'Changed!',
                        text: 'Ordered Product status changed!',
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
