<?php 
require_once 'App/connection.php';
require_once 'config.php';

$page_title =  "Register";

if ( isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$err_msg = '';
$cc = new Cart();
$count = $cc->cart_count();

$cust_checked = 'checked';
$artist_checked = '';

if (isset($_POST['register'])) {
    $role_id = $db->real_escape_string($_POST['role_id']);
    $username = $db->real_escape_string($_POST['email']);
    $password = sha1($_POST['password']);
    $first_name = $db->real_escape_string($_POST['first_name']);
    $last_name = $db->real_escape_string($_POST['last_name']);
    $email = $db->real_escape_string($_POST['email']);
    $status = $db->real_escape_string($_POST['status']);

    $validate = true;

    $query = $db->query("SELECT * FROM `users` WHERE `email` = '$email'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        $validate = false;
        $err_msg .= '<div class="alert alert-danger"><strong>Email already exist!</strong></div>';
    }

    if ( $_POST['password'] != $_POST['re_password'] ) {
        $validate = false;
        $err_msg .= '<div class="alert alert-danger"><strong>Password do not match!</strong></div>';
    }

    if ( strlen($_POST['password']) < 6 ) {
        $validate = false;
        $err_msg .= '<div class="alert alert-danger"><strong>Password must be minimum 6 characters.</strong></div>';
    }



    if ( $validate == true ) {
        $email_verified_link = 'warna'.time();
        $email_verified_link = sha1($email_verified_link);
        $db->query("INSERT INTO `users`( `role_id`, `username`, `password`, `email`, `first_name`, `last_name`, `image`, `status`, `created`, `email_verified`, `email_verified_link`, `nic`) VALUES ('$role_id', '$username', '$password', '$email', '$first_name', '$last_name', 'temp', '1', '$now', 0, '$email_verified_link', 0)");
        $last_id = $db->insert_id;

        //Create folder
        $folder_path = 'assets/artists/'.$last_id;
        mkdir($folder_path);

        //Send Account verification email
        $reciever_name = $first_name.' '.$last_name;
        $mail_subject = 'Verify Your account';

        $email_verified_link = $app_url.'account-verify?verify_link='.$email_verified_link;

        $template = file_get_contents('email/account-verification.tpl');
        $template = str_replace("<!-- #{userFullName} -->", $reciever_name, $template);
        $template = str_replace("<!-- #{verifyLink} -->", $email_verified_link, $template);


        $mail = new Mail();
        $mail->send($reciever_name, $email, $mail_subject, $template );

        $_SESSION['user']['id'] = $last_id;
        $_SESSION['user']['role'] = $role_id;
        $_SESSION['user']['username'] = $username;
            
        header('location:account-created');
      //$msg = 'record added';
    }


    $artist_checked = ( $role_id == 2 ) ? 'checked' : '';
    $cust_checked = ( $role_id == 3 ) ? 'checked' : '';
    

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
            
            <div class="row d-flex justify-content-center">
              <div class="col-md-4 mt-40">

                <div class="auth-2-outer row align-items-center h-p100 m-0">
                    <div class="auth-2">
                        <div class="auth-logo font-size-40">
                            <a href="register" ><b>Warna </b>Registration</a>
                            <!-- <a href="register" class="text-white"><b>Warna </b>Registration</a> -->
                            <h2 style="display:none;"> Warna Registration</h2>
                        </div>
                      <!-- /.login-logo -->
                      <div class="auth-body">
                          <p class="auth-msg">Register a new Membership</p>

                          <?php echo $err_msg; ?>

                          <form  method="post" class="form-element" >
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control" placeholder="First name" name="first_name" value="<?php echo $first_name; ?>" required>
                                  <span class="ion ion-person form-control-feedback "></span>
                              </div>
                              <div class="form-group has-feedback">
                                  <input type="text" class="form-control" placeholder="Last name" name="last_name" value="<?php echo $last_name; ?>" required>
                                  <span class="ion ion-person form-control-feedback "></span>
                              </div>
                              <div class="form-group has-feedback">
                                  <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                                  <span class="ion ion-email form-control-feedback "></span>
                              </div>
                              <div class="form-group has-feedback">
                                  <input type="password" class="form-control" placeholder="Password" name="password"  required>
                                  <span class="ion ion-locked form-control-feedback "></span>
                              </div>
                              <div class="form-group has-feedback">
                                  <input type="password" class="form-control" placeholder="Retype password" name="re_password"  required>
                                  <span class="ion ion-log-in form-control-feedback "></span>
                              </div>
                              <div class="row">
                                <div class="col-6">
                                  <div class="">
                                      <input id="customer" type="radio" name="role_id" value="3" <?php echo $cust_checked; ?> >
                                      <label for="customer"><span></span>Customer </label>
                                  </div>
                                </div>
                                <div class="col-6">
                                  <div class="">
                                      <input id="artist" type="radio"  name="role_id" value="2" <?php echo $artist_checked; ?> >
                                      <label for="artist"><span></span>Artist </label>
                                  </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-outline btn-block mt-10 btn-primary" name="register">SIGN UP</button>
                                </div>
                                <!-- /.col -->
                              </div>
                            </form>

                      <div class="margin-top-30 text-center">
                        <p>Already have an account? <a href="login.php" class="text-info m-l-5">Sign In</a></p>
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
