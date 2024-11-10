<?php
require 'config.php';


$this_id = '';
if (isset($_GET['id'])) {
    $this_id = $_GET['id'];


    $query = $db->query("SELECT * FROM `payments` WHERE `id` = '$this_id'");
    $rowCount = $query->num_rows;
    if($rowCount > 0){
        while($row = $query->fetch_assoc()){
            $amount = $row['amount'];
            $description = $row['description'];
            $status = $row['status'];
        }
    }


        
    $list = '';
    for ($i=0; $i < 3; $i++) { 

        if( $i == 0 ){
            $status_type = 'Pending Approval';
        }elseif ( $i == 1 ) {
            $status_type = 'Approved';
        }elseif ( $i == 2 ) {
            $status_type = 'Rejected';
        }


        $selected = ( $i == $status ) ? 'selected' : '';

        $list .= '<option value="'.$i.'" '.$selected.'>'.$status_type.'</option>';
    }

        
}

?>
<div class="row" style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="col-md-4">
        <div class="modal-content">
            <form id="uploadForm" enctype="multipart/form-data">
                <section class="panel">
                    <div class="modal-header">
                        <button type="button" class="close modal-dismiss">&times;</button>
                        <h4 class="modal-title">Payment ID# <?php echo $this_id; ?></h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Status</p>
                            </div>
                            <div class="col-sm-8">  
                                <div class="form-group">
                                    <select class="form-control" id="status">
                                        <?php echo $list; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Amount</p>
                            </div>
                            <div class="col-sm-8">  
                                <div class="form-group">
                                    <input class="form-control text-right" type="text" name="" id="amount" value="<?php echo $amount; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <p>Description</p>
                            </div>
                            <div class="col-sm-8">  
                                <div class="form-group">
                                    <textarea class="form-control" name="" id="description" rows="4"><?php echo $description; ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right w-p100">
                        <button type="button" class="btn btn-primary button-shadow order-payment-update" data-id="<?php echo $this_id; ?>">Save</button>
                        <button type="button" class="btn btn-default button-shadow modal-dismiss">Close</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>