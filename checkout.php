<?php
require_once 'config.php';

$page_title =  "Checkout";

if ( !isset( $_SESSION['user'] ) ) {
    header('location:login');
}


$cc = new Cart();
$count = $cc->cart_count();

if ( $count == 0 ) {
    header('location:./');
}


if ( isset( $_POST['checkout'])){

    $ids = array();

    $first_name = $db->real_escape_string($_POST['first_name']);
    $last_name = $db->real_escape_string($_POST['last_name']);
    $email = $db->real_escape_string($_POST['email']);
    $phone = $db->real_escape_string($_POST['phone']);
    $address_1 = $db->real_escape_string($_POST['address_1']);
    $address_2 = $db->real_escape_string($_POST['address_2']);
    $town = $db->real_escape_string($_POST['town']);
    $state = $db->real_escape_string($_POST['state']);
    $country_id = $db->real_escape_string($_POST['country_id']);
    $country_name = $db->real_escape_string($_POST['country_name']);
    $postcode = $db->real_escape_string($_POST['postcode']);
    $payment_method = $db->real_escape_string($_POST['payment_method']);
    $note = $db->real_escape_string($_POST['note']);


    $payment_method = 1;

    //General = 1
    //Bid = 2
    $post_method = 1;

    //List All artists belongs to this order
    $query = $db->query("SELECT DISTINCT(artist_id) FROM `cart` WHERE `user_id` = '$this_user_id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){

            $comm = new ArtistPayments();
            $commission = $comm->commission();
        
            $artist_id = $row['artist_id'];

            //Add details to orders table
            $db->query("INSERT INTO `orders`(`user_id`, `artist_id`, `post_method`, `payment_method`, `commission`, `b_first_name`, `b_last_name`, `b_email`, `b_phone`, `b_address_1`, `b_address_2`, `town`, `state`, `country_id`, `postcode`, `note`, `status`, `created`) VALUES ('$this_user_id', '$artist_id', '$post_method', '$payment_method', '$commission', '$first_name', '$last_name', '$email', '$phone', '$address_1', '$address_2', '$town', '$state', '$country_id', '$postcode', '$note', '1', '$now')");

            $last_id = $db->insert_id;
            array_push($ids, $last_id);

        
            //Add details to order progress table
            $db->query("INSERT INTO `order_progress`(`order_id`, `user_id`, `status`, `created_time`, `note`) VALUES ('$last_id', '$this_user_id', '1', '$now', 'Order Create')");

            
            //List All products in cart belongs to each artist
            $query_c = $db->query("SELECT * FROM `cart` WHERE `user_id` = '$this_user_id' AND `artist_id` = '$artist_id'");
            $rowCount_c = $query_c->num_rows;

            $artist_mail_products = '';
            $tot = 0;

            if($rowCount_c > 0){
                while($row_c = $query_c->fetch_assoc()){

                    $id = $row_c['id'];
                    $product_id = $row_c['product_id'];                 
                    $quantity = $row_c['quantity'];

                    $pr = new Products();
                    $unit_price = $pr->product($product_id)['price'];
                    $product_title = $pr->product($product_id)['title'];
                    $product_image = $pr->product($product_id)['image'];
                    $product_qty = $pr->product($product_id)['quantity'];

                    $product_image = $app_url.'assets/artworks/'.$product_id.'/'.$product_image;
                    $this_tot = $unit_price * $quantity;
                    $tot = $tot + $this_tot;

                     //Add details to order product table
                    $db->query("INSERT INTO `order_products`( `order_id`, `product_id`, `unit_price`, `quantity`, `status`, `created`) VALUES ('$last_id', '$product_id', '$unit_price', '$quantity', '1', '$now')");


                    //reduce product quantity product table
                    $update_qty = $product_qty - $quantity;
                    $db->query("UPDATE `products` SET `quantity`='$update_qty' WHERE `id`='$product_id'");





                    $artist_mail_products .= '<tr>
                                                <td width="20"></td>  
                                                <td width="100" style="padding: 10px; mso-padding-alt: 10px 10px 10px 10px;border-right: 1px solid #efefef; border-bottom: 1px solid #efefef; border-left: 1px solid #efefef; font-size: 14px;"><img src="'.$product_image.'"></td>
                                                <td width="260" style="padding: 10px; mso-padding-alt: 10px 10px 10px 10px;border-right: 1px solid #efefef; border-bottom: 1px solid #efefef; border-left: 1px solid #efefef; font-size: 14px;">'.$product_title.'</td>
                                                <td width="100" align="right" style="padding: 10px; mso-padding-alt: 10px 10px 10px 10px;border-right: 1px solid #efefef; border-bottom: 1px solid #efefef; border-left: 1px solid #efefef; text-align: right; font-size: 14px;">'.number_format($unit_price, 2).'x'.$quantity.' </td>
                                                <td width="100" align="right" style="padding: 10px; mso-padding-alt: 10px 10px 10px 10px;border-right: 1px solid #efefef; border-bottom: 1px solid #efefef; border-left: 1px solid #efefef; text-align: right; font-size: 14px;">'.number_format($this_tot, 2).'</td>
                                                <td width="20"></td> 
                                            </tr>';
                }
            }

         
            //START - Send Notification emails to ARTISTS
            $ce = new Users();
            $artist_email = $ce->user($artist_id)['email'];
            $artist_name = $ce->user($artist_id)['first_name'].' '.$ce->user($artist_id)['last_name'];

            $artist_template = file_get_contents('email/order-placed-artist.tpl');

            $artist_view_btn = $app_url.'artist/order?id='.$last_id;
            $artist_sub_total = number_format($tot, 2);
            $artist_total = number_format($tot, 2);

            $artist_template = str_replace("<!-- #{ProductsList} -->", $artist_mail_products, $artist_template);
            $artist_template = str_replace("<!-- #{viewButton} -->", $artist_view_btn, $artist_template);
            $artist_template = str_replace("<!-- #{orderSubTotal} -->", $artist_sub_total, $artist_template);
            $artist_template = str_replace("<!-- #{orderTotal} -->", $artist_total, $artist_template);
   
            $artist_mail_subject = 'You Have New Order Request';

            $mail = new Mail();
            $mail->send($artist_name, $artist_email, $artist_mail_subject, $artist_template );
            //END - Send Notification emails to ARTISTS


            //START - Send Notification emails to CUSTOMER and ADMIN
            $cust_template = file_get_contents('email/order-placed-customer.tpl');

            $cust_view_btn = $app_url.'order-view?id='.$last_id;
            $cust_name = $first_name.' '.$last_name;
            $cust_address = $address_1.'</br> '.$address_2.'</br> '.$town.'</br> '.$state.'</br> '.$postcode.'</br> '.$country_name;
            $payment_method = 'Bank Transfer';

            $cust_template = str_replace("<!-- #{ProductsList} -->", $artist_mail_products, $cust_template);
            $cust_template = str_replace("<!-- #{viewButton} -->", $cust_view_btn, $cust_template);
            $cust_template = str_replace("<!-- #{orderSubTotal} -->", $artist_sub_total, $cust_template);
            $cust_template = str_replace("<!-- #{orderTotal} -->", $artist_total, $cust_template);

            $cust_template = str_replace("<!-- #{orderId} -->", str_pad($last_id, 5, 0, STR_PAD_LEFT), $cust_template);
            $cust_template = str_replace("<!-- #{orderCreatedTime} -->", date('d-F-Y h:i A', time()), $cust_template);
            $cust_template = str_replace("<!-- #{orderPaymentMethod} -->", $payment_method, $cust_template);
            $cust_template = str_replace("<!-- #{orderCustomerName} -->", $cust_name, $cust_template);
            $cust_template = str_replace("<!-- #{orderContact} -->", $phone, $cust_template);
            $cust_template = str_replace("<!-- #{orderEmail} -->", $email, $cust_template);
            $cust_template = str_replace("<!-- #{orderAddress} -->", $cust_address, $cust_template);
            $cust_template = str_replace("<!-- #{orderNote} -->", $note, $cust_template);
   
            $cust_mail_subject = 'Thank you for purchasing with warna.lk';            

            $mail = new Mail();
            $mail->send($cust_name, $email, $cust_mail_subject, $cust_template );

            $admin_view_btn = $app_url.'admin/order-view?id='.$last_id;
            $admin_mail_subject = 'New Order Recieved';
            $admin_template = file_get_contents('email/order-placed-customer.tpl');

            $admin_template = str_replace("<!-- #{ProductsList} -->", $artist_mail_products, $admin_template);
            $admin_template = str_replace("<!-- #{viewButton} -->", $admin_view_btn, $admin_template);
            $admin_template = str_replace("<!-- #{orderSubTotal} -->", $artist_sub_total, $admin_template);
            $admin_template = str_replace("<!-- #{orderTotal} -->", $artist_total, $admin_template);

            $admin_template = str_replace("<!-- #{orderId} -->", str_pad($last_id, 5, 0, STR_PAD_LEFT), $admin_template);
            $admin_template = str_replace("<!-- #{orderCreatedTime} -->", date('d-F-Y h:i A', time()), $admin_template);
            $admin_template = str_replace("<!-- #{orderPaymentMethod} -->", $payment_method, $admin_template);
            $admin_template = str_replace("<!-- #{orderCustomerName} -->", $cust_name, $admin_template);
            $admin_template = str_replace("<!-- #{orderContact} -->", $phone, $admin_template);
            $admin_template = str_replace("<!-- #{orderEmail} -->", $email, $admin_template);
            $admin_template = str_replace("<!-- #{orderAddress} -->", $cust_address, $admin_template);
            $admin_template = str_replace("<!-- #{orderNote} -->", $note, $admin_template);

            $mail = new Mail();

            $admin_name = 'Admin';
            $mail->send($admin_name, $admin_email_address, $admin_mail_subject, $admin_template );
            //END - Send Notification emails CUSTOMER and ADMIN
        }  
    }

    
    $ids = implode(',', $ids);

    header('location:order-confirm?id='.$ids);
}


