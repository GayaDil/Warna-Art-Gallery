<?php
require 'config.php';

if ( isset($_GET['id'])) {
    $this_id = $_GET['id'];

    $p = new Products();

    $user_id = $p->product($this_id)['user_id'];
    $category_id = $p->product($this_id)['category_id'];
    $medium_id = $p->product($this_id)['medium_id'];
    $post_method = $p->product($this_id)['post_method'];
    $bid_start_time = $p->product($this_id)['bid_start_time'];
    $bid_end_time = $p->product($this_id)['bid_end_time'];
    $title = $p->product($this_id)['title'];
    $description = $p->product($this_id)['description'];
    $price = $p->product($this_id)['price'];
    $quantity = $p->product($this_id)['quantity'];
    $orientation = $p->product($tmedhis_id)['orientation'];
    $dimension_id = $p->product($this_id)['dimension_id'];
    $dimension_x = $p->product($this_id)['dimension_x'];
    $dimension_y = $p->product($this_id)['dimension_y'];
    $dimension_label_id = $p->product($this_id)['dimension_label_id'];
    $image = $p->product($this_id)['image'];
    $artwork_date = date('Y', strtotime($p->product($this_id)['artwork_date']));
    $status = $p->product($this_id)['status'];
    $admin_status = $p->product($this_id)['admin_status'];
    $created = date('d-F-Y', strtotime($p->product($this_id)['created']));

    $page_title = $title . ' - #'. $this_id; 

    $cat = new Categories();
    $category = $cat->category($category_id)['type'];

    $med = new Mediums();
    $medium = $med->medium($medium_id)['type'];

    $pa = new Users();
    $full_name = $pa->user($user_id)['full_name'];

    switch ($orientation) {
        case 1:
            $orientation = 'Landscape';
            break;
        case 2:
            $orientation = 'Portrait';
            break;
        case 3:
            $orientation = 'Square';
            break;
        default:
            $orientation = 'Other';
            break;
    }

    if ( $dimension_id == 0 ){
        $dl = new Products();
        $dimension = $dimension_x .'x'.$dimension_y.' '.$dl->dimension_label($dimension_label_id)['type'];
    }else{
        $d = new Products();
        $dimension = $d->dimension($dimension_id)['type'];
    }

    $img_path = '../assets/artworks/'.$this_id.'/';
    $image = $img_path.$image;

    if ( !file_exists($image)){
        $image = '../assets/artworks/dummy.jpg';
    }

    switch ($post_method) {
        case 1:
            $post_method = 'General';
            break;
        case 2:
            $post_method = '<i class=" mdi mdi-timer-sand"></i>'. ' Auction';
            break;
    }

    if( $status == 1 ) {
          $status = "active";
          $status_label = "success";
    }else{
          $status = "Disabled ";
          $status_label = "danger";
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
    <div class="row">
		<!--<div class="d-flex align-items-center"> -->			
      <div class="col-md-6 mr-auto">
				<h3 class="page-title"><?php echo $page_title; ?></h3>
			</div>      
		<!--</div> -->
    </div>
	</div>

    <!-- Main content -->
    <section class="content">

      <div class="row">
    
        <div class="col-md-12">
          <div class="box">       
            <div class="box-header with-border">
              <h4 class="box-title">Product Details</h4>
            </div>
            <div class="box-body">
              <!-- -->
              <div class="row">
                <div class="col-md-12 text-center">
                  <div class="row">
                    <div class="col-md-6 mr-auto ml-auto">
                      <img src="<?php echo $image; ?>" class="img-fluid" alt="product-image">
                    </div>                    
                  </div>
                  
                </div>
              </div>

              <div class="table-responsive mt-20">
                <table class="table">

                  <?php if ( isset( $status ) ) :?>
                    <tr>
                      <td>Status</td>
                      <td ><span class="label label-<?php echo $status_label ?>"><?php echo $status; ?></span></td>
                    </tr>
                  <?php endif;?>
                  
                  <?php if ( isset( $title ) ) :?>
                    <tr>
                      <td>Title</td>
                      <td><b><h5><?php echo $title; ?></h5></b></td>
                    </tr>
                  <?php endif;?>

                  <?php if ( isset( $full_name ) ) :?>
                    <tr>
                      <td>Artist</td>
                      <td><b><i><?php echo $full_name; ?></i></b></td>
                    </tr>
                  <?php endif;?>

                  <?php if ( isset( $category ) ) :?>
                    <tr>
                      <td>Category</td>
                      <td><b><?php echo $category; ?></b></td>
                    </tr>
                  <?php endif;?>

                  <?php if ( isset( $medium ) ) :?>
                    <tr>
                      <td>Medium</td>
                      <td><b><?php echo $medium; ?></b></td>
                    </tr>
                  <?php endif;?>

                  <?php if ( isset( $post_method ) ) :?>
                    <tr>
                      <td>Post method</td>
                      <td><b><?php echo $post_method; ?></b></td>
                    </tr>
                  <?php endif;?>

                  <?php if ( isset( $price ) ) :?>
                    <tr>
                      <td>Price</td>
                      <td><b>Rs.<?php echo $price; ?> </b></td>
                    </tr>
                  <?php endif;?>


                  <?php if ( isset( $orientation ) ) :?>
                    <tr>
                      <td>Orientation</td>
                      <td><b><?php echo $orientation; ?></b></td>
                    </tr>
                  <?php endif;?>


                  <?php if ( isset( $dimension ) ) :?>
                    <tr>
                      <td>Dimension</td>
                      <td><b><?php echo $dimension; ?></b></td>
                    </tr>
                  <?php endif;?>


                  <?php if ( isset( $quantity ) ) :?>
                    <tr>
                      <td>Quantity</td>
                      <td><b><?php echo $quantity; ?></b></td>
                    </tr>
                  <?php endif;?>

                   <?php if ( isset( $description ) ) :?>
                    <tr>
                      <td>Description</td>
                      <td><b><?php echo $description; ?></b></td>
                    </tr>
                  <?php endif;?>

                   <?php if ( isset( $artwork_date ) ) :?>
                    <tr>
                      <td>Artwork Date</td>
                      <td><b><?php echo $artwork_date; ?></b></td>
                    </tr>
                  <?php endif;?>

                   

                  <?php if ( isset( $created ) ) :?>
                    <tr>
                      <td>Created</td>
                      <td><b><?php echo $created; ?></b></td>
                    </tr>
                  <?php endif;?>


                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
    

</div>
<!-- ./wrapper -->


	<?php include 'include/script.php'; ?>
	

</body>
</html>
