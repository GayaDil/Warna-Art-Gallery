<?php
require 'config.php';



/*---------------------------user details from user tb------------------------*/
if ( isset($_GET['id'])) {
  $id = $_GET['id'];
  $ud = new Users();
  $role_id = $ud->user($id)['role_id'];
  $full_name = $ud->user($id)['full_name'];
  $email = $ud->user($id)['email'];
  $designation = $ud->user($id)['designation'];
  $phone = $ud->user($id)['phone'];
  $image = $ud->user($id)['image'];
  $town = $ud->user($id)['town'];
  $state = $ud->user($id)['state'];
  $country_name = $ud->user($id)['country_name'];
  $address_1 = $ud->user($id)['address_1'];
  $address = $ud->user($id)['address_1'].'<br>'.$ud->user($id)['address_2'];
  $created = date('d-F-Y h:i A', strtotime($ud->user($id)['created']));
  $status = $ud->user($id)['status'];
}

if ( $status == 1 ) {
  $status = "active";
  $status_label = "success";
}else{
  $status = "Disabled ";
  $status_label = "danger";
}

/*product count from product tb*/
$query = $db->query("SELECT COUNT(user_id) AS product_count FROM products WHERE user_id = '$id' ");
$row = $query->fetch_assoc();
$product_count = $row['product_count'];


$page_title =  $full_name;


/*---------------------------------order details from order tb------------------------------*/
$list = '';
$or = new Orders();
$orders = $or->all_orders($id, 2)['list'];
$total_pages = $or->all_orders()['total_pages'];

$no = 0;
foreach ($orders as $order){
    $no++;
    $o_id = $order['id'];
    $artist_id = $order['artist_id'];

    $oa = new Users();
    $artist_name = $oa->user($artist_id)['full_name']; 

    /*if($role_id == 2){
      $disply_name = $order['full_name']; //client
    }
    else{
      $oa = new Users();
      $disply_name = $oa->user($artist_id)['full_name'];
    }*/
        
    $os = new Orders();
    $o_status = $os->order_status($order['status'])['type'];
    $o_status_label = $os->order_status($order['status'])['label'];
    $o_created = date('Y-m-d h:i A',strtotime($order['created']));  

    $no = str_pad($no, 3,0,STR_PAD_LEFT);

    $list .= <<<EOD
    <tr>
        <td>$no</td>
        <td class="text-center">$o_id</td>
        <td class="text-center">$artist_name</td>
        <td class="text-center">$o_created</td>
        <td class="text-center"><span class="badge badge-$o_status_label">$o_status</span></td>
        <td class="text-right">
          <a class="btn btn-info btn-xs" href="order-view2?id=$id">
              <i class="fa fa-search"></i>
            </a>
            <a class="btn btn-info btn-xs" href="order?id=$id">
              <i class="fa fa-edit"></i>
            </a>
            <a class="btn btn-danger btn-xs" href="javascript:void(0);">
              <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
    EOD;
}


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




/*-------------------------Artist other infomation --------------------------*/
$ar_info_arr = '';

$sql = "SELECT 
ai.type_id AS type_id,
ait.type AS type
FROM artist_informations AS ai INNER JOIN artist_information_types AS ait ON ait.id = ai.type_id
WHERE ai.user_id = '$id' AND ai.status = '1' GROUP BY ai.type_id ";
$queryTypeIds = $db->query($sql);
$rowCountTypeIds = $queryTypeIds->num_rows;
if($rowCountTypeIds > 0){
    while($rowTypeIds = $queryTypeIds->fetch_assoc()){ 
      $this_type_id = $rowTypeIds['type_id'];
      $ait_type = $rowTypeIds['type'];

      $descriptions = '';
      $query = $db->query("SELECT * FROM `artist_informations` WHERE `user_id` = '$id' AND `type_id` = '$this_type_id' AND `status` = '1'");
      $rowCount = $query->num_rows;
      if($rowCount > 0){
          while($row = $query->fetch_assoc()){ 
              $temp_id = $row['id'];
              $description = $row['description'];
              
              $descriptions .= '<p>'.$description.'</p>';
          }
      }



      $ar_info_arr .= '<div class="card">
                                <div class="card-header" id="headingOne'.$this_type_id.'">
                                    <h2 class="mb-0">
                                        <button type="button" class="btn btn-link" data-toggle="collapse" data-target="#collapseOne'.$this_type_id.'"><i class="fa fa-plus"></i> '.$ait_type.'</button>                  
                                    </h2>
                                </div>
                                <div id="collapseOne'.$this_type_id.'" class="collapse" aria-labelledby="headingOne'.$this_type_id.'" data-parent="#accordionExample">
                                    <div class="card-body">
                                        '.$descriptions.'
                                    </div>
                                </div>
                            </div>';

  }
}



/*-------------------------------services info-------------------------------*/

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

        $ar_serv_arr .=  '<span class="badge badge-pink" style="margin-bottom:5px;">'.$ars_type.'</span> ';
    }
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>

  <style>
    .accordion {

      background-color: #eee;
      color: #444;
      cursor: pointer;
      padding: 18px;
      width: 100%;
      border: none;
      text-align: left;
      outline: none;
      font-size: 15px;
      transition: 0.4s;
    }

    .active, .accordion:hover {
      background-color: #ccc;
    }


    .active:after {
      content: "\2212";
    }

    .panel {
      padding: 0 18px;
      background-color: white;
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.2s ease-out;
    }


    .bs-example .card-header {
      padding: 0;

    }
  </style>
  
