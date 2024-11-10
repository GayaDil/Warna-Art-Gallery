<?php
require 'config.php';


if (isset($_POST['check'])) {
	print_r($_POST['services']);
	exit();
}

$arrr = array(2,5,6);

/*--------------Artist other infomation from artist_informations tb---------------*/

$services_list = ''; 
$query = $db->query("SELECT * FROM `services` WHERE `status` = '1' ");
$rowCount = $query->num_rows;
	if($rowCount > 0 ){
        while ( $row = $query->fetch_assoc()) {
        $id = $row['id'];
        $type = $row['type'];

        $selected = ( in_array($id, $arrr) ) ? 'selected' : '';

        $services_list .= '<option value="'.$id.'" '.$selected.'>'.$type.'</option>';
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
    <section class="content" id="form-section">

    	<!-- Start - Notify if not verified -->
	      <?php if ( $nic_verified == 0 ) : ?>
	        <?php echo $nic_not_verified; ?>
	      <?php endif; ?>
      	<!-- End - Notify if not verified -->

      	<div class="row">
      		
      		<div class="col-12">
				<div class="box-body">
					<div class="tab-pane" id="other" role="tabpanel">
						<form role="form" method="POST" id="">
				   			<div class="box">
					            <div class="box-header with-border">
					              <h4 class="box-title">Services</h4>
					              <div class="pull-right">
					              	<a href="javascript:void(0);" class="btn btn-info btn-sm add-information"><i class="fa fa-plus"> ADD NEW</i></a>
					              </div>
					            </div>
					            <!-- /.box-header -->
					            <div class="box-body" id="information-types">
					              	<div class="form-group">
										<label>Multiple</label>
										<select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
										<?php echo $services_list; ?>
										</select>
									  </div>
					            </div>
					            <div class="box-footer text-right">
					            	<button type="submit" name="check" href="javascript:void(0);" class="btn btn-primary">SAVE</button>	            		
					            </div>
					            <!-- /.box-body -->
					        </div>
					    </form>
					</div>
				</div>
				<!-- /.box-body -->
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
			
		$(document).ready(function(){

			var wrapper = $('#form-section');

			$(wrapper).on('click', '.add-information', function(e){
				e.preventDefault();

				var types = '<?php echo $temp_info_list; ?>';

				console.log(types);

				var el = '<div class="row"><div class="col-md-5"><div class="form-group"><label>Type</label><select class="form-control" name="info_type_id[]">'+types+'</select></div></div><div class="col-md-6"><input type="hidden" name="this_id[]" value="0"><div class="form-group"><label>Description</label><input type="text" class="form-control" name="info_data[]" placeholder="Enter ..." required></div></div><div class="col-md-1 d-flex justify-content-center align-items-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm remove-information"><i class="fa fa-minus"></i></a></div></div>';

				$('#information-types').append(el);
			});


			$(wrapper).on('click', '.remove-information', function(e){
				e.preventDefault();
				$(this).parent().parent().remove();				
			});

		});



	</script>
</body>
</html>

<div class="row">
	<div class="col-md-5">
		<div class="form-group">
			<label>Type</label>
			<select class="form-control" name="info_type_id[]">'+types+'</select>
		</div>
	</div>
	<div class="col-md-6">
		<input type="hidden" name="this_id[]" value="0">
		<div class="form-group">
			<label>Description</label>
			<input type="text" class="form-control" name="info_data[]" placeholder="Enter ..." required>
		</div>
	</div>
	<div class="col-md-1 d-flex justify-content-center align-items-center">
		<a href="javascript:void(0);" class="btn btn-danger btn-sm remove-information">
			<i class="fa fa-minus"></i>
		</a>
	</div>
</div>

