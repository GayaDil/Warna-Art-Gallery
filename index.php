<?php
require_once 'config.php';

$page_title =  "Home";

$cc = new Cart();
$count = $cc->cart_count();

$np = new Homepage();
$n_products = $np->new_products();

$bl = new Homepage();
$n_blogs = $bl->new_blogs(2);

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

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                      <img class="card-img-top" src="assets/images/slider.jpg" alt="Card image cap">
                      
                    </div>
                </div>
            </div>
            
         
            <!-- Main content -->
            <section class="content">


                <div class="col-12">
                    
                    <!-- START Card With Image -->
                    <div class="row fx-element-overlay">

                        <?php foreach ($n_products as $npr):?>

                        <div class="col-md-12 col-lg-3">
                            <div class="box box-default">
                                <div class="fx-card-item">
                                    <div class="fx-card-avatar fx-overlay-1"> <img src="<?php echo $npr['image']; ?>" alt="<?php echo $npr['title']; ?>"/>
                                        <div class="fx-overlay">
                                            <ul class="fx-info">
                                                <li><a class="btn default btn-outline image-popup-vertical-fit" href="product?id=<?php echo $npr['id']; ?>"><i class="ion-search"></i></a></li>

                                                <?php if ( $npr['post_method'] == 1 ) :?>

                                                <li><a class="btn default btn-outline add-this-to-cart" href="javascript:void(0);" data-id="<?php echo $npr['id']; ?>" data-quantity="1"><span class="fa fa-shopping-cart"></span> Add to Cart </a></li>

                                                <?php elseif ( $npr['post_method'] == 2 ) :?>

                                                <li><a class="btn default btn-outline add-this-to-cart" href="product?id=<?php echo $npr['id']; ?>" data-id="<?php echo $npr['id']; ?>" data-quantity="1"><span class="fa fa-gavel"></span> bid </a></li>

                                                <?php endif;?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="fx-card-content">
                                        <h3 class="box-title"><a href="product?id=<?php echo $npr['id']; ?>"><?php echo $npr['title']; ?></a></h3> 
                                        <?php if ( $npr['post_method'] != 2 ) :?>   
                                        <span class="amount"> Rs.<?php echo $npr['price_label']; ?> </span> 
                                        <?php endif;?>
                                        <br> 
                                    </div>
                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->

                        <?php endforeach; ?>      

                    </div>
                    <!-- /.row -->
                    <!-- END Card with image -->

                    <!-- Start - pagination -->
                    <?php echo $pagination; ?> 
                    <!-- End - pagination --> 
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
