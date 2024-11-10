<?php
require 'config.php';

$role_id = 0;

/*---------General details -----------*/

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add_new_user">UPDATE</a>';
$temp_input = '';

if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update User';

  $us = new Users();
  $role_id = $us->user($get_id)['role_id'];
  $username = $us->user($get_id)['username'];
  $first_name = $us->user($get_id)['first_name'];
  $last_name = $us->user($get_id)['last_name'];
  $email = $us->user($get_id)['email'];
  $phone = $us->user($get_id)['phone'];
  $designation = $us->user($get_id)['designation'];
  $image = $us->user($get_id)['image'];
  $image_name = $us->user($get_id)['image_name'];
  $phone = $us->user($get_id)['phone'];
  $address_1 = $us->user($get_id)['address_1'];
  $address_2 = $us->user($get_id)['address_2'];
  $town = $us->user($get_id)['town'];
  $state = $us->user($get_id)['state'];
  $postcode = $us->user($get_id)['postcode'];
  $country_id = $us->user($get_id)['country_id'];
  $created = $us->user($get_id)['created'];

  $facebook_url = $us->user($get_id)['facebook_url'];
  $linkedin_url = $us->user($get_id)['linkedin_url'];
  $instagram_url = $us->user($get_id)['instagram_url'];


$account_number = $us->user($get_id)['account_number'];
$bank_name = $us->user($get_id)['bank'];
$branch_name = $us->user($get_id)['branch_name'];
$branch_code = $us->user($get_id)['branch_code'];

  $full_name = $us->user($get_id)['full_name'];

  

  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-user">UPDATE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';
  $img_upload_url = 'modal-artist-image-upload.php?id='.$get_id;

}

$page_title =  $full_name;

$country_list = '';
$query = $db->query("SELECT * FROM `countries` WHERE `status` = '1'");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){
    
        $cid = $row['id'];
        $cname = $row['name'];

        $selected = ( $cid == $country_id ) ? 'selected' : '';

        $country_list .= '<option value="'.$cid.'" '.$selected.'>'.$cname.'</option>';
    }
}

$list = '';
for ($i=0; $i < 3; $i++){

  	switch ($i) {
	    case 0:
	      $s_val = 1;
	      $s_text = 'Admin';
	      break;
	    case 1:
	      $s_val = 2;
	      $s_text = 'Artist';
	      break;
	    default:
	      $s_val = 3;
	      $s_text = 'User';
	      break;
	}

  	$selected = ( $s_val == $role_id ) ? 'selected' : '';

	$list .= <<<EOD
	<option value="$s_val" $selected>$s_text</option>
	EOD;

//$list .= '<option value="'.$s_val.'" '.$selected.'>'.$s_text.'</option>';

}


/*--------------other infomation---------------*/

$temp_info_list = '';
$query = $db->query("SELECT * FROM `artist_information_types`");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){    
        $ait_id = $row['id'];
        $ait_type = $row['type'];
        $temp_info_list .= '<option value="'.$ait_id.'">'.$ait_type.'</option>';
    }
}

$info_list = '';
$query = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$get_id'");
$rowCount = $query->num_rows;
if($rowCount > 0){
    while($row = $query->fetch_assoc()){    
        $id = $row['id'];
        $type_id = $row['type_id'];
        $description = $row['description'];
        $status = $row['status'];

        $temp_info_type_list = '';
		$queryType = $db->query("SELECT * FROM `artist_information_types`");
		$rowCountType = $queryType->num_rows;
		if($rowCountType > 0){
		    while($rowType = $queryType->fetch_assoc()){    
		        $ai_id = $rowType['id'];
		        $ai_type = $rowType['type'];
		        $ai_selected = ( $ai_id == $type_id ) ? 'selected' : '';
		        $temp_info_type_list .= '<option value="'.$ai_id.'" '.$ai_selected.'>'.$ai_type.'</option>';
		    }
		}

        $info_list .= '<div class="row"><div class="col-md-5"><div class="form-group"><label>Type</label><select class="form-control" name="info_type_id[]">'.$temp_info_type_list .'</select></div></div><div class="col-md-6"><input type="hidden" name="this_id[]" value="'.$id.'"><div class="form-group"><label>Description</label><input type="text" class="form-control" name="info_data[]" value="'.$description.'" placeholder="Enter ..." required></div></div><div class="col-md-1 d-flex justify-content-center align-items-center"><a href="javascript:void(0);" class="btn btn-danger btn-sm remove-information"><i class="fa fa-minus"></i></a></div></div>';
    }
}



