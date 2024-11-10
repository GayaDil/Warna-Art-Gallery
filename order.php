<?php
require_once 'config.php';

$page_title =  "Update shipping details";

if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}



if ( isset($_GET['id'])) {
    $order_id = $_GET['id'];


    $od = new Orders();
    $customer_id = $od->order($order_id)['user_id'];
    $first_name = $od->order($order_id)['first_name'];
    $last_name = $od->order($order_id)['last_name'];
    $full_name = $od->order($order_id)['full_name'];
    $email = $od->order($order_id)['email'];
    $phone = $od->order($order_id)['phone'];
    $address_1 = $od->order($order_id)['address_1'];
    $address_2 = $od->order($order_id)['address_2'];
    $town = $od->order($order_id)['town'];
    $state = $od->order($order_id)['state'];
    $postcode = $od->order($order_id)['postcode'];
    $country_id = $od->order($order_id)['country_id'];
    $note = $od->order($order_id)['note'];
    $created = date('d-F-Y h:i A', strtotime($od->order($order_id)['created']));




    $this_status = $od->order($order_id)['status'];

    //status allow array
    $allow_arr = array(1,2,3,4);

    if ( !in_array($this_status, $allow_arr) ) {
        header('location:./');
    }



    $status = ( $od->order($order_id)['status'] == 6 ) ? 7 : $od->order($order_id)['status'];//Mark as completed if the status is after mark as collected

    $os = new Orders();
    $status_type = $os->order_status($status)['type'];
    $status_label = $os->order_status($status)['label'];

    //address
    $country = new Users();
    $country_name = $country->country($country_id)['name'];

    $address = $od->order($order_id)['address_1'].'<br>'.$od->order($order_id)['address_2'].'<br>'.$od->order($order_id)['town'].'<br>'.$od->order($order_id)['state'].'<br>'.$od->order($order_id)['postcode'].'<br>'.$country_name;


    $country_list = '';
    $query = $db->query("SELECT * FROM `countries` WHERE `status` = '1'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){
        
            $cid = $row['id'];
            $cname = $row['name'];

            $selected = ( $cid == $country_id ) ? 'selected' : '';

            $country_list .= '<option value="'.$cid.'" '.$selected.'>'.$cname.'</option>';
        }
    }





    $op = new Orders();
    $items = $op->order_products($order_id)['items'];
    $sub_total = $op->order_products($order_id)['general']['sub_total_label'];
    $order_total = $op->order_products($order_id)['general']['total'];
    $total = $op->order_products($order_id)['general']['total_label'];
    $rejected_total = $op->order_products($order_id)['general']['rejected_total'];
    $rejected_total_label = $op->order_products($order_id)['general']['rejected_total_label'];




    /* Product detatils*/
    $list = '';
    foreach ($items as $item) {

    $op_id = $item['id'];

    $product_id = $item['product_id'];
    $image = $item['image'];
    $title = $item['title'];
    $price_label = $item['price_label'];
    $quantity = $item['quantity'];
    $total_label = $item['total_label'];
    $op_status = $item['status'];
      

    if ( $status > 1 ) {   

        if ( $op_status == 1 ) {
          $op_status = "Approved";
          $op_status_label = "success";
        }
        else{
          $op_status = "Rejected";
          $op_status_label = "danger";
        }

    }else{

        $op_status = "Awaiting artist approval";
        $op_status_label = "warning";

    }
     
        $list .= <<<EOD
        <tr>
        <td class="vertical-middle">$product_id</</td>
        <td class="vertical-middle" style="width: 10%;"><img src=$image></td>
        <td class="vertical-middle">$title</td>
        <td class="vertical-middle">$price_label</td>
        <td class="vertical-middle">$quantity</td>
        <td class="vertical-middle">$total_label</td>
        <td class="text-center vertical-middle"><span class="badge badge-$op_status_label">$op_status</span></td>
      
        <td class="text-right vertical-middle">
            <a class="btn btn-outline btn-info btn-xs simple-ajax-modal " href="order-product-status-view?id=$op_id">
            <i class="fa fa-search"></i>
            </a>
        </td>
      </tr>
      EOD;
    }


