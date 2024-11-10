<?php
require_once 'config.php';

$page_title = "Account Verify";

$err_msg = '';

/*if ( !isset( $_SESSION['user'] ) ) {
    header('location:login');
}*/


if ( isset($_GET['verify_link'])) {
    $verify_link = $_GET['verify_link'];

    $user_id = 0;
    $query = $db->query("SELECT * FROM `users` WHERE `email_verified_link` = '$verify_link' ");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){       
            $user_id = $row['id'];
            $new_email = $row['new_email'];
            $email_verified = $row['email_verified'];
            $email_verified_link = $row['email_verified_link'];
        }
    }

    if ( $email_verified == 1 ) {
        $err_msg = '<div class="alert alert-success"><strong>Your account already has been verified!</strong></div>';
    }


    if ( ($email_verified != 1) && (strlen($new_email) > 0) ){

        if ( $verify_link == $email_verified_link ) {
            $db->query("UPDATE `users` SET `email`='$new_email', `new_email`= null, `email_verified`= 1, `email_verified_time`= '$now' WHERE `id` = '$user_id' ");

            $err_msg = '<div class="alert alert-success">  
                            <strong>New Email Has Been Updated!</strong>
                            <strong>Account Verified!</strong>
                        </div>';

            unset($_SESSION['user']);

            
        }

    }elseif ( $email_verified != 1 ) {

        if ( $verify_link == $email_verified_link ) {
            $db->query("UPDATE `users` SET `email_verified`= 1, `email_verified_time`= '$now' WHERE `id` = '$user_id' ");

            $err_msg = '<div class="alert alert-success"><strong>Account Verified!</strong></div>';
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
         
            <!-- Main content -->
            <section class="content">
            
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-6">
                  <div class="box bb-3 border-primary">
                    <div class="card text-center">
                    
                        <div class="card-body">

                            <h2 style="display:none;"> Warna Account Verify</h2>
                            
                            <?php echo $err_msg; ?>

                            <?php if ($role_id == 2) : ?>
                            <a class="btn btn-outline btn-primary" href="artist/verify"> <span> EDIT PROFILE </span> </a> 

                            <?php else: ?>

                            <hr>
                            <a class="btn btn-outline btn-primary" href="./"> <span> GOTO HOMEPAGE </span> </a>

                            <?php endif; ?>
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
