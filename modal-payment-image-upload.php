<div class="row" style="display: flex;flex-wrap: wrap;justify-content: center;">
    <div class="col-md-6">
        <div class="modal-content">
            <form id="uploadForm" enctype="multipart/form-data">
                <section class="panel">
                    <div class="modal-header">
                        <button type="button" class="close modal-dismiss">&times;</button>
                        <h4 class="modal-title">Upload Bank Deposit Slip</h4>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="" for="add-cost">Select Image</label>
                            </div>
                            <div class="col-sm-8">  
                                <input type="text" name="id" id="tmp_id_for_files" style="display: none;">
                                <input type="file" name="file" id="fileInput">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">  
                                <div class="progress">
                                    <!-- <div class="progress-bar"></div> -->
                                    <div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" role="progressbar"></div>

                                    <!-- <div class="progress-bar progress-bar-info progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"></div> -->
                                </div>
                                <div id="uploadStatus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer text-right w-p100">              
                        <button type="submit" name="submit" class="btn btn-info" on>Upload</button>
                        <button type="button" class="btn btn-default button-shadow modal-dismiss">Close</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</div>


<script>
$(document).ready(function(){
    // File upload via Ajax
    $("#uploadForm").on('submit', function(e){
        e.preventDefault();
        var tmp_id = $('#tmp_id_for_files').val();
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = ((evt.loaded / evt.total) * 100);
                        $(".progress-bar").width(percentComplete + '%');
                        $(".progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: 'POST',
            url: 'upload-payment-image.php',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $(".progress-bar").width('0%');
                $('#uploadStatus').html('<img src="assets/images/ajax-loader.gif"/>');
            },
            error:function(){
                $('#uploadStatus').html('<p style="color:#EA4335;">Image upload failed, please try again.</p>');
                $('#upload-status-msg').html('<span class="text-danger">Image upload failed!</span>');
            },
            success: function(resp){
                if(resp.status == 'ok'){
                    $('#uploadForm')[0].reset();
                    $('#uploadStatus').html('<p style="color:#28A74B;">Image has uploaded successfully!</p>');
                    $('#upload-status-msg').html('<span class="text-success">Image uploaded!</span>');

                    $('#payment-image').val(resp.filename);

                }else if(resp.status == 'err'){
                    $('#uploadStatus').html('<p style="color:#EA4335;">Please select a valid Image to upload.</p>');
                }
            }
        });
    });
  
    // File type validation
    /*$("#fileInput").change(function(){
        var allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        var file = this.files[0];
        var fileType = file.type;
        if(!allowedTypes.includes(fileType)){
            alert('Please select a valid file (PDF/DOC/DOCX/JPEG/JPG/PNG/GIF).');
            $("#fileInput").val('');
            return false;
        }
    });*/
});
</script>

