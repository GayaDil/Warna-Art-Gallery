<?php
require 'config.php';
$page_title = 'Add Quantity';

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-quantity">SAVE</a>';
$temp_input = '';

$list = '';

$artist_id = 4;

$query = $db->query("SELECT * FROM `products` WHERE `user_id` = '$artist_id' AND `status` = 1 AND `admin_status` = 1 ORDER BY `title` ASC");
$rowCount = $query->num_rows;
if($rowCount > 0){
	while($row = $query->fetch_assoc()){
		$id = $row['id'];
		$title = $row['title'];


$list .= <<<EOD
<option value="$id">$title</option>
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
      <div class="row">
        <div class="col-md-6 mr-auto ml-auto">
          <div class="box">      
            <form method="POST" id="form-quantity">        
              <!-- /.box-header -->
              <div class="box-body"> 
                <div class="row">     
                    <div class="col-md-12">
                      <div class="form-group">
                          <label>Select Artwork</label>
                          <select class="form-control select2" style="width: 100%;" name="product_id" required>
                            <?php echo $list; ?>                          
                          </select>
                      </div>
                    </div>     
                    <div class="col-md-4" align-items= "center">
                        <div class="form-group" >
                          <label>Quantity</label>
                          <input type="text" class="form-control" placeholder="Enter ..." name="quantity" value="<?php echo $quantity; ?>">           
                        </div>                  
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12"  align-items= "center">                
                      <?php echo $temp_input; ?>
                      <?php echo $save_btn; ?>
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


</div>
<!-- ./wrapper -->


	<?php include 'include/script.php'; ?>
	

</body>
</html>
