
<?php
require_once 'App/connection.php';
require_once 'config.php';

$page_title =  "Login";

if ( isset( $_SESSION['user'] ) ) {
    header('location:./');
}


$msg = '';
if (isset($_POST['login'])) {
  $username = $_POST['username'];
 /* $email = $_POST['email'];*/
  $password = sha1($_POST['password']);

 
  $query = $db->query("SELECT * FROM `users` WHERE `username` = '$username' AND `password` = '$password' ");
  /*$query = $db->query("SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$password' ");*/

 
  $rowCount = $query->num_rows;  
  if($rowCount > 0){

    while($row = $query->fetch_assoc()){
        $get_username = $row['username'];
        $get_password = $row['password'];
        $get_email = $row['email'];
        $get_user_id = $row['id'];
        $get_user_role = $row['role_id'];
        $get_status = $row['status'];         
    }

    /*if($get_email == $get_email && $get_password == $password ) {*/
    if($get_username == $username && $get_password == $password ) {

      session_start();

      $_SESSION['user']['id'] = $get_user_id;
      $_SESSION['user']['role'] = $get_user_role;
      $_SESSION['user']['username'] = $get_username;
      $_SESSION['user']['email'] = $get_email;


      /*switch ($get_user_role) {
        case 1:
          header("location:admin/");
          break;
        case 2:
          header("location:artist/");
          break;
        case 3:
          header("location:user/");
          break;
        default:
          header("location:./");
          break;
      }*/
    
      
      header("location:./");

    }else{
        $msg = '<div class="alert alert-danger">
                Username or password is incorrect!
              </div>';
    }
  }else{
      $msg = '<div class="alert alert-danger">
                  Username or password is incorrect!
                </div>';
  }

}


if (isset($_SESSION['password_reset_notification'])) {
  $msg = '<div class="alert alert-success">Password has been reset!. Enter your new credentials to start your session</div>';
  unset($_SESSION['password_reset_notification']);  
}

if (isset($_SESSION['password_update_notification'])) {
  $msg = '<div class="alert alert-success">Password has been updated!. Enter your new credentials to start your session</div>';
  unset($_SESSION['password_update_notification']);  
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

                    <div class="auth-2">
                        <div class="auth-logo font-size-40">
                        <a href="login" ><b>Warna </b>Login</a>
                        <h2 style="display:none;"> Warna Login</h2>
                        </div>

                        <!-- /.login-logo -->
                        <div class="auth-body">
                        <p class="auth-msg">Sign in to start your session</p>

                        <?php echo $msg; ?>

                        <form method="post" class="form-element" >
                          <div class="form-group has-feedback">
                              <input type="text" class="form-control" placeholder="Email" name="username" value="<?php echo $username; ?>" required>
                              <span class="ion ion-email form-control-feedback"></span>
                          </div>
                          <div class="form-group has-feedback">
                              <input type="password" class="form-control" placeholder="Password" name="password" required>
                              <span class="ion ion-locked form-control-feedback"></span>
                          </div>
                          <div class="row">
                              <!-- /.col -->
                              <div class="col-12">
                                 <div class="fog-pwd">
                                  <a href="forget-password" class="text-white"><i class="ion ion-locked"></i> Forgot password?</a><br>
                                  </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-12 text-center">
                                  <button type="submit" class="btn btn-outline btn-block mt-10 btn-primary"  name="login">SIGN IN</button>
                              </div>
                              <!-- /.col -->
                          </div>
                        </form>

                        <div class="margin-top-30 text-center">
                          <p>Don't have an account? <a href="register.php" class="text-info m-l-5">Sign Up</a></p>
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
