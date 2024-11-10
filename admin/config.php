<?php
session_start();

require '../App/connection.php';

$this_user_id = $_SESSION['user']['id'];
$this_user_role_id = $_SESSION['user']['role'];
$this_user_username = $_SESSION['user']['username'];
$this_user_email = $_SESSION['user']['email'];





if ( $this_user_role_id != 1 ) {
	header('location:../');
}

/*if (!class_exists('Products')) {
	require 'Products.php';
}
if (!class_exists('Users')) {
	require 'Users.php';
}
if (!class_exists('Categories')) {
	require 'Categories.php';
}
if (!class_exists('Orders')) {
	require 'Orders.php';
}
if (!class_exists('Mediums')) {
	require 'Mediums.php';
}
if (!class_exists('Blogs')) {
	require 'Blogs.php';
}*/

require '../App/Paginations.php';
require '../App/Products.php';
require '../App/Users.php';
require '../App/Categories.php';
require '../App/Services.php';
require '../App/Orders.php';
require '../App/Mediums.php';
require '../App/Blogs.php';
require '../App/ArtistPayments.php';

require '../App/Mail.php';



$tu = new Users();
$this_user_fullname = $tu->user($this_user_id)['full_name'];
?>