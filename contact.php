<?php
require_once 'config.php';

$page_title =  "Contact";


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
                    <h1 class="page-title"><a href="artists">Contact Warna</a></h1>
                </div>
            </div>
        </div> 

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-3  ">
                    <div class="box">
                        <div class="pad ">
                            <div class="p-20 m-5 b-1">
                                <h3 class="mb-20"><strong>Contact Us</strong></h3>

                                <h6><i class="fa fa-envelope"></i> Email: <span class="text-primary">warna@gmail.com</span></h6>

                                <h6><i class="fa fa-phone"></i> Phone: <span class="text-primary">+94071234567</span></h6>

                                <h6><i class="fa fa-fax" ></i> Fax: <span class="text-primary">+94071234567</span></h6>
                                
                            </div>
                        </div>    
                    </div>
                </div>


                <div class="col-md-7 ml-auto mr-auto ">
                    <div class="box">                      
                        <div class="box-header">
                          
                            <h6 class="mt-5">For questions or concerns, please use the form below.</h6>
                        </div>
                        <form id="form-inquiry">
                            <div class="pad p-20">

                                <div class="row">
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="billing_email">Email Address *</label>
                                      <input type="email" class="form-control" name="email" id="billing_email" placeholder="Enter email"  value="<?php echo $email; ?>" required /> </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="billing_phone">Phone </label>
                                      <input type="text" class="form-control" name="phone" id="billing_phone" placeholder="Enter Phone"  value="<?php echo $phone; ?>" required /> </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="shipping_first_name">First Name *</label>
                                      <input type="text" class="form-control " name="first_name" id="shipping_first_name" placeholder=""  value="<?php echo $first_name; ?>" required  /> </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label for="shipping_last_name">Last Name *</label>
                                      <input type="text" class="form-control " name="last_name" id="shipping_last_name" placeholder=""  value="<?php echo $last_name; ?>" required /> </div>
                                  </div>
                                  
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label for="shipping_state">Title *</label>
                                      <input type="text" class="form-control " name="title" id="title" placeholder="Title"  value="<?php echo $title; ?>" required /> </div>
                                  </div>
                                                                 
                                </div>
                                <div class="row">
                                  <div class="col-12">
                                    <div class="form-group">
                                      <label for="order_comments">Description</label>
                                      <textarea name="description" class="form-control " id="description" placeholder="Enter description here..." rows="4" value="<?php echo $description; ?>"></textarea> 
                                  </div>
                                  </div>
                                </div>

                                <div class="form-group mt-20 pb-20">
                                <input type="hidden" class="form-control " name="temp_id"   value="<?php echo $order_id; ?>" required />

                                <input type="submit" class="btn btn-outline btn-primary pull-right" name="user_inquiry" id="user-inquiry" value="SUBMIT"  />
                            
                                </div> 
                      
                            </div>
                        </form>
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