$cc = new Cart();
$count = $cc->cart_count();

$ac = new Cart();
$items = $ac->all_cart()['items'];
$total = $ac->all_cart()['general']['total_label'];

$u = new Users();
$first_name = $u->user($this_user_id)['first_name'];
$last_name = $u->user($this_user_id)['last_name'];
$full_name = $u->user($this_user_id)['full_name'];
$email = $u->user($this_user_id)['email'];
$phone = $u->user($this_user_id)['phone'];
$address_1 = $u->user($this_user_id)['address_1'];
$address_2 = $u->user($this_user_id)['address_2'];
$town = $u->user($this_user_id)['town'];
$state = $u->user($this_user_id)['state'];
$postcode = $u->user($this_user_id)['postcode'];
$country_id = $u->user($this_user_id)['country_id'];
$note = $u->user($this_user_id)['note'];
$email_verified = $u->user($this_user_id)['email_verified'];
$email_verified_link = $u->user($this_user_id)['email_verified_link'];

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


$email_sent = 0;

if ( isset($_POST['resend'])) {

    if ( $email_verified == 0 ){

        $email_verified_link = 'warna'.time();
        $email_verified_link = sha1($email_verified_link);
        $db->query("UPDATE `users` SET `email_verified_link` ='$email_verified_link' WHERE `id` = '$this_user_id'");
 
        $mail_subject = 'Verify Your account';
        $email_verified_link = $app_url.'account-verify?verify_link='.$email_verified_link;

        $template = file_get_contents('email/account-verification.tpl');
        $template = str_replace("<!-- #{userFullName} -->", $full_name, $template);
        $template = str_replace("<!-- #{verifyLink} -->", $email_verified_link, $template);

        $mail = new Mail();
        $mail->send($full_name, $email, $mail_subject, $template );  

        $email_sent = 1; 

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
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
              
                
              
                <div class="row">
                  <?php if ( $email_verified != 1 && $email_sent == 0 ) :?>
                  <div class="col-12">
                    <div class="alert alert-danger alert-dismissible mb-40">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-warning"></i> Your account is not verified! please verify now.</h5>
                        <p>Didn't receive an email? </p>
                        <form method="POST">
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-dark btn-sm" name="resend">Resend</button> 
                            </div>
                        </form>
                    </div>
                  </div>
                  <?php endif;?>

                  <?php if ( $email_sent == 1 ) :?>
                  <div class="col-12">
                    <div class="alert alert-success alert-dismissible mb-40">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fa fa-check"></i> Account Verification link has been sent to your email address. Please check your inbox.</h5>
                    </div>
                  </div>
                  <?php endif;?>

                </div>
                <form method="POST">
                    <div class="row">                 

                        <div class="col-md-6 ">
                            <div class="box">                      
                                <div class="box-header">
                                  <h4 class="box-title"><strong>Shipping Details</strong></h4>
                                </div>
                                <div class="pad">

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
                                          <textarea name="note" class="form-control " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="4" value="<?php echo $note; ?>"></textarea> </div>
                                      </div>
                                    </div>
                          
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 ">
                          <div class="box">
                                <div class="box-header">
                                  <h4 class="box-title"><strong>CART ITEMS</strong></h4>
                                  <a href="cart" class="btn btn-outline btn-primary pull-right btn-sm"><i class="fa fa-shopping-cart"></i> GOTO CART</a>
                                </div>
                                <div class="box-body">
                                  <div class="table-responsive">
                                      <table class="table product-overview">
                                          <thead>
                                              <tr>
                                                <th></th>
                                                <th>Title</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-right">Total</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php foreach ($items as $item):?>
                                              <tr class = "cart_table_item" id="row-<?php echo $item['id']; ?>">

                                                  <td style="width: 100px;"><a href="shop-detail.html">
                                                    <img src="<?php echo $item['image']; ?>" alt="" /></a>
                                                  </td>

                                                  <td><?php echo $item['title']; ?></td>


                                                  <td>
                                                    <span class="amount">Rs. <?php echo $item['price_label']; ?> x <?php echo $item['quantity']; ?></span>
                                                    
                                                  </td>

                                                  <td class="text-right">Rs. <?php echo $item['total_label']; ?></td>

                                              </tr>
                                              <?php endforeach;?>

                                          </tbody>
                                      </table>
                                      
                                  </div>
                                </div>
                          </div>
                          <div class="row">
                              <div class="col-md-4"></div>
                              <div class="col-md-8">
                              <div class="box">
                                  <div class="box-header">
                                    <h4 class="box-title"><strong>Cart Summary</strong></h4>
                                  </div>

                                  <div class="box-body">
                                      <div class="table-responsive">
                                          <table class="table simple mb-0">
                                            <tbody>
                                              <tr>
                                                <td>Subtotal</td>
                                                <td class="text-right">Rs. <?php echo $total; ?></td>
                                              </tr>
                                              <tr>
                                                <th class="bt-1">Total</th>
                                                <th class="bt-1 text-right">Rs. <?php echo $total; ?></th>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </div>
                                      <div class="col-md-12 mt-20">
                                        <label>Payment Method</label>
                                        <div class="form-group">

                                          <input name="group3" type="radio" id="payment-method" class="with-gap" checked />
                                          <label for="payment-method">Bank Transfer</label>
                                        </div>
                                      </div>

                                  <div class="form-group mt-20">
                                    <?php if ($email_verified == 1 ):?>
                                    <input type="submit" class="btn btn-outline btn-primary pull-right" name="checkout" id="place_order" value="Place order" data-value="Place order" />
                                    <?php endif;?>
                                  </div>  
                                  </div>

        
                            </div>
                            </div>
                          </div>
                        </div>                 

                    </div>
                </form>
              
             
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