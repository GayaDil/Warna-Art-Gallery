<?php
require_once 'config.php';


/*---------------add review-------------------*/

$msg = '';
if (isset($_POST['commentform'])) {

    $review = $db->real_escape_string($_POST['review']);
    $validate = true;
    if ( isset( $_SESSION['user'] ) ) {

            if ( strlen($_POST['review']) <= 0 ) {
                $validate = false;
                $msg .= '<div class="alert alert-danger"><strong>Review field is empty</strong></div>';
            }

            if ( $validate ) {
              
                $db->query("INSERT INTO `reviews`( `review_artist_id`, `comment`, `created_user_id`, `created_time`, `status`) VALUES ('$id', '$review', '$this_user_id', '$now', '1')");  

                /*header('location:artist.php?id='.$id.'');*/
                $msg .= '<div class="alert alert-success mt-20"><strong>Review added</strong></div>';
            }

    }else{
    $msg .= '<div class="alert alert-danger mt-20"><strong>Need to be logged in first!</strong></div>';
    }
} 

/*---------------update review-------------------*/

if (isset($_POST['commentform_update'])) {

    $temp_review_id = $db->real_escape_string($_POST['temp_review_id']);
    $review = $db->real_escape_string($_POST['review']);

    $validate = true;

    if ( strlen($_POST['review']) <= 0 ) {
        $validate = false;
        $msg .= '<div class="alert alert-danger mt-20"><strong>Review field is empty</strong></div>';
    }

    if ( $validate ) {
      
        $db->query("UPDATE `reviews` SET `comment`= '$review',`created_time`= '$now' WHERE `id` = '$temp_review_id' ");

        

        $msg .= '<div class="alert alert-success mt-20"><strong>Review Updated</strong></div>';

    }
} 





if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $ud = new Users();
    $full_name = $ud->user($id)['full_name'];
    $email = $ud->user($id)['email'];
    $phone = $ud->user($id)['phone'];
    $designation = $ud->user($id)['designation'];
    $image = $ud->user($id)['image_front'];
    $image_name = $ud->user($id)['image_name'];
    $town = $ud->user($id)['town'];
    $state = $ud->user($id)['state'];
    $country = $ud->user($id)['country'];
    $address = $ud->user($id)['address_1'].'<br>'.$ud->user($id)['address_2'];
    $created = date('d-F-Y h:i A', strtotime($ud->user($id)['created']));
    $status = $ud->user($id)['status'];

    $facebook_url = $ud->user($id)['facebook_url'];
    $linkedin_url = $ud->user($id)['linkedin_url'];
    $instagram_url = $ud->user($id)['instagram_url'];


    /*-----------artist other info-------------*/
    $descriptions = '';

    $sql = " SELECT ai.type_id AS type_id, ait.type AS type, ait.icon AS icon
    FROM artist_informations AS ai INNER JOIN artist_information_types AS ait ON ait.id = ai.type_id
    WHERE ai.user_id = '$id' AND ai.status = '1' GROUP BY ai.type_id ";
    $query = $db->query($sql);
    $rowCount = $query->num_rows;
    if($rowCount > 0 ){
        while ( $row = $query->fetch_assoc()) {
            $this_type_id = $row['type_id'];
            $ait_type = $row['type'];
            $ait_icon = $row['icon'];

            
            $queryDesc = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$id' AND `type_id` = '$this_type_id' AND `status` = '1'");
            $rowCountDec = $queryDesc->num_rows;
            if($rowCountDec > 0){
                while ($rowDec = $queryDesc->fetch_assoc()) {
                    $ai_id = $rowDec['id'];
                    $description = $rowDec['description'];

                    $descriptions .= '<tr>
                                        <td ><i class="fa '.$ait_icon.' " ></i></td>
                                        <td>'.$description.'</td>
                                    </tr>';

                }

            }

           /* fa-trophy
            fa-mortar-board
            fa-university*/
        }
    }


    


    /*----------------services info------------------*/

    $ar_serv_arr = '';

    $sql = " SELECT ars.service_id AS service_id, srv.type AS type
    FROM artist_services AS ars INNER JOIN services AS srv ON srv.id = ars.service_id
    WHERE ars.user_id = '$id' AND ars.status = '1' GROUP BY ars.service_id ";
    $query = $db->query($sql);
    $rowCount = $query->num_rows;
    if($rowCount > 0 ){
        while ( $row = $query->fetch_assoc()) {
            $this_service_id = $row['service_id'];
            $ars_type = $row['type'];

           /* fa-trophy
            fa-mortar-board
            fa-university*/

            $ar_serv_arr .=  ' <span class="badge badge-sm badge-primary">'.$ars_type.'</span> ';


        }
    }
}

