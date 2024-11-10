<?php
require_once 'config.php';

$page_title = 'Artits';


$s_service = null;
$s_query = null;

if (isset($_GET['submit'])) {
    $s_service = ( $_GET['service_id'] > 0 ) ? $_GET['service_id'] : null;
    $s_query = ( strlen($_GET['search']) > 0 ) ? $_GET['search'] : null;
}

$select_service = ( isset($_GET['service_id']) ) ? $_GET['service_id'] : 0;
$select_query = ( isset($_GET['search']) && strlen($_GET['search']) > 0 ) ? $_GET['search'] : '';

$s_list = '';
$query = $db->query("SELECT * FROM `services` WHERE `status` = 1 ORDER BY `type` ASC");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
        $id = $row['id'];
        $type = $row['type'];
        $s_selected = ( $id == $select_service ) ? 'selected' : '';

        if ($id != 9) {
            $s_list .= '<option value="'.$id.'" '.$s_selected.'>'.$type.'</option>';
        }

        $so_select = ($select_service == 9) ? 'selected' : '';       
    }
}

/*
$ar = new Homepage();
$artists = $ar->artists($s_service,$s_query);
*/
$ar = new Homepage();
$artists = $ar->artist_services($s_service,$s_query)['list'];
$total_pages = $ar->artist_services($s_service,$s_query)['total_pages'];


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
                <h1 class="page-title"><a href="artists">Warna Artists</a></h1>
            </div>
        </div>
    </div>
         
            <!-- Main content -->
            <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="box">
                        <div class="box-body">
                            <form method="GET" novalidate="novalidate" id="searchform">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <h5 class="my-10">Categories</h5>
                                        <select class="form-control" style="width: 100%;" name="service_id">
                                            <option value="0">All services</option>
                                            <?php echo $s_list; ?>
                                            <option value="9" <?php echo $so_select; ?>>Others</option>
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
                                        <a href="artists" class="btn btn-outline btn-primary">Clear</a>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>    
                    </div>
                    <!-- START Card With Image -->
                    <div class="row fx-element-overlay">

                        <?php foreach ($artists as $at):?> 

                        <div class="col-md-12 col-lg-3">
                            <div class="box box-default">
                                <div class="fx-card-item">
                                    <div class="fx-card-avatar fx-overlay-1"> <img src="<?php echo $at['image']; ?>" alt="<?php echo $at['full_name']; ?>"/>
                                        <div class="fx-overlay">
                                            <ul class="fx-info">
                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="artist.php?id=<?php echo $at['user_id']; ?>"><i class="ion-search"></i> View </a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="fx-card-content">
                                        <h3 class="box-title"><a href="artist.php?id=<?php echo $at['user_id']; ?>"><?php echo $at['full_name']; ?></a></h3> 
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
