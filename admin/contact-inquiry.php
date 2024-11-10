<?php
require 'config.php';


if ( isset($_GET['id'])) {
  $id = $_GET['id'];


  //Mark as read all unread inquiries
  $cs = new Users();
  $cs->contact_inquiry_mark_as_read($id);


  $page_title = 'ORDER #'.$id;

  $ci = new Users();
  $full_name = $ci->contact_inquiries($id)['full_name'];
  $email = $ci->contact_inquiries($id)['email'];
  $phone = $ci->contact_inquiries($id)['phone'];
  $title = $ci->contact_inquiries($id)['title'];
  $description = $ci->contact_inquiries($id)['description'];
  $created = $ci->contact_inquiries($id)['created'];


  

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

        <div class="col-md-6">
          <div class="box">       
            <div class="box-header with-border">
              <h4 class="box-title">Contact inquiries</h4>
            </div>
            <div class="box-body">

              <div class="table-responsive ">
                <table class="table">
                  <?php if ( isset( $full_name ) ) :?>
                  <tr>
                    <td>Name</td>
                    <td><b><?php echo $full_name; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $email ) ) :?>
                  <tr>
                    <td>Email</td>
                    <td><b><?php echo $email; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $phone ) ) :?>
                  <tr>
                    <td>Phone</td>
                    <td><b><?php echo $phone; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $created ) ) :?>
                  <tr>
                    <td>Created </td>
                    <td><b><?php echo $created; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $title ) ) :?>
                  <tr>
                    <td>Title</td>
                    <td><b><?php echo $title; ?></b></td>
                  </tr>
                  <?php endif;?>

                  <?php if ( isset( $description ) ) :?>
                  <tr>
                    <td>Description</td>
                    <td><b><?php echo $description; ?></b></td>
                  </tr>
                  <?php endif;?>

                 


                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-6">
                    <div class="box">       
                        <div class="box-header with-border">
                            <h4 class="box-title">Response</h4>
                        </div>
                        <div class="box-body">
                          <label for="email">To:</label>
                            <div class="form-group">
                                <input type="text" class="form-control" id="email" name="email" placeholder="Subject goes here...." value="<?php echo $email; ?>" required="">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="inquiry-subject" name="" placeholder="Subject goes here...." required="">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="6" id="inquiry-note" placeholder="enter your inquiry here...."></textarea>
                            </div>
                            <div class="form-group">
                                <a href="javascript:void(0);" class="btn btn-outline btn-primary pull-right" id="send-email-inquiry" data-id="<?php echo $id; ?>">Submit</a>
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
