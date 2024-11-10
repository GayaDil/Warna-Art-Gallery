<?php
require 'config.php';
$page_title = 'Add New Artwork';


$temp_start_time = date('Y-m-d',time());
$temp_end_time = date('Y-m-d',strtotime('1 months',time()));
$quantity = 1;

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-artwork">SAVE</a>';
$temp_input = '';
////$date = date('Y-m-d', strtotime($pr->product($id)['date']));


if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update Product';

    $prd = new Products();
    $user_id = $prd->product($get_id)['user_id'];
    $category_id = $prd->product($get_id)['category_id'];
    $title = $prd->product($get_id)['title'];
    $orientation = $prd->product($get_id)['orientation'];
    $dimenstion_id = $prd->product($get_id)['dimenstion_id'];
    $dimenstion_x = $prd->product($get_id)['dimenstion_x'];
    $dimenstion_y = $prd->product($get_id)['dimenstion_y'];
    $dimenstion_label_id = $prd->product($get_id)['dimenstion_label_id'];
    $artwork_date = date('Y-m-d H:i:s', strtotime($prd->product($get_id)['artwork_date']));
    $post_method = $prd->product($get_id)['post_method'];
    $bid_start_time = date('Y-m-d H:i:s', strtotime($prd->product($get_id)['bid_start_time']));
    $bid_end_time = date('Y-m-d H:i:s', strtotime($prd->product($get_id)['bid_end_time']));
    $price = $prd->product($get_id)['price'];
    $description = $prd->product($get_id)['description'];




  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-product">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

}

//List all dimentions
$category_list = '';
$query = $db->query("SELECT * FROM `categories` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];

   /* $category_list .= <<<EOD
    <option value="$id">$type</option>
    EOD;    */
    
  $selected = ( $id == $category_id ) ? 'selected' : '';
  $category_list .= <<<EOD
  <option value="$id" $selected>$type</option>
  EOD;

  } 
}




//List all dimentions
$dimention_list = '';
$query = $db->query("SELECT * FROM `dimensions` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];
$dimention_list .= <<<EOD
<option value="$id">$type</option>
EOD;

  }
}


//List all dimention custom label
$dimention_custom_list = '';
$query = $db->query("SELECT * FROM `dimension_custom_label` WHERE `status` = 1 ");
$rowCount = $query->num_rows;
if($rowCount > 0){
  while($row = $query->fetch_assoc()){
    $id = $row['id'];
    $type = $row['type'];
$dimention_custom_list .= <<<EOD
<option value="$id">$type</option>
EOD;

  }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>
</head>
<body class="hold-transition skin-info-light fixed sidebar-mini">
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
        <form method="POST" id="form-artwork">
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
              <div class="col-md-8">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="title" value="<?php echo $title; ?>">
                </div>
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
                  <select class="form-control" name="dimenstion_id" id="dimenstion">
                    <?php echo $dimention_list; ?>
                    <option value="0">Custom</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group" id="dimenstion-custom" style="display: none;">
                  <label>Dimensions</label>
                  <div>
                    <input type="number" class="form-control" placeholder="100" min="0" name="dimenstion_x" style="width: 30%;display: inline-block">
                    <span> X </span>
                    <input type="number" class="form-control" placeholder="200" min="0" name="dimenstion_y" style="width: 30%;display: inline-block">
                    <select class="form-control" name="dimenstion_label_id"  style="width: 30%;display: inline-block">
                      <?php echo $dimention_custom_list; ?>
                    </select>
                  </div>
                  
                </div>
              </div>

            </div>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="example-date-input">Artwork Date</label>
                  <input class="form-control" type="date" value="<?php echo $temp_start_time; ?>" name="artwork_date" id="example-date-input">
                </div>
              </div>              
              <div class="col-md-3">
                <div class="form-group">
                <label>Post Method :</label>
                  <div class="c-inputs-stacked">
                  <input name="post_method" type="radio" id="radio_123" value="1" checked>
                  <label for="radio_123" class="mr-30">General</label>
                  <input name="post_method" type="radio" id="radio_456" value="2">
                  <label for="radio_456" class="mr-30">Bid</label>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group bid-times" style="display: none;">
                  <label for="example-date-input">Bid start time</label>
                  <input class="form-control" type="date" value="<?php echo $temp_start_time; ?>" name="bid_start_time" id="example-date-input">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group bid-times" style="display: none;">
                  <label for="example-date-input">Bid end time</label>
                  <input class="form-control" type="date" value="<?php echo $temp_end_time; ?>" name="bid_end_time" id="example-date-input">
                </div>
              </div> 
            </div>
            <div class="row">

              <div class="col-md-2">
                <div class="form-group">
                  <label>Price</label>
                  <input type="text" class="form-control text-right" name="price">
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
                  <textarea rows="4" class="form-control" name="description" placeholder="About Project"></textarea>
                </div>
              </div>
            </div>
            <div class="row">
              <input type="text" id="product-image" name="image" value="">
              <div class="col-md-12">
                <a href="modal-product-image-upload.php" class="simple-ajax-modal btn btn-info">Upload Image</a>
              </div>

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

    $('#dimenstion').on('change', function(){

      var id = $(this).val();

      $('#dimenstion-custom').hide();

      if ( id == 0 ) {
        $('#dimenstion-custom').show();
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
