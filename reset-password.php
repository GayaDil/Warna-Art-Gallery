<?php
require_once 'config.php';

$page_title =  "Reset Passsword";

$err_msg = '';

if (isset($_POST['reset_password'])) {

    $user_id = $_POST['user_id'];
    $password = sha1($_POST['password']);

    $validate = true;

    if ( $_POST['password'] != $_POST['re_password'] ) {
        $validate = false;
        $err_msg .= '<div class="alert alert-danger"><strong>Password do not match!</strong></div>';
    }

    if ( strlen($_POST['password']) < 6 ) {
        $validate = false;
        $err_msg .= '<div class="alert alert-danger"><strong>Password must be minimum 6 characters.</strong></div>';
    }

    //Update password
    if ( $validate == true ) {
        $db->query("UPDATE `users` SET `password`= '$password' WHERE `id` = '$user_id'");

        //set temporary notification session
        $_SESSION['password_reset_notification'] = 'yes';

        header('location:login');
    }



}



if ( isset($_GET['reset'])) {
    $reset_link = $_GET['reset'];

    $user_id = 0;
    $query = $db->query("SELECT * FROM `users` WHERE `email_verified_link` = '$reset_link' ");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){       
            $user_id = $row['id'];
        }
    }
}

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
                    <!-- <h1 class="page-title"><a href="artists"></a></h1> -->
                </div>
            </div>
        </div> 

        <!-- Main content -->
        <section class="content">
            <?php if ( $user_id > 0 ): ?>
            <div class="row d-flex justify-content-center">
              <div class="col-md-4 mt-40">

                    <div class="auth-2">
                        <div class="auth-logo font-size-40">
                        <a href="javascript:void(0);" ><b> Reset Password </b></a>
                        <h2 style="display:none;">Forget Your Password?</h2>
                        </div>

                        <!-- /.login-logo -->
                        <div class="auth-body">
                        <p class="auth-msg">Please enter the email you use to sign in to Warna </p>

                        <?php echo $err_msg; ?>

                        <form method="post" class="form-element" >
                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Enter your new password..." name="password" required>
                                <span class="ion ion-email form-control-feedback"></span>
                                <p><small>(6 characters minimum)</small></p>
                            </div>

                            <div class="form-group has-feedback">
                                <input type="password" class="form-control" placeholder="Confirm your new password..." name="re_password" required>
                                <span class="ion ion-email form-control-feedback"></span>
                            </div>

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-outline btn-block mt-10 btn-primary"  name="reset_password">Reset Password </button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                        <div class="margin-top-30 text-center">
                            <p><a href="login.php" class="text-info m-l-5">Back to Sign in</a></p>
                        </div>
                        </div>
                    </div>
              </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger"><strong>Wrong password reset link or the user has been removed. please contact admin.</strong></div>
                </div>
            </div>
            <?php endif; ?>
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
