<?php
session_start();
require_once 'App/connection.php';

//Server URL
$app_url = 'http://localhost/warna2/3/';
$admin_email_address = 'e151041105@bit.uom.lk';

$now = date('Y-m-d H:i:s', time());

$this_user_id = 0;

if ( isset( $_SESSION['user'] ) ) {

    $this_user_id = $_SESSION['user']['id'];
	$this_user_role_id = $_SESSION['user']['role'];
	$this_user_username = $_SESSION['user']['username'];
	$this_user_email = $_SESSION['user']['email'];

}


require 'App/Paginations.php';
require 'App/Homepage.php';
require 'App/Products.php';
require 'App/Cart.php';
require 'App/Orders.php';
require 'App/Users.php';
require 'App/Categories.php';
require 'App/Mediums.php';
require 'App/Blogs.php';
require 'App/Mail.php';
require 'App/ArtistPayments.php';

$u = new Users();
$this_user_fullname = $u->user($this_user_id)['full_name'];

//Meta varialbles
$meta_page_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")."://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$meta_page_title = 'warna.lk official website!';
$meta_page_description = '';
$meta_page_image = '';
?>