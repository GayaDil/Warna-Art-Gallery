<?php
require 'config.php';
$page_title = 'Add New Artwork';


$temp_start_time = date('Y-m-d',time());
$temp_end_time = date('Y-m-d',strtotime('1 months',time()));
$quantity = 1;

$save_btn = '<a href="javascript:void(0);" class="btn btn-info add-product">SAVE</a>';
$img_upload_url = 'modal-product-image-upload.php';
$temp_input = '';
$d_display = 'display: none;';
$m_display = 'display: none;';
$pm_checked_1 = 'checked';


if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update Product';

  $prd = new Products();
  $user_id = $prd->product($get_id)['user_id'];
  $category_id = $prd->product($get_id)['category_id'];
  $title = $prd->product($get_id)['title'];
  $orientation = $prd->product($get_id)['orientation'];
  $dimension_id = $prd->product($get_id)['dimension_id'];
  $dimension_x = $prd->product($get_id)['dimension_x'];
  $dimension_y = $prd->product($get_id)['dimension_y'];
  $dimension_label_id = $prd->product($get_id)['dimension_label_id'];
  $artwork_date = date('Y-m-d', strtotime($prd->product($get_id)['artwork_date']));
  $post_method = $prd->product($get_id)['post_method'];
  $temp_start_time = date('Y-m-d', strtotime($prd->product($get_id)['bid_start_time']));
  $temp_end_time = date('Y-m-d', strtotime($prd->product($get_id)['bid_end_time']));
  $price = $prd->product($get_id)['price'];
  $quantity = $prd->product($get_id)['quantity'];
  $image_backend = $prd->product($get_id)['image'];
  $image = $prd->product($get_id)['image_name'];
  $description = $prd->product($get_id)['description'];
  


  if ( $post_method == 2 ) {
    $pm_checked_1 = '';
    $pm_checked_2 = 'checked';
    $m_display = 'display: block;';
  }



  $save_btn = '<a href="javascript:void(0);" class="btn btn-info update-product2">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';
  $img_upload_url = 'modal-product-image-upload.php?id='.$get_id;

}


//List all dimensions
$category_list = '';
$query = $db->query("SELECT * FROM `categories` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];
    $selected = ( $id == $category_id ) ? 'selected' : '';

$category_list .= <<<EOD
<option value="$id" $selected>$type</option>
EOD;

  }
}



//List all dimensions
$dimension_list = '';
$query = $db->query("SELECT * FROM `dimensions` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];

    if ( !isset($_GET['id']) ) {
      $d_selected = ( $id == 1 ) ? 'selected' : '';
    }else{
      $d_selected = ( $id == $dimension_id ) ? 'selected' : '';

      if ( $dimension_id == 0 ) {
        $d_display = 'display: block;';
      }
    }
    
$dimension_list .= <<<EOD
<option value="$id" $d_selected>$type</option>
EOD;

  }
}


//List all dimension custom label
$dimension_custom_list = '';
$query = $db->query("SELECT * FROM `dimension_custom_label` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];
    $l_selected = ( $id == $dimension_label_id ) ? 'selected' : '';

$dimension_custom_list .= <<<EOD
<option value="$id" $l_selected>$type</option>
EOD;

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

      <div class="box">
        <form method="POST" id="form-artwork2">
        <!-- /.box-header -->
          <div class="box-body">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Select Artwork Category</label>
                  <select class="form-control" name="category_id">
                    <?php echo $category_list; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="title" value="<?php echo $title; ?>">
                </div>
              </div>
              <div class="col-md-2">
                <a href="<?php echo $img_upload_url; ?>" class="simple-ajax-modal btn btn-info">Upload Image</a>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Orientation</label>
                  <select class="form-control" name="orientation">
                    <option value="1">Landscape</option>
                    <option value="2">Portrait</option>
                    <option value="3">Square</option>
                    <option value="4">Other</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Dimensions</label>
                  <select class="form-control" name="dimension_id" id="dimension">
                    <?php echo $dimension_list; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" id="dimension-custom" style="<?php echo $d_display; ?>">
                  <label>Dimensions</label>
                  <div>
                    <input type="number" class="form-control" placeholder="100" min="0" name="dimension_x" style="width: 30%;display: inline-block" value="<?php echo $dimension_x; ?>">
                    <span> X </span>
                    <input type="number" class="form-control" placeholder="200" min="0" name="dimension_y" style="width: 30%;display: inline-block" value="<?php echo $dimension_y; ?>">
                    <select class="form-control" name="dimension_label_id"  style="width: 30%;display: inline-block">
                      <?php echo $dimension_custom_list; ?>
                    </select>
                  </div>
                  
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="example-date-input">Artwork Date</label>
                  <input class="form-control" type="date" value="<?php echo $artwork_date; ?>" name="artwork_date" id="example-date-input">
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                <label>Post Method :</label>
                  <div class="c-inputs-stacked">
                  <input name="post_method" type="radio" id="radio_123" value="1" <?php echo $pm_checked_1; ?> >
                  <label for="radio_123" class="mr-30">General</label>
                  <input name="post_method" type="radio" id="radio_456" value="2" <?php echo $pm_checked_2; ?> >
                  <label for="radio_456" class="mr-30">Bid</label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group bid-times" style="<?php echo $m_display; ?>">
                  <label for="example-date-input">Bid start time</label>
                  <input class="form-control" type="date" value="<?php echo $temp_start_time; ?>" name="bid_start_time" id="example-date-input">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group bid-times" style="<?php echo $m_display; ?>">
                  <label for="example-date-input">Bid end time</label>
                  <input class="form-control" type="date" value="<?php echo $temp_end_time; ?>" name="bid_end_time" id="example-date-input">
                </div>
              </div> 
            </div>
            <div class="row">

              <div class="col-md-2">
                <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control text-right" name="price" value="<?php echo $price; ?>">
                </div>
              </div>            
              <div class="col-md-2">
                <div class="form-group">
                  <label>Quantity</label>
                  <input type="text" class="form-control text-center" name="quantity" value="<?php echo $quantity; ?>">
                </div>
              </div>
              <div class="col-md-8">
                <div class="form-group">
                  <label>Description</label>
                  <textarea rows="4" class="form-control" name="description" placeholder="About Project"><?php echo $description; ?></textarea>
                </div>
              </div>
            </div>
            <div class="row">

              <div class="col-md-6 d-flex" id="uploaded_image">
                  <?php if (isset($image)) :?>
                      <div class="d-flex align-items-center justify-content-center">
                          <img src="<?php echo $image_backend; ?>" style="width: 50%;">
                      </div>
                  <?php endif;?>
              </div>


              <input type="hidden" id="product-image" name="image" value="<?php echo $image; ?>">
              <div class="col-md-12">                
                <?php echo $temp_input; ?>
                <?php echo $save_btn; ?>
              </div>
            </div>

          </div>
          <div class="box-footer">
            
          </div>
        <!-- /.box-body -->
        </form>
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
   $(document).ready(function(){

    $('#dimension').on('change', function(){

      var id = $(this).val();

      $('#dimension-custom').hide();

      if ( id == 0 ) {
        $('#dimension-custom').show();
      }

    });


    $('input[type=radio][name=post_method]').change(function() {
      if (this.value == '1') {
          $('.bid-times').hide();
      }
      else if (this.value == '2') {
          $('.bid-times').show();
      }
    });


   }); 
  </script>

</body>
</html>
