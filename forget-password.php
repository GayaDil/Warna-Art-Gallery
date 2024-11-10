<?php
require_once 'config.php';

$page_title =  "Forget Passsword";

$msg = '';

if (isset($_POST['reset_password'])) {
    $email = $_POST['reset_email'];

    $validate = true;


    $query = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
    $rowCount = $query->num_rows;
    $row = $query->fetch_assoc();
    
    if($rowCount < 0){
        $validate = false;
        $msg .= '<div class="alert alert-danger"><strong><i class="fa fa-info-circle"></i> Email was not found!</strong></div>';
    }

    $user_id = $row['id'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];

    

    if ( $validate == true ) {
        $password_reset_link = 'warna'.time().rand(0,99999);
        $password_reset_link = sha1($password_reset_link);
        
        //Update password reset link
        $db->query("UPDATE `users` SET `email_verified_link`= '$password_reset_link' WHERE `id` = '$user_id'");

        //Send Email verification link

        $reciever_name = $first_name.' '.$last_name;
        $mail_subject = 'Password reset';

        $template = file_get_contents('email/password-reset.tpl');
        $reset_btn = $app_url.'reset-password?reset='.$password_reset_link;

        $template = str_replace("<!-- #{resetButton} -->", $reset_btn, $template);
        $template = str_replace("<!-- #{userFullName} -->", $reciever_name, $template);


        $mail = new Mail();
        $mail->send($reciever_name, $email, $mail_subject, $template );

        $msg .= '<div class="alert alert-success"><strong><i class="fa fa-check"></i> Password reset link has  been sent to your inbox!</strong></div>';

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
            <div class="row">
                <div class="col-md-12 ">
                    <?php echo $msg; ?>
                </div>

                <div class="col-12">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-4 mt-40" style="margin: 0 auto;" >
                            <div class="auth-2">
                                    <div class="auth-logo font-size-40">
                                    <a href="javascript:void(0);" ><b> Forget Password? </b></a>
                                    <h2 style="display:none;">Forget Your Password?</h2>
                                    </div>

                                    <!-- /.login-logo -->
                                    <div class="auth-body">
                                        <!-- <p class="auth-msg">Please enter the email you use to sign in to Warna </p> -->

                                        <p>Change your password in three easy steps. This will help you to secure your password!</p>
                                        <ol class="list-unstyled">
                                            <li><span class="text-primary text-medium">1. </span>Enter your email address below.</li>
                                            <li><span class="text-primary text-medium">2. </span>Our system will send you a temporary link</li>
                                            <li><span class="text-primary text-medium">3. </span>Use the link to reset your password</li>
                                        </ol>

                                        <form method="post" class="form-element mt-40" >
                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control" placeholder="Enter your Email..." name="reset_email" value="<?php echo $reset_email; ?>" required>
                                                <span class="ion ion-email form-control-feedback"></span>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 text-center">
                                                    <button type="submit" class="btn btn-outline btn-block mt-10 btn-primary"  name="reset_password">Request Password Reset</button>
                                                </div>
                                                <!-- /.col -->
                                            </div>
                                        </form>

                                        <div class="margin-top-30 text-center">
                                            <p><a href="login.php" class="text-info m-l-5">Back to Sign in</a></p>
                                        </div>

                                        <div class="margin-top-30 text-center">
                                            <p>Don't have an account? <a href="register.php" class="text-info m-l-5">Sign Up</a></p>
                                        </div>

                                    
                                    </div>
                            </div>
                        </div>
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