$page_title = "Artist -" . "$full_name";






/*----------------Reviews-------------------*/

$comments = '';
$query = $db->query("SELECT * FROM `reviews` WHERE `review_artist_id` = '$id' AND  `status` = '1' ORDER BY `created_time` DESC ");   
$rowCountReview = $query->num_rows;
if($rowCountReview > 0){
    while($row = $query->fetch_assoc()){
        $comment_id = $row['id'];
        $comment = $row['comment'];
        $created_user_id = $row['created_user_id'];
        $created_time = $row['created_time'];

        $ru = new Users();
        $reviewer_name = $ru->user($created_user_id)['full_name']; 

        $edit_btn = '';
        $delete_btn = '';

        if ( $created_user_id == $this_user_id ) {
            $edit_btn = '<a href="javascript:void(0);" class="pull-right text-primary mr-10 edit-this-review" data-id="'.$comment_id.'"><i class="mdi mdi-pencil"></i></a>';

            $delete_btn = '<a href="javascript:void(0);" class="pull-right text-primary delete-this-review" data-id="'.$comment_id.'"><i class="mdi mdi-delete"></i></a>';
        }
        

        $comments .= '<div class="media align-items-center">
                        <div class="media-body">
                            <p class="font-size-16">
                                '.$delete_btn.'
                                '.$edit_btn.'
                                <a class="text-primary" href="javascript:void(0);"><strong>'.$reviewer_name.'</strong></a>
                                <p><span class="fa fa-calendar"></span> <a href="javascript:void(0);">'.$created_time.'</a></p>
                            </p>
                         </div>
                     </div>          
                    <div class="media pt-0">
                        <p id="review-content-'.$comment_id.'">'.strip_tags($comment).'</p>
                    </div>';
    }      
} 



$ap = new Homepage();
$a_products = $ap->artist_products($id)['list'];
$total_pages = $ap->artist_products($id)['total_pages'];

$pg = new Paginations();
$prev_url = $pg->pagination($total_pages)['paginate_prev_url'];
$next_url = $pg->pagination($total_pages)['paginate_next_url'];


$pagination = <<<EOD
<div class="row">
  <div class="col-md-12">
    <nav aria-label="Page navigation example">
      <ul class="pagination justify-content-center">
        <li class="page-item"><a class="page-link" $prev_url >Previous</a></li>
        <li class="page-item"><a class="page-link" $next_url >Next</a></li>
      </ul>
    </nav>
  </div>          
</div>
EOD;


/*--------ratings---------*/

$r = new Users();
$rate_count = $r->artist_ratings($id)['count'];
$rate_one = $r->artist_ratings($id)['one'];
$rate_two = $r->artist_ratings($id)['two'];
$rate_three = $r->artist_ratings($id)['three'];
$rate_four = $r->artist_ratings($id)['four'];
$rate_five = $r->artist_ratings($id)['five'];
$rate_percentage = $r->artist_ratings($id)['percentage'];

$rate_round = round($rate_percentage);

$r_1_icon = ( $rate_round >= 1 ) ? 'fa-star' : 'fa-star-o';
$r_2_icon = ( $rate_round >= 2 ) ? 'fa-star' : 'fa-star-o';
$r_3_icon = ( $rate_round >= 3 ) ? 'fa-star' : 'fa-star-o';
$r_4_icon = ( $rate_round >= 4 ) ? 'fa-star' : 'fa-star-o';
$r_5_icon = ( $rate_round == 5 ) ? 'fa-star' : 'fa-star-o';

