<?php
require_once 'config.php';

if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

$page_title = "Payment Submited";

if ( !isset( $_SESSION['user'] ) ) {
    header('location:./');
}

if ( isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = $db->query("SELECT * FROM `payments` WHERE `id` = '$id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){

        while($row = $query->fetch_assoc()){

            $order_id = $row['order_id'];
            $user_id = $row['user_id'];
            $amount = $row['amount'];
            $payment_date = date('Y-m-d', strtotime($row['payment_date']));
            $description = $row['description'];
            $created_time = date('Y-m-d h:i A', strtotime($row['created']));

            $amount_label = number_format($amount,2);

        }


        $od = new Orders();
        $full_name = $od->order($order_id)['full_name'];

    }

}


if ( $user_id != $this_user_id ) {
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
         
            <!-- Main content -->
            <section class="content">
            
            <div class="row">
                <div class="col-md-6 ml-auto mr-auto">
                    <div class="box bb-3 border-success text-center">
                        <div class="box-header bg-success text-white">
                            <h4 class="box-title">Your Payment has been submitted. </h4>
                        </div>

                        <div class="box-body">
                            
                            <h5 class="box-title text-primary">Your payment is waiting for administrator approval.</h5>
                            <br />
                            <!-- You will be recieved an email shortly once the admin approved your payment. -->
                            <div class="row">
                                <div class="col-md-8 ml-auto mr-auto text-left">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <td class="b-0 w-p40">ORDER ID</td>
                                                <td class="text-bold b-0"><?php echo $order_id; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="b-0">NAME</td>
                                                <td class="text-bold b-0"><?php echo $full_name; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="b-0">AMOUNT PAID</td>
                                                <td class="text-bold b-0"><?php echo $amount_label; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="b-0">PAYMENT DATE</td>
                                                <td class="text-bold b-0"><?php echo $payment_date; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="b-0">NOTE</td>
                                                <td class="text-bold b-0"><?php echo $description; ?></td>
                                            </tr>
                                            <tr>
                                                <td class="b-0">SUBMITTED TIME</td>
                                                <td class="text-bold b-0"><?php echo $created_time; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>                               
                      

                        </div>
                </div>
                 </div>
                <!-- /.col -->
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
