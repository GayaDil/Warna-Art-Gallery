<?php
require_once 'config.php';

$page_title =  "Profile";
$msg = '';
if (isset($_POST['general'])) {

    $first_name = $db->real_escape_string($_POST['first_name']);
    $last_name = $db->real_escape_string($_POST['last_name']);
    $phone = $db->real_escape_string($_POST['phone']);
    $address_1 = $db->real_escape_string($_POST['address_1']);
    $address_2 = $db->real_escape_string($_POST['address_2']);
    $town = $db->real_escape_string($_POST['town']);
    $state = $db->real_escape_string($_POST['state']);
    $postcode = $db->real_escape_string($_POST['postcode']);
    $country_id = $db->real_escape_string($_POST['country_id']);
    
    $db->query("UPDATE `users` SET `first_name`='$first_name',`last_name`='$last_name',`country_id`='$country_id',`phone`='$phone',`address_1`='$address_1',`address_2`='$address_2',`town`='$town',`state`='$state',`postcode`='$postcode' WHERE `id`= '$this_user_id'");

    $msg .= '<div class="alert alert-success"><strong>General details updated!</strong></div>';
}

$u = new Users();
$first_name = $u->user($this_user_id)['first_name'];
$last_name = $u->user($this_user_id)['last_name'];
$phone = $u->user($this_user_id)['phone'];
$address_1 = $u->user($this_user_id)['address_1'];
$address_2 = $u->user($this_user_id)['address_2'];
$town = $u->user($this_user_id)['town'];
$state = $u->user($this_user_id)['state'];
$postcode = $u->user($this_user_id)['postcode'];
$country_id = $u->user($this_user_id)['country_id'];

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


?>

<!DOCTYPE html>
<html lang="en">
<head>
<?php include 'include/head.php'; ?>
</head>
<body class="hold-transition skin-info fixed dark">
    <!-- Site wrapper -->
    <div class="wrapper frontend">
        

        <div class="header">
            <div class="container">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="navigation">
                            <nav class="navbar navbar-expand-lg navbar-light bg-theme">
                                <a class="navbar-brand" href="index.html"><img src="assets/images/logo.png" alt=""
                                        class="img-fluid"></a>
                                <button class="navbar-toggler" type="button" data-toggle="collapse"
                                    data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown"
                                    aria-expanded="false" aria-label="Toggle navigation">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                    <ul class="navbar-nav">
                                        <li class="nav-item">
                                            <a class="nav-link" href="./"><i class="mdi mdi-home"></i> Home</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./prevention.html">Prevention</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="./qurantine.html">Qurantine</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="javascript:void(0)" data-toggle="dropdown">Stats
                                            </a>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item" href="./stats.html">World Wide Stats </a>
                                                <a class="dropdown-item" href="./stats2.html">Country Wise State</a>
                                                <a class="dropdown-item" href="./stats3.html">Covid-19 Updates - Tiles</a>
                                                <a class="dropdown-item" href="./stats4.html">Country Wise - Tabs</a>
                                                <a class="dropdown-item" href="./stats5.html">Covid 19 Tracker</a>
                                            </div>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="help.html">Help</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="d-flex align-items-center">
                    <div class="mr-auto">
                        <h1 class="page-title"><a href="cart">Warna Profile</a></h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    
                    <div class="col-12 col-md-3"> 
                        <div class="row">
                            <div class="col-12">
                                <div class="table-responsive">
                                    <table class="table">
                                        
                                        <tbody>
                                            <tr>
                                                <td ><a href="orders"><i class="fa fa-bullhorn "></i>  My Orders</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="profile"><i class="fa fa-bullhorn"></i>  General Details</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-email"><i class="fa fa-bullhorn"></i>  Update Email</a></td>
                                            </tr>
                                            <tr>
                                                <td ><a href="update-password"><i class="fa fa-bullhorn"></i>  Update Password</a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>                                
                    </div>
                    <div class="col-12 col-md-9">
                        <div class="box">
                            <div class="box-header">
                              <h4 class="box-title"><strong>General Details</strong></h4>
                            </div>
                            <form  method="post" action="">                      
                            <div class="pad">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="first_name">First Name *</label>
                                            <input type="text" class="form-control " name="first_name" id="first_name" placeholder=""  value="<?php echo $first_name; ?>" required  /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="last_name">Last Name *</label>
                                            <input type="text" class="form-control " name="last_name" id="last_name" placeholder=""  value="<?php echo $last_name; ?>" required /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="address_1">Address 1 *</label>
                                            <input type="text" class="form-control " name="address_1" id="address_1" placeholder=""  value="<?php echo $address_1; ?>" required /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="address_2">Address 2</label>
                                            <input type="text" class="form-control" name="address_2" id="address_2" placeholder=""  value="<?php echo $address_2; ?>"  /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="phone">Phone *</label>
                                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Enter Phone"  value="<?php echo $phone; ?>" required /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="country">Country * </label>
                                            <select class="form-control" style="width: 100%;" name="country_id" id="country">
                                            <?php echo $country_list; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="state">State *</label>
                                            <input type="text" class="form-control " name="state" id="state" placeholder=""  value="<?php echo $state; ?>" required /> 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="town">Town / City *</label>
                                        <input type="text" class="form-control " value="<?php echo $town; ?>" id="town"  placeholder="" name="town" required /> 
                                    </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                        <label for="spostcode">Postcode *</label>
                                        <input type="text" class="form-control " name="postcode" id="postcode" placeholder=""  value="<?php echo $postcode; ?>" required /> </div>
                                    </div>
                                </div>    
                                <button type="submit" name="general" class="btn btn-outline btn-primary pull-right mb-30">Save</button>               
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
