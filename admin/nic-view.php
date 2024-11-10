<?php
require 'config.php';

$page_title = 'User Authentication ';

/*---------------------------user details from user tb------------------------*/
if ( isset($_GET['id'])) {
    $id = $_GET['id'];
    $ud = new Users();
    $role_id = $ud->user($id)['role_id'];
    $full_name = $ud->user($id)['full_name'];
    $email = $ud->user($id)['email'];
    $designation = $ud->user($id)['designation'];
    $phone = $ud->user($id)['phone'];
    $image = $ud->user($id)['image'];
    $image_name = $ud->user($id)['image_name'];
    $town = $ud->user($id)['town'];
    $state = $ud->user($id)['state'];
    $country_name = $ud->user($id)['country_name'];
    $address_l1 = $ud->user($id)['address_1'];
    $address = $ud->user($id)['address_1'].'<br>'.$ud->user($id)['address_2'];
    $created = date('d-F-Y h:i A', strtotime($ud->user($id)['created']));
    $status = $ud->user($id)['status'];

    $nic = $ud->user($id)['nic'];

    $id_image = $ud->user($id)['id_image'];
    $id_image_name = $ud->user($id)['id_image_name'];
  
}

if ( $status == 1 ) {
    $status = "active";
    $status_label = "success";
}else{
    $status = "Disabled ";
    $status_label = "danger";
}

/*product count from product tb*/
$query = $db->query("SELECT COUNT(user_id) AS product_count FROM products WHERE user_id = '$id' ");
$row = $query->fetch_assoc();
$product_count = $row['product_count'];




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
                <div class="col-md-6">
                    <h3 class="page-title"><?php echo $full_name; ?></h3>
                </div>     
                <!--</div> -->
            </div>
        </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">       
                    <div class="box-header with-border">
                        <h4 class="box-title">User Details</h4>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table">
                                <?php if (( $role_id == 2 ) && ( isset( $image_name ) )): ?>
                                <tr>
                                  <td>Image</td>
                                  <td><img src="<?php echo $image; ?>" style="width: 10%;"></td>
                                </tr>
                                <?php endif; ?>

                                <?php if ( isset( $full_name ) ) :?>
                                <tr>
                                  <td>Full Name</td>
                                  <td><b><?php echo $full_name; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $email ) ) :?>
                                <tr>
                                  <td>Email</td>
                                  <td><b><?php echo $email; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $designation ) ) :?>
                                <tr>
                                  <td>Designation</td>
                                  <td><b><?php echo $designation; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $phone ) ) :?>
                                <tr>
                                  <td>Contact</td>
                                  <td><b><?php echo $phone; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $address_l1 ) ) :?>
                                <tr>
                                  <td>Address </td>
                                  <td><b><?php echo $address; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $town ) ) :?>
                                <tr>
                                  <td>Town</td>
                                  <td><b><?php echo $town; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $state ) ) :?>
                                <tr>
                                  <td>State</td>
                                  <td><b><?php echo $state; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $country_name ) ) :?>
                                <tr>
                                  <td>Country</td>
                                  <td><b><?php echo $country_name; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if (( $role_id == 2 ) && ( isset( $product_count ) )) :?>
                                <tr>
                                  <td>Total products</td>
                                  <td><b><?php echo $product_count; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $created ) ) :?>
                                <tr>
                                  <td>Join since</td>
                                  <td><b><?php echo $created; ?></b></td>
                                </tr>
                                <?php endif;?>

                                <?php if ( isset( $status ) ) :?>
                                <tr>
                                  <td>Available</td>
                                  <td ><span class="label label-<?php echo $status_label ?>"><?php echo $status; ?></span></td>
                                </tr>
                                <?php endif;?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="box">

                    <?php if (( strlen($id_image_name) <= 0 ) && ($nic == 0)) : ?>       
                    <div class="box-header with-border">
                        <h4 class="box-title">ID Image</h4>  
                    </div>
                    <div class="box-body">
                        <span class="badge badge-danger "><i class="mdi mdi-verified"></i>Not Verified</span>
                    </div>
                    <?php endif; ?>


                    <?php if (( isset( $id_image_name ) ) && ( strlen($id_image_name) > 0 )): ?>

                        <div class="box-header with-border">
                            <h4 class="box-title">ID Image</h4>

                            <?php if (( strlen($id_image_name) > 0 ) && ($nic == 2)) : ?>
                                <span class="badge badge-danger pull-right"><i class="mdi mdi-verified"></i> Rejected</span>
                            <?php endif; ?>

                            <?php if (( strlen($id_image_name) > 0 ) && ($nic == 0)) : ?>       
                                <span class="badge badge-warning pull-right"><i class="mdi mdi-verified"></i>Pending Verification</span>
                            <?php endif; ?>
                            
                            <?php if( $nic == 1 ): ?>
                            <span class="badge badge-success pull-right"><i class="mdi mdi-verified"></i> Verified</span>       
                            <?php endif; ?>
                        </div>

                        <form method="POST" id="form-nic-verification">
                            <div class="box-body">
                      
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <td colspan="2">
                                                <img src="<?php echo $id_image; ?>" style="width: 100%;">
                                                <input type="hidden" name="image_name" value="<?php echo $id_image_name; ?>">
                                                <input type="hidden" name="temp_id" value="<?php echo $id; ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="2">
                                                <div class="form-group">
                                                    <textarea class="form-control" rows="4" name="note" placeholder="Enter note here.."></textarea>
                                                </div>
                                            </td>
                                        </tr>

                                        <?php if( $nic == 0 ): ?>
                                        <tr>
                                            <td class="text-left "><a href="javascript:void(0);" class="btn btn-primary nic-verify">CONFIRM</a></td>
                                            <td class="text-right"><a href="javascript:void(0);" class="btn btn-danger nic-reject">REJECT</a></td>
                                        </tr>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </form>
                    <?php endif; ?>
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