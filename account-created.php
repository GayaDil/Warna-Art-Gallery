<?php
require_once 'config.php';

$page_title = "Account Created";

if ( !isset( $_SESSION['user'] ) ) {
    header('location:login');
}


$ud = new Users();
$full_name = $ud->user($this_user_id)['full_name'];
$email = $ud->user($this_user_id)['email'];
$email_verified = $ud->user($this_user_id)['email_verified'];
$email_verified_link = $ud->user($this_user_id)['email_verified_link'];

if ( $email_verified == 1 ) {
    header('location:./');
}


if ( isset($_POST['resend'])) {

    if ( $email_verified == 0 ) {
        
        $mail_subject = 'Verify Your account';

        $email_verified_link = $app_url.'account-verify?verify_link='.$email_verified_link;

        $template = file_get_contents('email/account-verification.tpl');
        $template = str_replace("<!-- #{userFullName} -->", $full_name, $template);
        $template = str_replace("<!-- #{verifyLink} -->", $email_verified_link, $template);

        $mail = new Mail();
        $mail->send($full_name, $email, $mail_subject, $template );
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
         
            <!-- Main content -->
            <section class="content">
            
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-8">
                  <div class="box bb-3 border-primary">
                    <div class="card text-center">
                    <div class="box-header">
                      <h4 class="box-title">Welcome, <?php echo $full_name; ?></h4>
                      <h3 class="card-title bb-0"><i class="fa fa-envelope"></i> A verification link has been sent to "<strong><?php echo $email; ?></strong>"</h3>
                    </div>
                        <div class="card-body">
                            
                            <p class="card-text">Please click on the link that has just been sent to your email account to verify your email and continue the registration process.</p>

                            <form method="POST">
                                <p >Didn't receive an email? </p>
                                <button type="submit" class="btn btn-outline btn-primary" name="resend">Resend</button> 
                            </form>
                        </div>
                    </div>
                </div>
                 </div>
                <!-- /.col -->
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
