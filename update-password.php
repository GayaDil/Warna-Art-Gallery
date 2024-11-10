<?php
require_once 'config.php';


if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$page_title =  "Update Passsword";

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
                                                <td ><a href="update-email"><i class="fa fa-bullhorn"></i>  Update Email</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-password" class="custom-active"><i class="fa fa-bullhorn"></i>  Update Password</a></td>
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
                              <h4 class="box-title"><strong>Update Password</strong></h4>
                            </div>
                            <form method="POST" id="form-user-password" >
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Current Password</label>
                                                    <input type="password" id="current_password" class="form-control" name="current_password" placeholder="Enter ..." value="">

                                                    <label>New Password</label>
                                                    <input type="password" id="new_password" class="form-control" name="new_password" placeholder="Enter ..." value="">

                                                    <label>Re-type Password</label>
                                                    <input type="password" id="re_password" class="form-control" name="re_password" placeholder="Enter ..." value="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-footer text-right">
                                                <button type="submit" class="btn btn-outline btn-primary" > UPDATE </button>                 
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
