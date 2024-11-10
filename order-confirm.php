<?php
require_once 'config.php';

if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$page_title = "Order Confirm";

$ids = explode(',', $_GET['id']);
$id = $ids[0];

$od = new Orders();
$full_name = $od->order($id)['full_name'];
$customer_id = $od->order($id)['user_id'];
$email = $od->order($id)['email'];
$phone = $od->order($id)['phone'];

$town = $od->order($id)['town'];
$state = $od->order($id)['state'];
$country_id = $od->order($id)['country_id'];
$postcode = $od->order($id)['postcode'];
$note = $od->order($id)['note'];
$created = $od->order($id)['created'];
$status_id = $od->order($id)['status'];
$payment_method = $od->order($id)['payment_method'];


$countr = new Users();
$country_name = $countr->country($country_id)['name'];

$address = $od->order($id)['address_1'].'<br>'.$od->order($id)['address_2'].'<br>'.$od->order($id)['town'].'<br>'.$od->order($id)['state'].'<br>'.$od->order($id)['postcode'].'<br>'.$country_name;

$os = new Orders();
$status = $os->order_status($status_id)['type'];
$status_label = $os->order_status($status_id)['label'];

$items = array();
$total = 0 ;

$no = 0;
$order_ids = '';
foreach ($ids as $tid) {

    if ( $no == 0 ) {
        $order_ids .= str_pad($tid, 5, 0, STR_PAD_LEFT);
    }else{
        $order_ids .= '<br>'.str_pad($tid, 5, 0, STR_PAD_LEFT);
    }
    

    $op = new Orders();
    $items = array_merge($items,$op->order_products($tid)['items']);
    $total = $total + $op->order_products($tid)['general']['total'];

    $no++;

}

$total = number_format($total,2);

$cc = new Cart();
$cc->clear_cart();

//Send Order Confirm Email to Client
//Email body goes here....

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
                        <h1 class="page-title">Warna Checkout</h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">

                <div class="row">
                  <div class="col-12">
                    <div class="alert alert-success text-center">
                      <h3>Order placed!</h3>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="alert alert-primary text-center">
                      <h5><i class="mdi mdi-alert-outline"></i>Thank you for placing an order with us. Your order is awaiting approval from the artist. You will receive the bank deposit details once your order is approved.</h5>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="box">
                      <div class="box-body">
                        
                        <div class="table-responsive">
                          <table class="table">
                              <tr>
                                  <td style="text-align: left; width: 30%;"><strong>Order #</strong></td>
                                  <td style="text-align: left;"><?php echo $order_ids; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Created Time</strong></td>
                                  <td style="text-align: left;"><?php echo $created; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Status</strong></td>
                                  <td style="text-align: left;"><label class="badge badge-<?php echo $status_label; ?>"><?php echo $status; ?></label></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Payment Method</strong></td>
                                  <td style="text-align: left;"><?php echo $payment_method; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Name :</strong></td>
                                  <td style="text-align: left;"><?php echo $full_name; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Email :</strong></td>
                                  <td style="text-align: left;"><?php echo $email; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Phone :</strong></td>
                                  <td style="text-align: left;"><?php echo $phone; ?></td>
                              </tr>
                              <tr>
                                  <td style="text-align: left;"><strong>Address :</strong></td>
                                  <td style="text-align: left;"><?php echo $address; ?></td>
                              </tr>
                              <?php if ( strlen($note) > 0 ) :?>
                              <tr>
                                  <td style="text-align: left;"><strong>Note :</strong></td>
                                  <td style="text-align: left;"><?php echo $note; ?></td>
                              </tr>
                              <?php endif;?>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-2">
                  </div>
                  <div class="col-md-4">
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
                            </div>
                            <div class="box-footer">
                              <a href="./" class="btn btn-outline btn-primary pull-right"> Go To Homepage</a>
                            </div>
                      </div>
                  </div>
                </div>


              <div class="row">
                  <div class="col-12">
                    <div class="box">
                          

                          <div class="box-body">
                            <div class="table-responsive">
                                <table class="table product-overview">
                                    <thead>
                                        <tr>
                                          <th></th>
                                          <th>Title</th>
                                          <th class="text-right" >Quantity</th>
                                          <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item):?>
                                        <tr class = "cart_table_item" id="row-<?php echo $item['id']; ?>">

                                            <td style="width:10%;"><a href="shop-detail.html">
                                              <img src="<?php echo $item['image']; ?>" class="attachment-shop_thumbnail wp-post-image" alt="T_7_front" /></a>
                                            </td>

                                            <td style="width: 20%;"><?php echo $item['title']; ?></td>

                                            <td class="text-right" style="width: 20%;"><?php echo $item['price_label']; ?> x <?php echo $item['quantity']; ?></td>

                                            <td class="text-right" style="width: 20%;">Rs. <?php echo $item['total_label']; ?></td>

                                        </tr>
                                        <?php endforeach;?>

                                    </tbody>
                                </table>
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