</head>

<body class="hold-transition skin-info fixed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <?php include 'include/header.php'; ?>
  
  <!-- Left side column. contains the logo and sidebar -->
  <?php include 'include/sidebar.php'; ?>
  

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="row">
    <!--<div class="d-flex align-items-center"> -->     
      <div class="col-md-6 mr-auto">
        <h3 class="page-title"><?php echo $page_title; ?></h3>
      </div>
      <div class="col-md-3 mr-auto ">
        
      </div>
       <?php if ( $role_id == 2 ) : ?> 
      <div class="col-md-3 mr-auto ">
        <a href="nic-view?id=<?php echo $id; ?>" class="btn btn-primary ">View Identity</a>
      </div> 
      <?php endif; ?>     
    <!--</div> -->
    </div>
  </div>

    <!-- Main content -->
    <section class="content">
        <div class="row">
          
          <div class="col-md-6">
            <div class="box">       
              <div class="box-header with-border">
                <h4 class="box-title">User Details</h4>
              </div>
              <div class="box-body">
                <!-- -->
                <div class="table-responsive">
                  <table class="table">
                    <?php if (( $role_id == 2 ) && ( strlen(trim($image)) > 0 )): ?>
                    <tr>
                      <td>Image</td>
                      <td><img src="<?php echo $image; ?>" style="width: 10%;"></td>
                    </tr>
                    <?php endif; ?>

                    <?php if ( strlen(trim($full_name)) > 0 ) :?>
                    <tr>
                      <td>Full Name</td>
                      <td><b><?php echo $full_name; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($email)) > 0 ) :?>
                    <tr>
                      <td>Email</td>
                      <td><b><?php echo $email; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($designation)) > 0 ) :?>
                    <tr>
                      <td>Designation</td>
                      <td><b><?php echo $designation; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($phone)) > 0 ) :?>
                    <tr>
                      <td>Contact</td>
                      <td><b><?php echo $phone; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($address)) > 0 ) :?>
                    <tr>
                      <td>Address </td>
                      <td><b><?php echo $address; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($town)) > 0 ) :?>
                    <tr>
                      <td>Town</td>
                      <td><b><?php echo $town; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($state)) > 0 ) :?>
                    <tr>
                      <td>State</td>
                      <td><b><?php echo $state; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($country_name)) > 0 ) :?>
                    <tr>
                      <td>Country</td>
                      <td><b><?php echo $country_name; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if (( $role_id == 2 ) && ( strlen(trim($product_count)) > 0 )) :?>
                    <tr>
                      <td>Total products</td>
                      <td><b><?php echo $product_count; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($created)) > 0 ) :?>
                    <tr>
                      <td>Join since</td>
                      <td><b><?php echo $created; ?></b></td>
                    </tr>
                    <?php endif;?>

                    <?php if ( strlen(trim($status)) > 0 ) :?>
                    <tr>
                      <td>Available</td>
                      <td ><span class="label label-<?php echo $status_label ?>"><?php echo $status; ?></span></td>
                    </tr>
                    <?php endif;?>
                    
                  </table>
                </div>
              </div>
            </div>
          </div>



          <?php if( $role_id == 2 ) :?>
          <div class="col-md-6">
            
            <?php if( strlen(trim($ars_type)) > 0 ) :?>
            <div class="box">       
              <div class="box-header with-border">
                <h4 class="box-title">Service Details</h4>
              </div>
              <div class="box-body">
                <!-- -->
                <?php echo $ar_serv_arr; ?>
              </div>
            </div>
            <?php endif;?>

            <?php if( strlen(trim($descriptions)) > 0 ) :?>
            <div class="box">       
              <div class="box-header with-border">
                <h4 class="box-title">Other Information</h4>
              </div>
              <div class="box-body">
                
                <!--
                <button class="accordion">Education</button>
                <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>

                <button class="accordion">Experience</button>
                <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>

                <button class="accordion">Exhibition</button>
                <div class="panel">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>

                  -->
                <div class="bs-example">
                  <div class="accordion" id="accordionExample">

                    <?php echo $ar_info_arr; ?>
                      
                  </div>
                </div>
              </div>
            </div>
            <?php endif;?>
        </div>
        <?php endif;?>

        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="box">       
              <div class="box-header with-border">
                <h4 class="box-title">Order details</h4>
              </div>
              <div class="box-body">
                <div class="table-responsive">
                  <table class="table table-hover">
                    <tr>
                      <th>#</th>
                      <th class="text-center">Order ID </th>
                      <th class="text-center">Artist Name</th>
                      <th class="text-center">Created</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Actions</th>
                    </tr>
                    <?php echo $list; ?>
                  </table>
                </div>

                <!-- Start - pagination -->
                <?php echo $pagination; ?> 
                <!-- End - pagination -->

              </div>
            </div>
          </div>
        </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
    

</div>
<!-- ./wrapper -->


  <?php include 'include/script.php'; ?>


<script>
    $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.show").each(function(){
          $(this).prev(".card-header").find(".fa").addClass("fa-minus").removeClass("fa-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
          $(this).prev(".card-header").find(".fa").removeClass("fa-plus").addClass("fa-minus");
        }).on('hide.bs.collapse', function(){
          $(this).prev(".card-header").find(".fa").removeClass("fa-minus").addClass("fa-plus");
        });
    });
</script>
  

</body>
</html>
