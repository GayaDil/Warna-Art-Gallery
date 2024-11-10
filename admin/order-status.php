<?php
require 'config.php';
$page_title = 'Add New Order Status';

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-order-status">SAVE</a>';
$temp_input = '';


//update status
if ( isset($_GET['id'])) {

  $get_id = $_GET['id'];
  $page_title = 'Update Order Status';

  $os = new Orders();
  $type = $os->order_status($get_id)['type'];
  $label = $os->order_status($get_id)['label'];

  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-order-status">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';

 
  switch ($label) {
    case 'info':
      $checked_1 = 'checked';
      break;
    case 'success':
      $checked_2 = 'checked';
      break;
    case 'warning':
      $checked_3 = 'checked';
      break;
    case 'danger':
      $checked_4 = 'checked';
      break;
    case 'primary':
      $checked_5 = 'checked';
      break;
    case 'cyan':
      $checked_6 = 'checked';
      break;
    case 'pink':
      $checked_7 = 'checked';
      break;
    case 'yellow':
      $checked_8 = 'checked';
      break;
    case 'brown':
      $checked_9 = 'checked';
      break;
    case 'dark':
      $checked_10 = 'checked';
      break;
    case 'gray':
      $checked_11 = 'checked';
      break;
    case 'secondary':
      $checked_12 = 'checked';
      break;
      default:
      $checked_1 = 'checked';
      break;
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
        <div class="col-md-6 ml-auto mr-auto">
          <div class="box">
            <form method="POST" id="form-order-status"> <!-- form-order-status-->
            <!-- /.box-header -->
              <div class="box-body">

                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">                      
                      <label> Order Status</label>
                      <input type="text" class="form-control" placeholder="Enter ..." name="status_type" value="<?php echo $type; ?>">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                    <label>Label :</label>
                      <div class="c-inputs-stacked">
                        <input name="label" type="radio" id="radio-1" value="info" <?php echo $checked_1; ?> >
                        <label for="radio-1" class="mr-30"><span class="badge badge-info">Blue</span></label>
                        <input name="label" type="radio" id="radio-2" value="success" <?php echo $checked_2; ?> >
                        <label for="radio-2" class="mr-30"><span class="badge badge-success">Green</span></label>
                        <input name="label" type="radio" id="radio-3" value="warning" <?php echo $checked_3; ?> >
                        <label for="radio-3" class="mr-30"><span class="badge badge-warning">Orange</span></label>
                        <input name="label" type="radio" id="radio-4" value="danger" <?php echo $checked_4; ?> >
                        <label for="radio-4" class="mr-30"><span class="badge badge-danger">Red</span></label>
                        <input name="label" type="radio" id="radio-5" value="primary" <?php echo $checked_5; ?> >
                        <label for="radio-5" class="mr-30"><span class="badge badge-primary">Purple</span></label>
                        <input name="label" type="radio" id="radio-6" value="cyan" <?php echo $checked_6; ?> >
                        <label for="radio-6" class="mr-30"><span class="badge badge-cyan">Cyan</span></label>
                        <input name="label" type="radio" id="radio-7" value="pink" <?php echo $checked_7; ?> >
                        <label for="radio-7" class="mr-30"><span class="badge badge-pink">Pink</span></label>
                        <input name="label" type="radio" id="radio-8" value="yellow" <?php echo $checked_8; ?> >
                        <label for="radio-8" class="mr-30"><span class="badge badge-yellow">Yellow</span></label>
                        <input name="label" type="radio" id="radio-9" value="brown" <?php echo $checked_9; ?> >
                        <label for="radio-9" class="mr-30"><span class="badge badge-brown">Brown</span></label>
                        <input name="label" type="radio" id="radio-10" value="dark" <?php echo $checked_10; ?> >
                        <label for="radio-10" class="mr-30"><span class="badge badge-dark">Black</span></label>
                        <input name="label" type="radio" id="radio-11" value="gray" <?php echo $checked_11; ?> >
                        <label for="radio-11" class="mr-30"><span class="badge badge-gray">Light Gray</span></label>
                        <input name="label" type="radio" id="radio-12" value="secondary" <?php echo $checked_12; ?> >
                        <label for="radio-12" class="mr-30"><span class="badge badge-secondary">Gray</span></label>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">                
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