$rates = <<<EOD
<span class="fa $r_1_icon text-primary" data-rating="1" style="font-size:20px;"></span>
<span class="fa $r_2_icon text-primary" data-rating="1" style="font-size:20px;"></span>
<span class="fa $r_3_icon text-primary" data-rating="1" style="font-size:20px;"></span>
<span class="fa $r_4_icon text-primary" data-rating="1" style="font-size:20px;"></span>
<span class="fa $r_5_icon text-primary" data-rating="1" style="font-size:20px;"></span>
EOD;



?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'include/head.php'; ?>
<style type="text/css">
    /* RATING - Form */

/* RATING - Form - Group */
.rating-form .form-group {
  position: relative;
  border: 0;
}

/* RATING - Form - Legend */
.rating-form .form-legend {
  display: none;
  margin: 0;
  padding: 0;
  font-size: 20px;
  font-size: 2rem;
}

/* RATING - Form - Item */
.rating-form .form-item {
  position: relative;
  margin: auto;
  width: 300px;
  text-align: center;
  direction: rtl;
}

.rating-form .form-legend + .form-item {
  padding-top: 10px;
}

.rating-form input[type="radio"] {
  position: absolute;
  left: -9999px;
}

/* RATING - Form - Label */
.rating-form label {
  display: inline-block;
  cursor: pointer;
}

.rating-form .rating-star {
  display: inline-block;
  position: relative;
}

.rating-form input[type="radio"] + label:before {
  content: attr(data-value);
  position: absolute;
  right: 30px;
  top: 83px;
  font-size: 30px;
  font-size: 3rem;
  opacity: 0;
  direction: ltr;
  
}

.rating-form input[type="radio"]:checked + label:before {
  opacity: 0;
}

.rating-form input[type="radio"] + label:after {
  content: "";
  position: absolute;
  right: 0;
  top: 0;
  opacity: 0;  
}

.rating-form input[type="radio"]:checked + label:after {
  /*right: 5px;*/
  opacity: 0;
}

.rating-form label .fa {
  font-size: 20px;
  line-height: 30px;
  color: #a81c51;
  
}

.rating-form label .fa-star-o {
}

.rating-form label:hover .fa-star-o,
.rating-form label:focus .fa-star-o,
.rating-form label:hover ~ label .fa-star-o,
.rating-form label:focus ~ label .fa-star-o,
.rating-form input[type="radio"]:checked ~ label .fa-star-o {
  opacity: 0;
}

.rating-form label .fa-star {
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0;
}

.rating-form label:hover .fa-star,
.rating-form label:focus .fa-star,
.rating-form label:hover ~ label .fa-star,
.rating-form label:focus ~ label .fa-star,
.rating-form input[type="radio"]:checked ~ label .fa-star {
  opacity: 1;
  color: #a81c51;
}

.rating-form input[type="radio"]:checked ~ label .fa-star {
  color: #a81c51;
}

.rating-form .ir {
  position: absolute;
  left: -9999px;
}

/* RATING - Form - Action */
.rating-form .form-action {
  opacity: 0;
  position: absolute;
  left: 5px;
  bottom: -40px;
  
}

.rating-form input[type="radio"]:checked ~ .form-action {
  cursor: pointer;
  opacity: 1;
}

.rating-form .btn-reset {
  display: inline-block;
  margin: 0;
  padding: 4px 10px;
  border: 0;
  font-size: 10px;
  font-size: 1rem;
  background: #fff;
  color: #333;
  cursor: auto;
  border-radius: 5px;
  outline: 0;
  
}

.rating-form .btn-reset:hover,
.rating-form .btn-reset:focus {
  background: #a81c51;
}

.rating-form input[type="radio"]:checked ~ .form-action .btn-reset {
  cursor: pointer;
}

/* RATING - Form - Output */
.rating-form .form-output {
  display: none;
  position: absolute;
  right: 15px;
  bottom: -45px;
  font-size: 30px;
  font-size: 3rem;
  opacity: 0;
  
}

