<?php
require 'config.php';

$this_id = '';
if (isset($_GET['id'])) {
    $this_id = $_GET['id'];

    $op = new Orders();
    $status = $op->order_product($this_id)['status'];
    $status_user_id = $op->order_product($this_id)['status_user_id'];
    $status_time = $op->order_product($this_id)['status_time'];

    $od = new Orders();
    $o_status_id = $od->order($order_id)['status'];

    $ops = new Users();
    $status_user_name = $ops->user($status_user_id)['full_name'];
    $status_user_role_id = $ops->user($status_user_id)['role_id'];

    

    
        
}

?>

<div class="row" style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="col-md-6">
        <div class="modal-content">
            <form id="uploadForm" enctype="multipart/form-data">
                <section class="panel">
                    <div class="modal-header">
                        <button type="button" class="close modal-dismiss">&times;</button>
                        <h4 class="modal-title">Status</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Status</p>
                            </div>
                            <div class="col-sm-8">  
                                <p><?php echo $status; ?></p>
                            </div>
                        </div>
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default button-shadow modal-dismiss">Close</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>