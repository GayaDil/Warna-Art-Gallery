<?php
require_once 'config.php';

$this_id = $_GET['id'];

//$this_id = 2;

$bl = new Blogs();
$image = $bl->blog($this_id)['image_frontend'];
$title = $bl->blog($this_id)['title'];
$content = $bl->blog($this_id)['content'];
$created_time = $bl->blog($this_id)['created_time'];
$user_id = $bl->blog($this_id)['user_id'];

$pa = new Users();
$full_name = $pa->user($user_id)['full_name'];
$artist_image = $pa->user($user_id)['image_front'];


$page_title = "Blog -" . "$title";




//Meta varialbles
$meta_page_title = $title;
$meta_page_description = strip_tags($content);
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
                        <h1 class="page-title"><a href="blog">Warna Blog</a> </h1>
                    </div>
                </div>
            </div>
         
            <!-- Main content -->
            <section class="content">
            
                <div class="row">
                    <div class="col-md-9">
                        <div class="box">                            
                            <figure class="img-hov-zoomin">
                            <a href="blog?id=<?php echo $this_id; ?>"><img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" title="<?php echo $title; ?>" style="width: 100%;"></a>
                            </figure>

                            <div class="box-body">
                                <div class="blog-header-area mb-20">
                                    <div class="d-flex align-items-center">                       
                                        <div class="gap-items font-size-16">
                                            <a class="text-facebook" href="#" onclick="share_fb('<?php echo $meta_page_url; ?>');return false;" share_url="<?php echo $meta_page_url; ?>" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                                            <a class="text-whatsapp whatsapp-this" href="#"><i class="fa fa-whatsapp" title="Share on Whatsapp"></i></a>
                                            <a class="text-google" href="javascript:emailThisPage()" title="Email This"><i class="fa fa-envelope"></i></a>
                                      </div>                               
                                    </div>

                                    <div>
                                        <h2><a href="blog?id=<?php echo $this_id; ?>"><?php echo $title; ?></a></h2>
                                    </div>
                                    
                                    
                                </div>
                                
                                                       
                                <div class="blog-content">
                                   <?php echo $content; ?> 
                                </div>
                                
                                <div style="float: right; margin-bottom: 20px;">                        
                                    <div class="gap-items font-size-16">
                                        <a class="text-facebook" href="#" onclick="share_fb('<?php echo $meta_page_url; ?>');return false;" share_url="<?php echo $meta_page_url; ?>" target="_blank" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                                            <a class="text-whatsapp whatsapp-this" href="#"><i class="fa fa-whatsapp" title="Share on Whatsapp"></i></a>
                                            <a class="text-google" href="javascript:emailThisPage()" title="Email This"><i class="fa fa-envelope"></i></a>
                                  </div>                               
                                </div> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="box p-30 pt-50 text-center">
                            <div>
                                <a class="avatar avatar-xxxl mb-3 bg-transparent" href="#">
                                <img src="<?php echo $artist_image; ?>" class="rounded-circle" alt="...">                                 
                                </a>
                            </div>
                                
                                <p> <i class="fa fa-user"></i> By  <a title="ram" href="#"> <?php echo $full_name; ?> </a> </p>
                                <p> <i class="fa fa-calendar"></i> <?php echo $created_time; ?> </p>
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
</body>
</html>