.no-js .rating-form .form-output {
  right: 5px;
  opacity: 1;
}

.rating-form input[type="radio"]:checked ~ .form-output {
  right: 5px;
  opacity: 1;
}
</style>
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
                        <h1 class="page-title"><a href="cart">Warna Artist</a></h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
                <div class="row">                    
                    <div class="col-12 col-md-4"> 
                        <div class="row">
                            <div class="col-12">
                                <div class="box p-30 pt-50 text-center">
                                    <div>
                                        <a class="avatar avatar-xxxl mb-3 bg-transparent" href="#">
                                
                                            <img src="<?php echo $image; ?>" class="rounded-circle" alt="...">
                                          
                                        </a>
                                    </div>

                                    <h2 class="mt-5 "><a class="text-default hover-primary" href="artist.php?id=<?php echo $id; ?>"><?php echo $full_name; ?></a></h2>

                                    <form class="rating-form" action="#" method="post" name="rating-movie">
                                      <fieldset class="form-group">
                                        
                                        <div class="form-item">
                                          
                                          <input id="rating-5" name="rating" type="radio" value="5" />
                                          <label for="rating-5" data-value="5" style="padding: 0;">
                                            <span class="rating-star">
                                              <i class="fa fa-star-o"></i>
                                              <i class="fa fa-star"></i>
                                            </span>
                                          </label>
                                          <input id="rating-4" name="rating" type="radio" value="4" />
                                          <label for="rating-4" data-value="4" style="padding: 0;">
                                            <span class="rating-star">
                                              <i class="fa fa-star-o"></i>
                                              <i class="fa fa-star"></i>
                                            </span>
                                          </label>0
                                          <input id="rating-3" name="rating" type="radio" value="3" />
                                          <label for="rating-3" data-value="3" style="padding: 0;">
                                            <span class="rating-star">
                                              <i class="fa fa-star-o"></i>
                                              <i class="fa fa-star"></i>
                                            </span>
                                          </label>
                                          <input id="rating-2" name="rating" type="radio" value="2" />
                                          <label for="rating-2" data-value="2" style="padding: 0;">
                                            <span class="rating-star">
                                              <i class="fa fa-star-o"></i>
                                              <i class="fa fa-star"></i>
                                            </span>
                                          </label>
                                          <input id="rating-1" name="rating" type="radio" value="1" />
                                          <label for="rating-1" data-value="1" style="padding: 0;">
                                            <span class="rating-star">
                                              <i class="fa fa-star-o"></i>
                                              <i class="fa fa-star"></i>
                                            </span>
                                          </label>                                          
                                        </div>                                        
                                      </fieldset>
                                    </form>

                                    <div id="rating_div">
                                        <div class="star-rating">
                                            <?php echo $rates; ?>
                                        </div>
                                    </div>

                                    <?php if (isset($designation)) : ?>
                                    <p class="mt-10" ><small class="font-size-16"><?php echo $designation; ?></small></p>
                                    <?php endif;?>

                                    <div class="gap-items font-size-16">
                                          <p class="">
                                            <?php echo $ar_serv_arr; ?>
                                          </p>
                                    </div>

                                    <div class="gap-items font-size-16">
                                          <?php if (isset($facebook_url) && strlen($facebook_url) > 0 ) : ?>
                                          <a class="text-facebook" href="<?php echo $facebook_url; ?>"><i class="fa fa-facebook"></i></a>
                                          <?php endif;?>

                                          <?php if (isset($instagram_url) && strlen($instagram_url) > 0 ) : ?>
                                          <a class="text-instagram" href="<?php echo $instagram_url; ?>"><i class="fa fa-instagram"></i></a>
                                          <?php endif;?>

                                          <?php if (isset($linkedin_url) && strlen($linkedin_url) > 0 ) : ?>
                                          <a class="text-linkedin" href="<?php echo $linkedin_url; ?>"><i class="fa fa-linkedin"></i></a>
                                          <?php endif;?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        <?php echo $descriptions; ?>
                                    </table>
                                </div>
                            </div>
                        </div>                                
                    </div>
                    <div class="col-12 col-md-8">
                        <div class="box">
                            <div class="box-header with-border">
                                <h5 class="box-title">Reviews ( <?php echo $rowCountReview; ?> )</h5>
                                <?php echo $msg; ?>  
                            </div>


                            <?php if (isset($comment)) : ?>
                            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto;">
                                <div class="box-body p-0">
                                    <div class="media-list" style="max-height: 60vh; overflow-y: scroll; width: auto;">
                                        <?php echo $comments; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif;?>                            

                        
                            <form id="commentform" action="" method="post" novalidate="novalidate" name="commentform">
                                <div class="col-md-12">

                                    <h5 class="my-10">Add Review</h5>
                                    <div class="form-group">
                                        <div class="controls">
                                            <textarea id="review" class="form-control" aria-invalid="false" name="review" title="add your review" placeholder="Review *" required ></textarea>                                            
                                        <div class="help-block"></div></div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group text-right" >
                                        <!-- <button type="submit" name="submit" class="btn btn-primary">Search</button> -->
                                        <input type="hidden" name="temp_review_id" id="temp-review-id" value="">
                                        <button type="submit" name="commentform" class="btn btn-outline btn-primary review-btn">Add Review</button>
                                        
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
              </div>


            <div class="row fx-element-overlay">

            <?php foreach ($a_products as $npr):?>

            <div class="col-md-12 col-lg-3">
                    <div class="box box-default">
                        <div class="fx-card-item">
                            <div class="fx-card-avatar fx-overlay-1"> <img src="<?php echo $npr['image']; ?>" alt="<?php echo $npr['title']; ?>"/>
                                <div class="fx-overlay">
                                    <ul class="fx-info">
                                        <li><a class="btn default btn-outline image-popup-vertical-fit" href="product?id=<?php echo $npr['id']; ?>"><i class="ion-search"></i> View </a></li>

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
                                <?php if ( $npr['post_method'] == 1 ) :?>  

                                <span class="amount">Rs. <?php echo $npr['price_label']; ?> </span> 
                                
                                <?php elseif ( $npr['post_method'] == 2 ) :
                                    
                                    $b = new Products();
                                    $current_bid = $b->current_ongoing_bid($npr['id'])['amount'];
                                ?>
                                <span class="amount text-primary"><i class="fa fa-gavel"></i> Rs. <?php echo number_format($current_bid, 2); ?> </span> 
                                <br>
                                <span class="amount text-primary" data-bid-end-time="<?php echo date('Y-m-d H:i:s', strtotime($npr['bid_end_time'])); ?>" style="font-size: 90%;"><i class="fa fa-clock-o"></i> 
                                    <label for="" class="text-primary bid-countdown">
                                        <span class="bid-days"></span>
                                        <span class="bid-hours"></span>
                                        <span class="bid-minutes"></span>
                                        <span class="bid-seconds"></span>                        
                                    </label>                                            
                                </span> 
                                <?php endif;?>
                                <br> 
                            </div>
                        </div>
                    </div>
                    <!-- /.box -->
            </div>
                

            <?php endforeach; ?>      

            </div>
            

            <!-- Start - pagination -->
            <?php echo $pagination; ?> 
            <!-- End - pagination --> 



            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include 'include/footer.php'; ?>
    </div>
    <!-- ./wrapper -->
<?php include 'include/script.php'; ?>

<script>
    $(document).ready(function(){
        $('.edit-this-review').on('click', function(e){
            e.preventDefault();
            var id = $(this).data('id');
            $('.review-btn').attr('name', 'commentform_update');
            $('.review-btn').html('Update Review');
            $('#temp-review-id').val(id);

            var content_id = '#review-content-'+id;
            var content = $(content_id).html();            

            $('#review').val(content);

            $('html, body').animate({
                scrollTop: $("#commentform").offset().top
            }, 2000);
        });
    });
</script>
</body>
</html>
