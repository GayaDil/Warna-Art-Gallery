<?php
require_once 'config.php';

$page_title =  "Cart";

if ( !isset( $_SESSION['user'] ) ) {
    header('location:login');
}


$cc = new Cart();
$count = $cc->cart_count();

$ac = new Cart();
$items = $ac->all_cart()['items'];
$total = $ac->all_cart()['general']['total_label'];

$no++;


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
                        <h1 class="page-title"><a href="cart">Warna Cart</a></h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">


              <div class="row">
                <div class="col-12 col-lg-9">
                  <div class="box">
                        <div class="box-header">
                          <h4 class="box-title"><strong><a href="cart">CART</a></strong></h4>
                        </div>

                        <div class="box-body">

                          <?php if ( $count == 0 ): ?>

                          <div class="text-center">
                            <h4>Cart is empty!</h4>
                            <a href="gallery" class="btn btn-outline btn-primary mt-20"><i class="fa fa-arrow-left"></i> Continue shopping</a>
                          </div>

                          <?php else: ?>

                          <div class="table-responsive">
                            <table class="table product-overview">
                              <thead>
                                <tr>
                                  <th></th>
                                  <th>Title</th>
                                  <th class="text-right">Price</th>
                                  <th class="text-center">Quantity</th>
                                  <th class="text-right">Total</th>
                                  <th class="text-right"></th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php foreach ($items as $item):?>
                                <tr id="row-<?php echo $item['id']; ?>">

                                  <td style="width: 15%;">
                                    <a href="product?id=<?php echo $item['product_id']; ?>"><img src="<?php echo $item['image']; ?>" alt=""></a>
                                  </td>

                                  <td style="width: 35%;">
                                    <h5><a href="product?id=<?php echo $item['product_id']; ?>"><?php echo $item['title']; ?></a></h5>
                                  </td>
                                  <td class="text-right" style="width: 15%;"><?php echo $item['price_label']; ?></td>
                                  <td style="width: 15%;">
                                    <?php
                                    $p = new Products();
                                    $quantity = $p->product($item['product_id'])['quantity'];
                                    ?>
                                    <input type="number" class="form-control cart-qty" data-id="<?php echo $item['id']; ?>" placeholder="1" min="1" max="<?php echo $quantity; ?>" value="<?php echo $item['quantity']; ?>">
                                  </td>
                                  <td class="text-right line-total" style="width: 15%;"><?php echo $item['total_label']; ?></td>
                                  <td class="text-right" style="width: 5%;">
                                    <a href="javascript:void(0)" class="text-danger delete-cart-item" data-id="<?php echo $item['id']; ?>" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash text-danger"></i></a>
                                  </td>

                                </tr> 
                                <?php endforeach;?>            
                              </tbody>
                            </table>                    
                            <a href="gallery" class="btn btn-outline btn-primary"><i class="fa fa-arrow-left"></i> Continue shopping</a>
                          </div>

                          <?php endif; ?>

                        </div>
                      </div>
                </div>
      
                <div class="col-12 col-lg-3">
              
                
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
                              <td class="text-right cart-sub-total">Rs. <?php echo $total; ?></td>
                            </tr>
                            <tr>
                              <th class="bt-1" style="font-weight: 600;">Total</th>
                              <th class="bt-1 text-right cart-total" style="font-weight: 600;">Rs. <?php echo $total; ?></th>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="box-footer">
                      <a href="checkout" class="btn btn-outline btn-primary pull-right"><i class="fa fa fa-shopping-cart"></i> Checkout</a>
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
