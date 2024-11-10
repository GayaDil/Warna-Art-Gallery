<?php
require_once 'config.php';


if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $o = new Orders();
    $inquirires = $o->order_inquiries($id)['list'];
    $count = $o->order_inquiries($id)['count'];

    $od = new Orders();
    $customer_id = $od->order($id)['user_id'];

}



if ( $customer_id != $this_user_id ) {
    header('location:./');
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
                    <h1 class="page-title"><a href="artists">Warna Gallery</a></h1>
                </div>  
                <div class="right-title">
                    <a href="orders" class="btn btn-outline btn-primary">All Orders</a>
                    <a href="order-view?id=<?php echo $id; ?>" class="btn btn-outline btn-primary ml-10">Order View</a>
                </div>              
            </div>
        </div> 

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Order Inquiry</h4>
                        </div>
                        <div class="box-body">
                            <?php if ( $count == 0 ) : ?>
                            <div class="row mb-10">
                                <div class="col-12 text-center">
                                    <h5>No Inquiries for this order.</h5>
                                </div>
                            </div>
                            <?php else : ?>

                                <?php foreach( $inquirires  as $inquiry ) : ?>
                                    
                                    <div class="row mb-10">
                                        <?php if ( $inquiry['type_id'] == 2 ) : ?>
                                        <div class="col-12">
                                            <div class="inquiry-box-dark-offset">
                                                <h5><?php echo $inquiry['subject']; ?></h5>
                                                <p><?php echo $inquiry['note']; ?></p>
                                                <span class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s A', strtotime($inquiry['created'])); ?></span>
                                            </div>                                                
                                        </div>
                                        <?php else : ?>
                                        <div class="col-12">
                                            <div class="inquiry-box-dark">
                                                <h5><?php echo $inquiry['subject']; ?></h5>
                                                <p><?php echo $inquiry['note']; ?></p>
                                                <span class="pull-right"><i class="fa fa-clock-o"></i> <?php echo date('Y-m-d h:i:s A', strtotime($inquiry['created'])); ?></span>
                                            </div>
                                        </div>
                                        <?php endif; ?>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Place your Inquiry</h4>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                <select class="form-control" id="inquiry-subject" >
                                    <option value="">-------------- Subject --------------</option>
                                    <option value="Item not received">Item not received</option>
                                    <option value="Item has damaged">Item has damaged</option>
                                    <option value="Item as not it is on the product description">Item as not it is on the product description</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="6" id="inquiry-note" name="inquiry_note" placeholder="enter your inquiry here...."></textarea>
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0);" class="btn btn-outline btn-primary pull-right" id="place-inquiry" data-id="<?php echo $id; ?>">Submit</a>
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
