<?php
require_once 'config.php';

$this_id = $_GET['id'];

$p = new Products();

$user_id = $p->product($this_id)['user_id'];
$category_id = $p->product($this_id)['category_id'];
$medium_id = $p->product($this_id)['medium_id'];
$post_method = $p->product($this_id)['post_method'];
$bid_start_time = $p->product($this_id)['bid_start_time'];
$bid_end_time = date('Y-m-d H:i:s', strtotime($p->product($this_id)['bid_end_time']));
$title = $p->product($this_id)['title'];
$description = $p->product($this_id)['description'];
$price = $p->product($this_id)['price'];
$price_label = $p->product($this_id)['price_label'];
$quantity = $p->product($this_id)['quantity'];
$orientation = $p->product($this_id)['orientation'];
$dimension_id = $p->product($this_id)['dimension_id'];
$dimension_x = $p->product($this_id)['dimension_x'];
$dimension_y = $p->product($this_id)['dimension_y'];
$dimension_label_id = $p->product($this_id)['dimension_label_id'];
$image = $p->product($this_id)['image_front'];
$artwork_date = date('Y', strtotime($p->product($this_id)['artwork_date']));
$status = $p->product($this_id)['status'];
$admin_status = $p->product($this_id)['admin_status'];
$created = date('d-F-Y', strtotime($p->product($this_id)['created']));



if ( $post_method == 2 ) {
    // Current bid
    $b = new Products();
    $current_bid = $b->current_ongoing_bid($this_id)['amount'];

    $b = new Products();
    $minimum_bid_amount = $current_bid + $b->bid_addition_amount();


    $b = new Products();
    $user_last_bid = $b->user_last_highest_bid($this_user_id, $this_id)['amount'];


}


$page_title = "Product -" ."$title";


$cat = new Categories();
$category = $cat->category($category_id)['type'];

$med = new Mediums();
$medium = $med->medium($medium_id)['type'];


$pa = new Users();
$artist_image = $pa->user($user_id)['image_front'];
$full_name = $pa->user($user_id)['full_name'];

switch ($orientation) {
    case 1:
        $orientation = 'Landscape';
        break;
    case 2:
        $orientation = 'Portrait';
        break;
    case 3:
        $orientation = 'Square';
        break;
    default:
        $orientation = 'Other';
        break;
}


if ( $dimension_id == 0 ) {

    $dl = new Products();
    $dimension = $dimension_x .'x'.$dimension_y.' '.$dl->dimension_label($dimension_label_id)['type'];

}else{

    $d = new Products();
    $dimension = $d->dimension($dimension_id)['type'];

}