/*--------------Service details---------------*/

$artist_services_arr = array();

$us = new Users();
$us_types = $us->artist_services($get_id);

foreach ( $us_types as $ust ) {
	array_push($artist_services_arr, $ust['service_id']);
}

$services_list = ''; 
$query = $db->query("SELECT * FROM `services` WHERE `status` = '1' ");
$rowCount = $query->num_rows;
	if($rowCount > 0 ){
        while ( $row = $query->fetch_assoc()) {
        $id = $row['id'];
        $type = $row['type'];

        $selected = ( in_array($id, $artist_services_arr) ) ? 'selected' : '';

        $services_list .= '<option value="'.$id.'" '.$selected.'>'.$type.'</option>';
    }
}


/*--------------Bank details---------------*/

$bank_temp_input = '';

$bank_temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';


$bank_save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-bank-admin">SUBMIT</a>';


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>
  <link rel="stylesheet" href="../assets/backend/vendor_components/croppie/croppie.min.css">
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
					<!-- Nav tabs -->
					<ul class="nav nav-tabs" role="tablist">
						<li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#general" role="tab"><span class="hidden-sm-up"><i class="ion-home"></i></span> <span class="hidden-xs-down">General Informations</span></a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#other" role="tab"><span class="hidden-sm-up"><i class="ion-person"></i></span> <span class="hidden-xs-down">Other Informations</span></a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#services" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Services</span></a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#privacy" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Update Password</span></a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#privacy-email" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Update Email</span></a> </li>
						<li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#bank" role="tab"><span class="hidden-sm-up"><i class="ion-email"></i></span> <span class="hidden-xs-down">Bank Details</span></a> </li>
						
						 
					</ul>
					<!-- Tab panes -->
					<div class="tab-content tabcontent-border">
						<div class="tab-pane active" id="general" role="tabpanel">
							<form role="form" method="POST" id="form-user">
						    	<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Personal Informations</h4>
						            </div>
						            <!-- /.box-header -->
						            <div class="box-body">
						              	<div class="row">

								            <div class="col-md-4">
								                <div class="form-group">
								                  <label>Select User Role</label>
								                  <select class="form-control" name="role_id" required>
								                    <?php echo $list; ?>
								                  </select>
								                </div>
								            </div>
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>First Name</label>
								                  	<input type="text" class="form-control" name="first_name" placeholder="Enter ..." value="<?php echo $first_name; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Last Name</label>
								                  	<input type="text" class="form-control" name="last_name" placeholder="Enter ..." value="<?php echo $last_name; ?>">
								                </div>
						              		</div>

						              		<?php if( $role_id == 2 ): ?>

						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Designation</label>
								                  	<input type="text" class="form-control" name="designation" placeholder="Enter ..." value="<?php echo $designation; ?>">
								                </div>
						              		</div>

						              		<?php endif; ?> 
						              		
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Phone</label>
								                  	<input type="text" class="form-control" name="phone" placeholder="Enter ..." value="<?php echo $phone; ?>">
								                </div>
						              		</div>

						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Country</label>
								                  	<select class="form-control" name="country_id" required>
					                              		<?php echo $country_list; ?>
					                                </select>
								                </div>
						              		</div>

						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Address Line 1</label>
								                  	<input type="text" class="form-control" name="address_1" placeholder="Enter ..." value="<?php echo $address_1; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Address Line 2</label>
								                  	<input type="text" class="form-control" name="address_2" placeholder="Enter ..." value="<?php echo $address_2; ?>">
								                </div>
						              		</div>


						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>State/ Province</label>
								                  	<input type="text" class="form-control" name="state" placeholder="Enter ..." value="<?php echo $state; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Town/City</label>
								                  	<input type="text" class="form-control" name="town" placeholder="Enter ..." value="<?php echo $town; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-4">
						              			<div class="form-group">
								                  	<label>Post Code</label>
								                  	<input type="text" class="form-control" name="postcode" placeholder="Enter ..." value="<?php echo $postcode; ?>">
								                </div>
						              		</div>

											<div class="col-md-3">
							                <div class="form-group">
							                
							                
							                </div>
							              	</div>

											<?php if( $role_id == 2 ): ?>							              	

							              	<div class="col-md-3">
							                <div class="form-group">
							                <label>Facebook Link </label>
							                <input type="text" class="form-control" name="facebook" placeholder="Enter ..." value="<?php echo $facebook_url; ?>">
							                </div>
							              	</div>

							              	<div class="col-md-3">
							                <div class="form-group">
							                <label>Linkedin Link </label>
							                <input type="text" class="form-control" name="linkedin" placeholder="Enter ..." value="<?php echo $linkedin_url; ?>">
							                </div>
							              	</div>


							              	<div class="col-md-3">
							                <div class="form-group">
							                <label>Instagram Link </label>
							                <input type="text" class="form-control" name="instagram" placeholder="Enter ..." value="<?php echo $instagram_url; ?>">
							                </div>
							              	</div>

							              	<div class="col-md-3">
							                <div class="form-group">
							                <label>Website Link </label>
							                <input type="text" class="form-control" name="website" placeholder="Enter ..." value="<?php echo $website; ?>">
							                </div>
							              	</div>
              														              	
							              	<?php endif; ?>



							              	<div class="col-md-6">
							                    <div class="form-group">
							                        <label class="d-block">Profile Image</label>
							                        <label class="file">
							                            <input type="file" accept="image/*" class="file-styled-primary" id="thumb_image" >
							                        </label>
							                    </div>
							                    <div class="row" style="">
							                        <div class="col-12" id="uploaded_thumb">
							                            <div id="thumb_image_demo" style=""></div>
							                            <input type="hidden" name="image" id="image_thumb" value="<?php echo $image_name; ?>">
							                        </div>

							                    </div>
							                    <div class="row">
							                        <div class="col-md-6">
							                            <p class="text-success" id="image-status"></p>
							                        </div>
							                        <div class="col-md-4 text-right">
							                            <span class="btn btn-info btn-sm thumb_crop">Apply</span>
							                        </div>
							                    </div>

							                </div>
							                <div class="col-md-6 d-flex" id="uploaded_image">
							                    <?php if (isset($image)) :?>
							                        <div class="d-flex align-items-center justify-content-center">
							                            <img src="<?php echo $image; ?>" style="width: 50%;">
							                        </div>

							                    <?php endif;?>
							                </div>


							              	


						              	</div>
						            </div>
						            <div class="box-footer text-right">
						            	<?php echo $temp_input; ?>
							            <?php echo $save_btn; ?>
						            </div>
						            <!-- /.box-body -->
						        </div>	       
						    </form>
						</div>
						<div class="tab-pane" id="other" role="tabpanel">
							<form role="form" method="POST" id="form-user-other-informations">
					   			<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Other Informations</h4>
						              <div class="pull-right">
						              	<a href="javascript:void(0);" class="btn btn-info btn-sm add-information"><i class="fa fa-plus"> ADD NEW</i></a>
						              </div>
						            </div>
						            <!-- /.box-header -->
						            <div class="box-body" id="information-types">
						              	<?php echo $info_list; ?>
						              	<input type="hidden" name="temp_id" value="<?php echo $get_id; ?>" >
						            </div>
						            <div class="box-footer text-right">
						            	<button type="submit" href="javascript:void(0);" class="btn btn-primary">UPDATE</button>	            		
						            </div>
						            <!-- /.box-body -->
						        </div>
						    </form>
						</div>
						<div class="tab-pane" id="services" role="tabpanel">
							<form role="form" method="POST" id="form-user-services">
						    	<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Services</h4>
						              <div class="pull-right">
						              	<!-- <input type="text" name="new_service">
						              	<button type="submit" href="javascript:void(0);" class="btn btn-primary" name="new-service">REQUEST NEW</button> -->
						              </div>
						            </div>
						            <!-- /.box-header -->
						            <div class="box-body">
						              	<div class="row">
						              		<div class="col-md-12">
												<div class="form-group">
													<select class="form-control select2" name="services[]" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
														<?php echo $services_list; ?>
													</select>
													<input type="hidden" id="user-id" name="temp_id" value="<?php echo $get_id; ?>" >
												</div>
						              		</div>
							              	
						              	</div>

						              	<div class="box-footer text-right">
								            	<button type="submit" name="check" href="javascript:void(0);" class="btn btn-primary">UPDATE</button>	            		
								            </div>
						            </div>

						            
						            <!-- /.box-body -->
						        </div>	       
						    </form>
						</div>
						<div class="tab-pane" id="privacy" role="tabpanel">
							<form role="form" method="POST" id="form-privacy-admin">
						    	<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Update Password</h4>
						            </div>
						            <!-- /.box-header -->
						            <div class="box-body">
						              	<div class="row">
						              		<div class="col-md-6">
						              			<div class="form-group">

								                  	<label>New Password</label>
								                  	<input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter ..." value="">

								                  	<label>Re-type Password</label>
								                  	<input type="password" id="re_password" class="form-control" name="re_password" placeholder="Enter ..." value="">
								                </div>
						              		</div>
						              	</div>

						              	<div class="box-footer text-right">
						              			<input type="hidden" class="form-control" name="temp_id" placeholder="Enter ..." value="<?php echo $get_id; ?>">
								            	<button type="submit" class="btn btn-primary" name="privacy">UPDATE</button>	
								                      		
								            </div>
						            </div>
						            <!-- /.box-body -->
						        </div>	       
						    </form>
						</div>
						<div class="tab-pane" id="privacy-email" role="tabpanel">
							<form role="form" method="POST" id="form-privacy-email-admin">
						    	<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Update Email</h4>
						            </div>

						            <!-- /.box-header -->
						            <div class="box-body">
						            	<div class="row">
						            	<div class="col-md-6" ><label> Current Email :<b> <?php echo $email; ?></b> </label> </div>
						            	</div>
						              	<div class="row">
						              		<div class="col-md-6">
						              			<div class="form-group">
								                  	<label>New Email</label>
								                  	<input type="email" id="new_email" class="form-control" name="new_email" placeholder="Enter ..." value="">

								                  
								                </div>
						              		</div>
						              	</div>

						              	<div class="box-footer text-right">
						              			<input type="hidden" class="form-control" name="temp_id" placeholder="Enter ..." value="<?php echo $get_id; ?>">
								            	<button type="submit" class="btn btn-primary" name="privacy-email">UPDATE</button>
								            </div>
						            </div>

						            
						            <!-- /.box-body -->
						        </div>	       
						    </form>
						</div>
						<div class="tab-pane " id="bank" role="tabpanel">
							<form role="form" method="POST" id="form-bank-admin">
						    	<div class="box">
						            <div class="box-header with-border">
						              <h4 class="box-title">Bank Details</h4>
						            </div>
						            <!-- /.box-header -->
						            <div class="box-body">
						              	<div class="row">
						              		<div class="col-md-6">
						              			<div class="form-group">
								                  	<label>Account Number</label>
								                  	<input type="text" class="form-control" name="account_number" placeholder="Enter ..." value="<?php echo $account_number; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-6">
						              			<div class="form-group">
								                  	<label>Bank Name</label>
								                  	<input type="text" class="form-control" name="bank_name" placeholder="Enter ..." value="<?php echo $bank_name; ?>">
								                </div>
						              		</div>
						              		<div class="col-md-6">
						              			<div class="form-group">
								                  	<label>Branch Name</label>
								                  	<input type="text" class="form-control" name="branch_name" placeholder="Enter ..." value="<?php echo $branch_name; ?>">
								                </div>
						              		</div>
						              		
						              		<div class="col-md-6">
						              			<div class="form-group">
								                  	<label>Branch Code</label>
								                  	<input type="text" class="form-control" name="branch_code" placeholder="Enter ..." value="<?php echo $branch_code; ?>">
								                </div>
						              		</div>
						              		
							                

						              	</div>
						            </div>
						           
						            <div class="box-footer text-right">
						            	<?php echo $bank_temp_input; ?>
							            <?php echo $bank_save_btn; ?>
						            </div>
						            
						            <!-- /.box-body -->
						        </div>	       
						    </form>
						</div>
						 
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


<script src="../assets/backend/vendor_components/croppie/croppie.min.js"></script>
<script>
    //Start - Croppie
    $image_thumb = $('#thumb_image_demo').croppie({
        enableExif: true,
        viewport: {
            width:240,
            height:240,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#thumb_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_thumb.croppie('bind', {
                url: event.target.result
            });
        };
        reader.readAsDataURL(this.files[0]);
        $('#uploaded_thumb').show();
    });


    $('.thumb_crop').click(function(event){

    	var user_id = $('#user-id').val();


        $image_thumb.croppie('result', {
            type: 'canvas',
            /*size: 'original'*/
            size: {
                width: 800,
                height: 800
            }
        }).then(function(response){

            $.ajax({
                url: "ajax/ajax-users.php",
                type: "POST",
                data: {"type":"upload_profile_picture","image":response ,"user_id":user_id},
                success: function (data) {
                    $('#image_thumb').val(data.filename);
                    $('#image-status').html(data.status);
                    var img = '<div class="d-flex align-items-center justify-content-center"><img src="'+data.file_with_path+'" style="width:50%;"></div>';
                    $('#uploaded_image').html(img);
                }
            });

        })
    });
    //End - Croppie
</script>





	
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

