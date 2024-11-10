<?php
require 'config.php';
$page_title = 'Add New Category';





$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-new-category">SAVE</a>';
$temp_input = '';

if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update Category';

  $cat = new Categories();
  $category = $cat->category($get_id)['type'];

  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-category">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

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
        <div class="col-md-6 ml-auto mr-auto">
          <div class="box">
            <form method="POST" id="form-category">
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    



        
      <div class="ww-c-artwork-card__body" style="user-select: auto;">
          <div class="ww-c-artwork-card__name-wrapper" style="user-select: auto;">
                <img src="../assets/artworks/dummy.jpg">
                <a href="/artwork/sebastien-preschoux/muation" title="My Artwork, 2018" class="ww-c-artwork-card__name-content" style="user-select: auto;">MYARTWORK2018</a>     
          </div> 

        <div class="ww-c-artwork-card__artist-name" style="user-select: auto;">
              <div style="user-select: auto;">
                <a href="/artists/sebastien-preschoux" class="ww-c-artwork-card__name-link is-capitalize" style="user-select: auto;">Sebastien Preschoux</a>
              </div> 
              <div style="user-select: auto;">
                <a href="/venue/david-bloch-gallery" class="ww-c-artwork-card__name-link is-work-sans" style="user-select: auto;">DAVID BLOCH GALLERY</a>
              </div>
        </div> 
        <div class="ww-c-artwork-card__info" style="user-select: auto;">
              <span class="ww-c-artwork-card__size" style="user-select: auto;">130 x 89   cm</span>
              <span class="ww-c-artwork-card__category" style="user-select: auto;">Paintings</span> <!---->
              <span class="ww-c-artwork-card__price" style="user-select: auto;">Price on request</span> <!---->
        </div>

      </div>
     


                  </div>
                  <div class="col-md-12">                
                 
                  </div>
                </div>

              </div>
              
            <!-- /.box-body -->
            </form>
          </div>
        </div>
    </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'include/footer.php'; ?>    
  <!-- Add the sidebar's background. This div must be placed immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


	<?php include 'include/script.php'; ?>
	

</body>
</html>
