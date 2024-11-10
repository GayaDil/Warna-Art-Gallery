<?php
require_once 'config.php';

$page_title =  "Auction";

$s_category = null;
$s_medium = null;
$s_query = null;

if (isset($_GET['submit'])) {
    $s_category = ( $_GET['category_id'] > 0 ) ? $_GET['category_id'] : null;
    $s_medium =   ( $_GET['medium_id'] > 0 ) ? $_GET['medium_id'] : null;
    $s_query = ( strlen($_GET['search']) > 0 ) ? $_GET['search'] : null;
}

$select_category = ( isset($_GET['category_id']) ) ? $_GET['category_id'] : 0;
$select_medium = ( isset($_GET['medium_id']) ) ? $_GET['medium_id'] : 0;
$select_query = ( isset($_GET['search']) && strlen($_GET['search']) > 0 ) ? $_GET['search'] : '';

$c_list = '';
$query = $db->query("SELECT * FROM `categories` WHERE `status` = 1 ORDER BY `type` ASC");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
        $id = $row['id'];
        $type = $row['type'];
        $c_selected = ( $id == $select_category ) ? 'selected' : '';

        if ($id != 9) {
            $c_list .= '<option value="'.$id.'" '.$c_selected.'>'.$type.'</option>';
        }

        $co_select = ($select_category == 9) ? 'selected' : '';
    }
}

$m_list = '';
$query = $db->query("SELECT * FROM `mediums` WHERE `status` = 1 ORDER BY `type` ASC");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
        $mid = $row['id'];
        $mtype = $row['type'];
        $m_selected = ( $mid == $select_medium ) ? 'selected' : '';

        if($mid != 10){
            $m_list .= '<option value="'.$mid.'" '.$m_selected.'>'.$mtype.'</option>';
        }

        $mo_select = ($select_medium == 10) ? 'selected' : '';
    }
}

$au = new Homepage();
$auctions = $au->auction($s_category, $s_medium, $s_query)['list'];
$total_pages = $au->auction($s_category, $s_medium, $s_query)['total_pages'];

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
<body class="hold-transition skin-info fixed dark">
    <!-- Site wrapper -->
    <div class="wrapper frontend">
        <?php include 'include/header.php'; ?>
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h1 class="page-title"><a href="artists">Warna Auction</a></h1>
            </div>
        </div>
    </div>
         
            <!-- Main content -->
            <section class="content">

                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <form method="GET" novalidate="novalidate" id="searchform">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5 class="my-10">Categories</h5>
                                        <select class="form-control" style="width: 100%;" name="category_id">
                                            <option value="0">All categories</option>
                                            <?php echo $c_list; ?>
                                            <option value="9" <?php echo $co_select; ?>>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <h5 class="my-10">Art Medium</h5>
                                        <select class="form-control" style="width: 100%;" name="medium_id">
                                            <option value="0">All Mediums</option>
                                            <?php echo $m_list; ?>
                                            <option value="9" <?php echo $mo_select; ?>>Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="my-10">Search</h5>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter ..." name="search" value="<?php echo $select_query; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-outline btn-primary"><i class="fa fa-arrow-left"></i> Search</button>
                                        <a href="auction" class="btn btn-outline btn-primary">Clear</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>    
                    </div>
                    <!-- START Card With Image -->
                    <div class="row fx-element-overlay">

                        <?php foreach ($auctions as $npr):?> 

                        <div class="col-md-12 col-lg-3">
                            <div class="box box-default">
                                <div class="fx-card-item">
                                    <div class="fx-card-avatar fx-overlay-1"> <img src="<?php echo $npr['image']; ?>" alt="<?php echo $npr['title']; ?>"/>
                                        <div class="fx-overlay">
                                            <ul class="fx-info">
                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="product?id=<?php echo $npr['id']; ?>"><i class="ion-search"></i> View </a></li>

                                                <?php if ( $npr['post_method'] == 2 ) :?>

                                                <li><a class="btn default btn-outline add-this-to-cart" href="product?id=<?php echo $npr['id']; ?>" data-id="<?php echo $npr['id']; ?>" data-quantity="1"><span class="fa fa-gavel"></span> bid </a></li>

                                                <?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="fx-card-content">
                                        <h3 class="box-title"><a href="product?id=<?php echo $npr['id']; ?>"><?php echo $npr['title']; ?></a></h3> 
                                        <?php if ( $npr['post_method'] == 2 ) :
                                            
                                            $b = new Products();
                                            $current_bid = $b->current_ongoing_bid($npr['id'])['amount'];
                                        ?>
                                        <span class="amount text-primary"><i class="fa fa-gavel"></i> Rs. <?php echo number_format($current_bid, 2); ?> </span> 
                                        <br>
                                        <span class="amount text-primary" data-bid-end-time="<?php echo date('Y-m-d H:i:s', strtotime($npr['bid_end_time'])); ?>" style="font-size: 90%;"><i class="fa fa-clock-o"></i> 
                                            <label for="" class="text-primary bid-countdown">
                                                <span class="bid-days"></span>
                                                <span class="bid-hours"></span>
                                                <span class="bid-minutes"></span>
                                                <span class="bid-seconds"></span>                        
                                            </label>                                            
                                        </span> 
                                        <?php endif;?>
                                        <br> 
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->

                        <?php endforeach; ?>      

                    </div>
                    <!-- /.row -->
                    <!-- END Card with image -->

                    <!-- Start - pagination -->
                    <?php echo $pagination; ?> 
                    <!-- End - pagination --> 
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
