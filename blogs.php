<?php
require_once 'config.php';

$page_title =  "Blog";

$s_query = null;


if (isset($_GET['submit'])) {
    $s_query = ( strlen($_GET['search']) > 0 ) ? $_GET['search'] : null;
}
$select_query = ( isset($_GET['search']) && strlen($_GET['search']) > 0 ) ? $_GET['search'] : '';

$bl = new Homepage();
$blogs = $bl->blogs($s_query)['list'];
$total_pages = $bl->blogs($s_query)['total_pages'];

foreach ($blogs as $blg) {
    $user_id = $blg['user_id'];

$pa = new Users();
$full_name = $pa->user($user_id)['full_name'];

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
                        <h1 class="page-title"><a href="blogs">Warna Blog</a> </h1>
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
                                <div class="col-md-4">
                                    <h5 class="my-10">Search</h5>
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Enter ..." name="search" value="<?php echo $select_query; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <div class="form-group">
                                        <button type="submit" name="submit" class="btn btn-outline btn-primary"><i class="fa fa-arrow-left"></i> Search</button>
                                        <a href="blogs" class="btn btn-outline btn-primary">Clear</a>
                                    </div>
                                </div>
                                </div>
                                </form>
                            </div>    
                        </div>
                    </div>
                </div>
                    
            
                <div class="row">
                    <?php foreach ($blogs as $npr):?>
                    <div class="col-4">
                        <div class="box">
                            <img class="card-img-top img-responsive" src="<?php echo $npr['image']; ?>" alt="" title="" >
                            <div class="box-body"> 
                                <div class="text-center">
                                    <h4 class="box-title"><a href="blog?id=<?php echo $npr['id']; ?>"><?php echo $npr['title']; ?></a></h4>
                                    <p class="box-text"><?php echo substr(strip_tags($npr['content']), 0, 200); ?></p>
                                    <a href="blog?id=<?php echo $npr['id']; ?>" class="btn btn-outline btn-primary btn-sm">Read more</a>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>                       
                    </div> 
                    <?php endforeach; ?>  
                </div>
      

                <!-- Start - pagination -->
                <?php echo $pagination; ?> 
                <!-- End - pagination --> 
                    
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