if ( $customer_id != $this_user_id ) {
    header('location:./');
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

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1 class="page-title"><a href="checkout">Warna Checkout</a></h1>
                    </div>
                    <div class="right-title">
                    <a href="orders" class="btn btn-outline btn-primary">All Orders</a>
                    <a href="order-view?id=<?php echo $order_id; ?>" class="btn btn-outline btn-primary ml-10">Order View</a>
                </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
              
                

                <form method="POST" id="form-shipping">
                    <div class="row">  
                    
                        <div class="col-md-6 ">
                            <div class="box">                      
                                <div class="box-header">
                                  <h4 class="box-title"><strong>Shipping Details</strong></h4>
                                </div>
                                <div class="pad p-20">

                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="billing_email">Email Address *</label>
                                          <input type="email" class="form-control" name="email" id="billing_email" placeholder="Enter email"  value="<?php echo $email; ?>" required /> </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="billing_phone">Phone *</label>
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
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_address_1">Address 1 *</label>
                                          <input type="text" class="form-control " name="address_1" id="shipping_address_1" placeholder="Street Name"  value="<?php echo $address_1; ?>" required /> </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_address_2">Address 2</label>
                                          <input type="text" class="form-control" name="address_2" id="shipping_address_2" placeholder="Apartment Name, No.. etc"  value="<?php echo $address_2; ?>"  /> </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_country">Country * </label>
                                            <select class="form-control" style="width: 100%;" name="country_id" id="shipping_country">
                                                <?php echo $country_list; ?>
                                          </select>
                                          </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_state">State *</label>
                                          <input type="text" class="form-control " name="state" id="shipping_state" placeholder="State"  value="<?php echo $state; ?>" required /> </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_city">Town / City *</label>
                                          <input type="text" class="form-control " value="<?php echo $town; ?>" id="shipping_city"  placeholder="Town / City" name="town" required /> </div>
                                      </div>
                                      <div class="col-md-6">
                                        <div class="form-group">
                                          <label for="shipping_postcode">Postcode *</label>
                                          <input type="text" class="form-control " name="postcode" id="shipping_postcode" placeholder="Postcode / Zip"  value="<?php echo $postcode; ?>" required /> </div>
                                      </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="order_comments">Optional Message</label>
                                                <textarea name="note" class="form-control " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="4"><?php echo $note; ?></textarea> 
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group mt-20">
                                    <input type="hidden" class="form-control " name="temp_id"   value="<?php echo $order_id; ?>" required />

                                    <input type="submit" class="btn btn-outline btn-primary pull-right" name="shipping" id="shipping" value="Update"  />
                                
                                  </div> 
                          
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 ">               
                        </div>
                        <div class="col-md-5 ">
                            <div class="box">       
                                <div class="box-header with-border">
                                    <h4 class="box-title">Order Details</h4>
                                </div>
                                <div class="box-body p-20">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td>Order ID</td>
                                                <td><?php echo $order_id; ?></td>
                                            </tr>
                                            <tr>
                                                <td>Status</td>
                                                <td><span class="badge badge-<?php echo $status_label; ?>"><?php echo $status_type; ?></span></td>
                                            </tr>
                                            <tr>
                                                <td>Order Time</td>
                                                <td><?php echo $created; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td>Customer Name</td>
                                                <td><b><?php echo $full_name; ?></b></td>
                                            </tr>

                                            <?php if ( isset( $email ) ) :?>
                                            <tr>
                                                <td>Email</td>
                                                <td><b><?php echo $email; ?></b></td>
                                            </tr>
                                            <?php endif;?>

                                            <?php if ( isset( $phone ) ) :?>
                                            <tr>
                                                <td>Contact</td>
                                                <td><b><?php echo $phone; ?></b></td>
                                            </tr>
                                            <?php endif;?>

                                            
                                            <tr>
                                                <td>Billing Address</td>
                                                <td><b><?php echo $address; ?></b></td>
                                            </tr>
                                         

                                            <tr>
                                                <td>Payment method</td>
                                                <td><b>Bank Transfer</b></td>
                                            </tr>

                                            <?php if ( isset( $note ) ) :?>
                                            <tr>
                                                <td>Note</td>
                                                <td><b><?php echo $note; ?></b></td>
                                            </tr>
                                            <?php endif;?>
                                               
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                 
                    </div>
                </form>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Order Products</h4>
                            
                        </div>
                        <div class="box-body p-30">
                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th>Product ID</th>
                                        <th>Image</th>
                                        <th>Product Name</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                      </tr>
                                    <?php echo $list; ?>
                                </table>
                            </div>

                            <div class="row mt-20">
                                <div class="col-md-6"></div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>   
                                                <tr >
                                                    <th>Sub Subtotal</th>
                                                    <td class="text-right"><span class="amount">Rs. <?php echo $sub_total; ?></span></td>
                                                </tr>
                                                <?php if ( $rejected_total > 0 ) :?>
                                                <tr >
                                                    <th>Reject Items</th>
                                                    <td class="text-right"><span class="amount">Rs. <?php echo $rejected_total_label; ?></span></td>
                                                </tr>
                                                <?php endif;?>
                                                <tr >
                                                    <th>Total</th>
                                                    <td class="text-right text-primary"><strong><span class="amount">Rs. <?php echo $total; ?></span></strong></td>
                                                </tr>
                                                <tr >
                                                    <th>Paid Amount</th>
                                                    <td class="text-right"><strong><span class="amount">Rs. <?php echo number_format(-$paid_amount, 2); ?></span></strong></td>
                                                </tr>
                                                <tr >
                                                    <th>Due</th>
                                                    <td class="text-right text-primary"><strong><span class="amount">Rs. <?php echo number_format($balance_payment, 2); ?></span></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
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