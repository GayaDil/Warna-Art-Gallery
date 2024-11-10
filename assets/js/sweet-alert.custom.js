
/*START -ARTIST - APPROVE STEP 2*/
$(document).ready(function(){
    $(document).on('click', '.step_2_approve', function(e){
        
        var id = $(this).data('id');
        var note = 'Artist approval';

        approveStep2(id,note);
        e.preventDefault();
    });
});

function approveStep2(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Approve this Order?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=approve_step_2&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ARTIST - APPROVE STEP 2*/



/*START -ARTIST - REJECT STEP 2*/
$(document).ready(function(){
    $(document).on('click', '.step_2_reject', function(e){
        
        var id = $(this).data('id');
        var note = 'Artist Reject';

        rejectStep2(id,note);
        e.preventDefault();
    });
});

function rejectStep2(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Reject this Order?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=reject_step_2&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ARTIST - REJECT STEP 2*/





/*START -ADMIN - APPROVE STEP 4*/
$(document).ready(function(){
    $(document).on('click', '.step_4_approve', function(e){
        
        var id = $(this).data('id');
        var note = 'Payment approval';

        approveStep4(id,note);
        e.preventDefault();
    });
});

function approveStep4(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Approve this Payment?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=approve_step_4&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ADMIN - APPROVE STEP 4*/




/*START -ADMIN - REJECT STEP 4*/
$(document).ready(function(){
    $(document).on('click', '.step_4_reject', function(e){
        
        var id = $(this).data('id');
        var note = 'Payment Reject';

        rejectStep4(id,note);
        e.preventDefault();
    });
});

function rejectStep4(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Reject this Payment?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=reject_step_4&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ADMIN - REJECT STEP 4*/




/*START -ARTIST - APPROVE STEP 5*/
$(document).ready(function(){
    $(document).on('click', '.step_5_approve', function(e){
        
        var id = $(this).data('id');
        var note = 'Order Dispatch';

        approveStep5(id,note);
        e.preventDefault();
    });
});

function approveStep5(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure that you have already dispatched this order?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=approve_step_5&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ARTIST - APPROVE STEP 5*/





/*START -ARTIST - REJECT STEP 5*/
$(document).ready(function(){
    $(document).on('click', '.step_5_reject', function(e){
        
        var id = $(this).data('id');
        var note = 'Shipment Cancel';

        rejectStep5(id,note);
        e.preventDefault();
    });
});

function rejectStep5(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to Cancel this Shipment?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: '../common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=reject_step_5&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ARTIST - REJECT STEP 5*/





/*------------------------USER----------------------*/


/*START  - USER PASSWORD UPDATE*/
$(document).ready(function(){
    $(document).on('submit', '#form-user-password', function(e){
        
        var form = $('#form-user-password').serialize();

        updatePassword(form);
        e.preventDefault();
    });
});

function updatePassword(formData){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to update password?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-users.php',
                    type: 'POST',
                    data: 'type=update_user_password&'+formData,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }

                    if ( response.status_type == 'error' ) {
                        $('#current_password').val('');
                        $('#new_password').val('');
                        $('#re_password').val('');
                    } 

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END  - USER PASSWORD UPDATE*/


/*START  - USER EMAIL UPDATE*/
$(document).ready(function(){
    $(document).on('submit', '#form-user-email', function(e){
        
        var form = $('#form-user-email').serialize();

        updateEmail(form);
        e.preventDefault();
    });
});

function updateEmail(formData){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to update email?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-users.php',
                    type: 'POST',
                    data: 'type=update_user_email&'+formData,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }

                    if ( response.status_type == 'error' ) {
                        $('#e_password').val('');
                    } 

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END  - USER EMAIL UPDATE*/




/*START  - USER CONTACT INQUIRY*/
$(document).ready(function(){
    $(document).on('submit', '#form-inquiry', function(e){
        
        var form = $('#form-inquiry').serialize();

        addInquiry(form);
        e.preventDefault();
    });
});

function addInquiry(formData){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to submit this inquiry?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-users.php',
                    type: 'POST',
                    data: 'type=add_inquiry&'+formData,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }

                    if ( response.status_type == 'error' ) {
                        $('#e_password').val('');
                    } 

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END  - USER INQUIRY*/




/*START  - PLACE BID */
$(document).ready(function(){
    $(document).on('click', '.place-bid', function(e){
        
        var product_id = $(this).data('id');
        var amount = $('#bid-amount').val();
        placeBid(product_id, amount);
        e.preventDefault();
    });
});

function placeBid(product_id, amount){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to place this Bid?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-bid.php',
                    type: 'POST',
                    data: 'type=place_bid&product_id='+product_id+'&amount='+amount,
                    dataType: 'json'
                })
                .done(function(response){
                    swal(response.msg_header, response.msg_body, response.msg_type);

                    if ( response.msg_type == 'success' ) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END  -PLACE BID*/





/*----- ORDER------*/



/*START  - SHIPPING DETALS UPDATE*/
$(document).ready(function(){
    $(document).on('submit', '#form-shipping', function(e){
        
        var form = $('#form-shipping').serialize();

        updateShipping(form);
        e.preventDefault();
    });
});

function updateShipping(formData){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to update this details?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-orders.php',
                    type: 'POST',
                    data: 'type=update_shipping&'+formData,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }

                    if ( response.status_type == 'error' ) {
                        $('#e_password').val('');
                    } 

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END  -SHIPPING DETALS UPDATE*/








/*START OrderInquiry */
$(document).ready(function(){
    $(document).on('click', '#place-inquiry', function(e){
        
        var id = $(this).data('id');
        var subject = $('#inquiry-subject').val();
        var note = $('#inquiry-note').val();


        adddOrderInquiry(id,subject,note);
        e.preventDefault();
    });
});

function adddOrderInquiry(id,subject,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to submit this inquiry?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'ajax/ajax-orders.php',
                    type: 'POST',
                    data: 'type=add_order_inquiry&id='+id+'&note='+note+'&subject='+subject,
                    dataType: 'json'
                })
                .done(function(response){
                    swal(response.status_header, response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -OrderInquiry*/





/*START - USER - PAYMENT ADD -STEP 3*/
$(document).ready(function(){
    $(document).on('click', '.add-payment', function(e){
        
        var formData = $('#form-payment').serialize();

        addPayment(formData);
        e.preventDefault();
    });
});

function addPayment(formData){

    swal({
        title: "Are you sure?",
        text: "Are you sure you want to save this form?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=add_payment&'+formData,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, response.status_type);

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}

/*END - USER - PAYMENT ADD -STEP 3*/




/*START -USER- CONFIRM STEP 6*/
$(document).ready(function(){
    $(document).on('click', '.mark-as-order-received', function(e){
        
        var id = $(this).data('id');
        var note = 'Order Collect';

        confirmStep6(id,note);
        e.preventDefault();
    });
});

function confirmStep6(id,note){

    swal({
        title: "Are you sure?",
        text: "Are you sure you have already collected this order?",
        icon: "warning",
        buttons: { 
            yes: {
                text: "Yes",
                value: "yes",
            },
            cancel: "Cancel",
        },
    })
    .then((value) => {
        switch (value) {

            case "yes":
            setTimeout(function() {
                $.ajax({
                    url: 'common/ajax/ajax-steps.php',
                    type: 'POST',
                    data: 'type=confirm_step_6&id='+id+'&note='+note,
                    dataType: 'json'
                })
                .done(function(response){
                    swal('Done!', response.message, 'success');

                    if ( response.status_type == 'success' ) {
                        setTimeout(function () {
                            window.location.href = response.url;
                        }, 1000);
                    }  

                })
                .fail(function(){
                    swal('Oops...', 'Something went wrong with ajax !', 'error');
                });
            }, 50);

            break;

            default:
            swal("Cancelled!");
            break;
        }
    });
}
/*END -ARTIST - APPROVE STEP 5*/




