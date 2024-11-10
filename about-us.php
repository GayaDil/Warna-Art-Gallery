<?php
require_once 'config.php';

$page_title =  "About us";

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
                    <h1 class="page-title"><a href="artists">About Warna</a></h1>
                </div>
            </div>
        </div> 

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                        <div class="col-6 p-40 text-center">

                            <h6 class="mb-30">
                                Welcome to our website!
                                The Warna Art Gallery aims to allow contemporary artists to exhibit and sell their works in a simple and intuitive way. We provides artists from around the Sri Lanka with an expertly curated environment in which to exhibit and sell their work. 
                            </h6>

                            
                            <h6 class="mb-30" >
                                The Warna Art Gallery is a place where showcasing of arts, paintings, works of different artists. It has come with its own advantage that we could see different arts from different artists altogether at the same place. 
                            </h6>

                            <h6>With The Warna Art Gallery we are redefining the experience of buying and selling art by making it easy, convenient and welcoming for collectors, art lovers and artists alike.</h6>
                        </div>
                        <div class="col-6 p-0">
                            <img src="assets/images/slider.jpg" alt=""/>
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