//Meta varialbles
$meta_page_title = $title;
$meta_page_description = strip_tags($description);
$meta_page_description = str_replace('"', '', $meta_page_description);
$meta_page_description = substr($meta_page_description, 0, 250);
$meta_page_image = $app_url.$image;


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
                        <h1 class="page-title"><a href="cart">Product Detail</a></h1>
                    </div>
                </div>
            </div> 

            <!-- Main content -->

            <section class="content">

                <?php if( $status != 1 || $admin_status != 1 ) :  ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">This product is no longer available.</div>
                        </div>
                    </div>
                <?php else : ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="box box-body b-1 text-center no-shadow">
                                            <a class="simple-ajax-modal " href="product-view?id=<?php echo $this_id; ?>">
                                            <img src="<?php echo $image; ?>" id="product-image" class="img-fluid" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" />
                                            </a>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="user-block mb-20">
                                            <span class="description pull-right"><i class="fa fa-paint-brush"></i> <?php echo $artwork_date; ?></span>
                                            <a href="#"><img class="avatar" src="<?php echo $artist_image; ?>" alt="User Image"></a>
                                            <span class="username"><a href="#"><?php echo $full_name; ?></a></span>
                                            <span class="description"><i class="fa fa-clock-o"></i> <?php echo $created; ?></span>
                                            
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <h2 class="box-title mt-0"><?php echo $title; ?></h2>
                                        <div style=" margin-bottom: 20px;">                        
                                            <div class="gap-items font-size-16">
                                                <a class="text-facebook" href="#" onclick="share_fb('<?php echo $meta_page_url; ?>');return false;" share_url="<?php echo $meta_page_url; ?>" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                                                    <a class="text-whatsapp whatsapp-this" href="#"><i class="fa fa-whatsapp" title="Share on Whatsapp"></i></a>
                                                    <a class="text-google" href="javascript:emailThisPage()" title="Email This"><i class="fa fa-envelope"></i></a>
                                          </div>                               
                                        </div> 
                                          
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                      <tbody>
                                                        <?php if ( isset( $category ) ) :?>
                                                        <tr>
                                                          <td>Category</td>
                                                          <td> <?php echo $category; ?> </td>
                                                        </tr>
                                                         <?php endif;?>

                                                        <?php if ( isset( $medium ) ) :?>
                                                        <tr>
                                                          <td>Medium</td>
                                                          <td> <?php echo $medium; ?> </td>
                                                        </tr>
                                                        <?php endif;?>

                                                        <?php if ( isset( $orientation ) ) :?>
                                                        <tr>
                                                          <td>Orientation</td>
                                                          <td> <?php echo $orientation; ?> </td>
                                                        </tr>
                                                        <?php endif;?>

                                                        <?php if ( isset( $dimension ) ) :?>
                                                        <tr>
                                                          <td>Dimension</td>
                                                          <td> <?php echo $dimension; ?> </td>
                                                        </tr>
                                                        <?php endif;?>

                                                        <?php if ( isset( $price ) ) :?>
                                                        <tr>
                                                          <td>Price</td>
                                                          <td> Rs.<?php echo number_format($price, 2); ?> </td>
                                                        </tr>
                                                        <?php endif;?>
                                                        <tr>                                    
                                                      </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <?php if ( $quantity > 0 ) :?>

                                            <?php if ( $post_method == 1 ) :?>

                                            <div class="product-view-button-area">
                                                <input type="number" class="form-control product-quantity" placeholder="1" min="1" max="<?php echo $quantity; ?>" value="1">
                                                <button class="btn btn-primary btn-outline ml-20 add-all-to-cart" data-toggle="tooltip" data-container="body" title="" data-original-title="Add to Cart"   data-id="<?php echo $this_id; ?>" ><i class="mdi mdi-cart-plus"></i> Add to cart </button>
                                            </div>

                                            <?php elseif ( $post_method == 2 ) :?>

                                                    <div >
                                                        <label for="">Bid Ends At :</label>
                                                        <label for="" class="text-danger" id="timer">
                                                            <span id="days"></span>
                                                            <span id="hours"></span>
                                                            <span id="minutes"></span>
                                                            <span id="seconds"></span>                        
                                                        </label>
                                                    </div>
                                                    <div >
                                                        <label for="">Current Bid :</label>
                                                        <label for="" class="text-primary">Rs. <?php echo number_format($current_bid, 2) ?></label>
                                                    </div> 
                                                    <?php if (  $user_last_bid > 0 ):?>   
                                                    <div >
                                                        <label for="">Your Last Bid :</label>
                                                        <label for="" class="text-primary">Rs. <?php echo number_format($user_last_bid, 2) ?></label>
                                                    </div> 
                                                    <?php endif;?>                                                
                                                    <div class="form-group ">
                                                        <label for="bid-amount">Enter your maximum bid*</label>
                                                        <p class="text-primary" style="font-size: 80%;">Minimum amount is Rs.  <?php echo number_format($minimum_bid_amount, 2) ?></p>
                                                        <input type="text" class="form-control w-p30" placeholder="Enter..." id="bid-amount" > 
                                                         <a class="btn btn-primary btn-outline mt-20 place-bid" data-toggle="tooltip" data-container="body" title="" data-original-title="Place Bid" data-id="<?php echo $this_id; ?>"><i class="mdi mdi-cart-plus"></i> Place Bid </a>                                  
                                                    </div>
                                   
                    
                                            <?php endif;?>

                                        <?php else:?>

                                            <div>
                                                <h3 class="text-primary text-bold">Sold out!</h3>
                                            </div>

                                        <?php endif;?>

                                        

                                        
                                    </div>
                                </div>
                                <div class="row mt-60">
                                    <div class="col-12">
                                        <hr>
                                        <h5 class="mt-40">Description</h5>
                                        <?php echo $description; ?>
                                    </div>
                                </div>
                            </div>        
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->
<?php include 'include/script.php'; ?>

<script>
    function emailThisPage(){
        var title = "<?php echo $title; ?>";
        window.location.href = "mailto:?subject="+title+"&body="+escape(window.location.href);
    }

    function share_fb(url) {
        window.open('https://www.facebook.com/sharer/sharer.php?u='+url,'facebook-share-dialog',"width=626, height=436");
    }

    function decorateWhatsAppLink() {

    var url = 'whatsapp://send?text=';
    var text = "<?php echo $title; ?>" + " <?php echo $meta_page_url; ?>";
    var encodedText = encodeURIComponent(text);
    var $whatsApp = $('.whatsapp-this');
    $whatsApp.attr('href', url + encodedText);
    }

    decorateWhatsAppLink();
</script>

<script>
    function makeTimer() {
 
            var endTime = new Date("<?php echo $bid_end_time; ?>");          
            endTime = (Date.parse(endTime) / 1000);

            var now = new Date();
            now = (Date.parse(now) / 1000);

            var timeLeft = endTime - now;

            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }

            $("#days").html(days + "d");
            $("#hours").html(hours + "h");
            $("#minutes").html(minutes + "m");
            $("#seconds").html(seconds + "s");       

    }

    setInterval(function() { makeTimer(); }, 1000);
</script>
</body>
</html>
