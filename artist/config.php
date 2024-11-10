<?php
session_start();

require '../App/connection.php';

$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];
$this_user_username = $_SESSION['user']['username'];
$this_user_email = $_SESSION['user']['email'];

if ( $this_user_role_id != 2 ) {
	header('location:../');
}

require '../App/Paginations.php';
require '../App/Users.php';
require '../App/Mail.php';
require '../App/Categories.php';
require '../App/Products.php';
require '../App/Orders.php';
require '../App/ArtistPayments.php';


$u = new Users();
$email_verified = $u->user($this_user_id)['email_verified'];
$nic_verified = $u->user($this_user_id)['nic'];
$nic_image_status = $u->user($this_user_id)['id_image_status'];

$this_user_fullname = $u->user($this_user_id)['full_name'];

$email_not_verified = <<<EOD
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Please verify your Email Address</h4>
    Email Verification link has been sent to your email address. Please check your emails to verify your new address and sign back in.
</div>
EOD;

if ( $nic_image_status == 1 ) {
$nic_not_verified = <<<EOD
<div class="alert alert-warning alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Pending Admin Approval</h4>
     You will be recieved an email shortly once the admin approved your NIC.
</div>
EOD;
}else{
$nic_not_verified = <<<EOD
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i> Please verify your NIC</h4>
     Plesse verify your identity with an clear image of NIC/ Driving Licence/ Passport. Once it's done you will be able to start selling!
    <br>
    <a href="verify" class="btn btn-dark btn-sm mt-10">Verify Now!</a>
</div>
EOD;
}


if ( $nic_verified == 2 ) {
$nic_not_verified = <<<EOD
<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4><i class="icon fa fa-warning"></i>NIC Verification failed!</h4>
     Plesse verify your identity with an clear image of NIC/ Driving Licence/ Passport. Once it's done you will be able to start selling!
    <br>
    <a href="verify" class="btn btn-dark btn-sm mt-10">Verify Now!</a>
</div>
EOD;
}



?>