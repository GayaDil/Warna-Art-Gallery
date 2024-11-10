<?php
require 'config.php';
$page_title = 'Add New Blog Post';

$save_btn = '<a href="javascript:void(0);" class="btn btn-primary add-new-blog">SAVE</a>';
$img_upload_url = 'modal-blogpost-image-upload.php';
$temp_input = '';

if ( isset($_GET['id'])) {
  $get_id = $_GET['id'];

  $page_title = 'Update Blog Post';

  $bl = new Blogs();
  $title = $bl->blog($get_id)['title'];
  $content = $bl->blog($get_id)['content'];
  $image = $bl->blog($get_id)['image'];
  $image_backend = $bl->blog($get_id)['image_backend'];
  $created_time = $bl->blog($get_id)['created_time'];

  $save_btn = '<a href="javascript:void(0);" class="btn btn-primary update-blog">SAVE</a>';
  $temp_input = '<input type="text" name="temp_id" value="'.$get_id.'" style="display: none;">';
  $img_upload_url = 'modal-blogpost-image-upload.php?id='.$get_id;

}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <?php include 'include/head.php'; ?>
  <link rel="stylesheet" href="../assets/backend/vendor_components/summernote/summernote.css">
  <link rel="stylesheet" href="../assets/backend/vendor_components/croppie/croppie.min.css">
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
    <div class="d-flex align-items-center">
      <div class="mr-auto">
        <h3 class="page-title"><?php echo $page_title; ?></h3>
      </div>
    </div>
  </div>

    <!-- Main content -->
    <section class="content">

      <div class="box">
        <form method="POST" id="form-blog">
        <!-- /.box-header -->
          <div class="box-body">
            <div class="row">

              <div class="col-md-12">
                <div class="form-group">
                  <label>Title</label>
                  <input type="text" class="form-control" placeholder="Enter ..." name="title" value="<?php echo $title; ?>" required>
                </div>
              </div> <!--- nkljh ---->

              <div class="col-md-12">
                <div class="form-group">
                  <label>Content</label>
                  <textarea class="form-control summernote-text" rows="3" placeholder="Enter ..." style="height: 199px;" name="content"><?php echo $content; ?></textarea>
                </div>
              </div>

               <!-- <div class="col-md-2">
                <a href="<?php echo $img_upload_url; ?>" class="simple-ajax-modal btn btn-info">Upload Image</a>
                <input type="hidden" id="uploaded-image" name="image" value="<?php echo $image; ?>">
              </div> -->

                <div class="col-md-6">
                  <div class="form-group">
                      <label class="d-block">Profile Image</label>
                      <label class="file">
                          <input type="file" accept="image/*" class="file-styled-primary" id="thumb_image" >
                      </label>
                  </div>

                  <div class="row" style="">
                      <div class="col-12" id="uploaded_thumb">
                          <div id="thumb_image_demo" style=""></div>
                          <input type="hidden" name="image" id="image_thumb" value="<?php echo $image_name; ?>">
                      </div>
                  </div>

                  <div class="row">
                      <div class="col-md-6">
                          <p class="text-success" id="image-status"></p>
                      </div>
                      <div class="col-md-4 text-right">
                          <span class="btn btn-info btn-sm thumb_crop">Apply</span>
                      </div>
                  </div>

                  </div>
                  <div class="col-md-6 d-flex" id="uploaded_image">
                      <?php if (isset($image)) :?>
                          <div class="d-flex align-items-center justify-content-center">
                              <img src="<?php echo $image_backend; ?>">
                          </div>

                      <?php endif;?>
                  </div>


              <div class="col-md-10">                
                <?php echo $temp_input; ?>
                <?php echo $save_btn; ?>
              </div>
            </div>

          </div>
          <div class="box-footer">
            
          </div>
        <!-- /.box-body -->
        </form>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 
  <?php include 'include/footer.php'; ?>
     

</div>
<!-- ./wrapper -->


  <?php include 'include/script.php'; ?>
  <script src="../assets/backend/vendor_components/summernote/summernote.js"></script>
  <script src="../assets/backend/vendor_components/croppie/croppie.min.js"></script>
<script>
    //Start - Croppie
    $image_thumb = $('#thumb_image_demo').croppie({
        enableExif: true,
        viewport: {
            width:280,
            height:147,
            type:'square' //circle
        },
        boundary:{
            width:300,
            height:300
        }
    });

    $('#thumb_image').on('change', function(){
        var reader = new FileReader();
        reader.onload = function (event) {
            $image_thumb.croppie('bind', {
                url: event.target.result
            });
        };
        reader.readAsDataURL(this.files[0]);
        $('#uploaded_thumb').show();
    });


    $('.thumb_crop').click(function(event){


        $image_thumb.croppie('result', {
            type: 'canvas',
            /*size: 'original'*/
            size: {
                width: 1200,
                height: 630
            }
        }).then(function(response){

            $.ajax({
                url: "ajax/ajax-blog.php",
                type: "POST",
                data: {"type":"upload_blog_image","image":response},
                success: function (data) {
                    $('#image_thumb').val(data.filename);
                    $('#image-status').html(data.status);
                    var img = '<div class="d-flex align-items-center justify-content-center"><img src="'+data.file_with_path+'"></div>';
                    $('#uploaded_image').html(img);
                }
            });

        })
    });
    //End - Croppie
</script>
  <script>
      $('.summernote-text').summernote({
        minHeight: 300,
        maxHeight: 300,
        /*toolbar: false,*/
      });

      $(".summernote-text").on("summernote.enter", function(we, e) {
         $(this).summernote("pasteHTML", "<br><br>");
         e.preventDefault();
      });

  </script>

</body>
</html>
