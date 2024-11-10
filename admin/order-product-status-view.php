<?php
require 'config.php';


$this_id = '';
if (isset($_GET['id'])) {
    $this_id = $_GET['id'];

    $op = new Orders();
    $order_id = $op->order_product($this_id)['order_id'];
    $status = $op->order_product($this_id)['status'];
    $status_label = $op->order_product($this_id)['status_label'];
    $status_user_id = $op->order_product($this_id)['status_user_id'];
    $status_time = date('d-F-Y h:i A', strtotime($op->order_product($this_id)['status_time']));


    $od = new Orders();
    $o_status_id = $od->order($order_id)['status'];

    $opu = new Users();
    $status_user_name = $opu->user($status_user_id)['full_name'];
    $status_user_role_id = $opu->user($status_user_id)['role_id'];

    $status_user_role = '';
    if ( $o_status_id > 1 ) {
        $us = new Users();
        $status_user_role = $us->user_role($status_user_role_id).' - ';
    }
        



}

?>
<div class="row" style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="col-md-6">
        <div class="modal-content">
            <form id="uploadForm" enctype="multipart/form-data">
                <section class="panel">
                    <div class="modal-header">
                        <button type="button" class="close modal-dismiss">&times;</button>
                        <h4 class="modal-title">Status <?php echo $text; ?></h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Status</p>
                            </div>
                            <div class="col-sm-8">  
                                <p><span class="badge badge-<?php echo $status_label; ?>"><?php echo $status_user_role.$status; ?></span></p>
                            </div>
                        </div>
                        <?php if ( $o_status_id > 1 ) :?>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>User</p>
                            </div>
                            <div class="col-sm-8">  
                                <p><?php echo $status_user_name; ?></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Status time</p>
                            </div>
                            <div class="col-sm-8">  
                                <p><?php echo $status_time; ?></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default button-shadow modal-dismiss">Close</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>