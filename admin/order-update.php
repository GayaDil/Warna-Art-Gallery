<?php
require 'config.php';

$page_title =  "Update order";


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

}


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>
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
        <!--</div> -->
    </div>
    </div>

    <!-- Main content -->
    <section class="content">

      <div class="row">
          <div class="col-8 mr-auto ml-auto">
            <div class="box">       
                  <div class="box-header with-border">
                        <h4 class="box-title">Order Details</h4>                                 
                  </div>
              <div class="box-body">
            

                <div class="pad p-20">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="billing_email">Email Address *</label>
                                <input type="email" class="form-control" name="email" id="billing_email" placeholder="Enter email"  value="<?php echo $email; ?>" required /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="billing_phone">Phone *</label>
                                <input type="text" class="form-control" name="phone" id="billing_phone" placeholder="Enter Phone"  value="<?php echo $phone; ?>" required /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_first_name">First Name *</label>
                                <input type="text" class="form-control " name="first_name" id="shipping_first_name" placeholder=""  value="<?php echo $first_name; ?>" required  /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_last_name">Last Name *</label>
                                <input type="text" class="form-control " name="last_name" id="shipping_last_name" placeholder=""  value="<?php echo $last_name; ?>" required /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_address_1">Address 1 *</label>
                                <input type="text" class="form-control " name="address_1" id="shipping_address_1" placeholder="Street Name"  value="<?php echo $address_1; ?>" required /> </div>
                            </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_address_2">Address 2</label>
                                <input type="text" class="form-control" name="address_2" id="shipping_address_2" placeholder="Apartment Name, No.. etc"  value="<?php echo $address_2; ?>"  /> 
                            </div>
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
                                <input type="text" class="form-control " name="state" id="shipping_state" placeholder="State"  value="<?php echo $state; ?>" required /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="shipping_city">Town / City *</label>
                                <input type="text" class="form-control " value="<?php echo $town; ?>" id="shipping_city"  placeholder="Town / City" name="town" required /> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                              <label for="shipping_postcode">Postcode *</label>
                              <input type="text" class="form-control " name="postcode" id="shipping_postcode" placeholder="Postcode / Zip"  value="<?php echo $postcode; ?>" required /> 
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="order_comments">Optional Message</label>
                                <textarea name="note" class="form-control " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="4" ><?php echo $note; ?></textarea> 
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
          </div>

      
      </div>


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
    

</div>
<!-- ./wrapper -->


    <?php include 'include/script.php'; ?>
    

</body>
</html>
