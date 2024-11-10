<?php
require 'config.php';


$this_id = '';
if (isset($_GET['id'])) {
    $this_id = $_GET['id'];

    $p = new Products();
    $image = $p->product($this_id)['image_name'];
    $title = $p->product($this_id)['title'];
  
    $img_path = 'assets/artworks/'.$this_id.'/';
    $image = $img_path.$image;
        

}


?>


<div class="row" style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="col-md-10">
        <div class="modal-content">
            <form id="uploadForm" enctype="multipart/form-data">
                <section class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <img src="<?php echo $image; ?>" id="product-image"  alt="<?php echo $title; ?>" title="<?php echo $title; ?>" />
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer pull-right" >
                        <button type="button" class="btn btn-default button-shadow modal-dismiss" >Close</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>