<?php
require_once 'config.php';


if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$page_title =  "Update Email";

$u = new Users();
$email = $u->user($this_user_id)['email'];
$new_email = $u->user($this_user_id)['new_email'];

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
                        <h1 class="page-title"><a href="cart">Warna Profile</a></h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">

                <?php if ( strlen($new_email) > 0 ) :?>
                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-success alert-dismissible mb-40">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-check"></i> Email Verification link has been sent to your email address. Please check your emails to verify your new address and sign back in.</h5>
                    </div>
                  </div>    
                </div>
                <?php endif;?>




                <div class="row">
                    
                    <div class="col-12 col-md-3"> 
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        
                                        <tbody>
                                            <tr>
                                                <td ><a href="orders"><i class="fa fa-bullhorn "></i>  My Orders</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="profile"><i class="fa fa-bullhorn"></i>  General Details</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-email" class="custom-active"><i class="fa fa-bullhorn" ></i>  Update Email</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-password"><i class="fa fa-bullhorn"></i>  Update Password</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                                
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="box">

                            <div class="box-header">
                              <h4 class="box-title"><strong>Update Email</strong></h4>
                            </div>
                            <form  method="POST" id="form-user-email">
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12" >
                                                <label>Your Current Email :<b> <?php echo $email; ?></b> </label>
                                                <label class="mb-30">If you update your email you will need to verify this new address. Please note your new email will not be used by Warna until you have verified it.</b> </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>New Email</label>
                                                    <input type="email" id="new_email" class="form-control" name="new_email" placeholder="Enter ..." value="">

                                                    <label>Password</label>
                                                    <input type="password" id="e_password" class="form-control" name="e_password" placeholder="Enter ..." value="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="box-footer text-right">
                                                <button type="submit" class="btn btn-outline btn-primary" >UPDATE</button>
                                            </div>
                                    </div>
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
