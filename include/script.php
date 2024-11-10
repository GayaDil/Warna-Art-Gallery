<!-- jQuery 3 -->
<script src="assets/vendor_components/jquery-3.3.1/jquery-3.3.1.js"></script>

<!-- popper -->
<script src="assets/vendor_components/popper/dist/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="assets/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="assets/vendor_components/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="assets/js/examples.modals.js"></script> 

<!-- Bootstrap Select -->
<script src="assets/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>

<!-- Select2 -->
<script src="assets/vendor_components/select2/dist/js/select2.full.js"></script>






<!-- SlimScroll -->
<script src="assets/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="assets/vendor_components/fastclick/lib/fastclick.js"></script>

<!-- Sweet-Alert  -->
<script src="assets/vendor_components/sweetalert2/sweetalert.min.js"></script>
<script src="assets/js/sweet-alert.custom.js"></script>

<script src="assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
<script src="assets/js/pages/toastr.js"></script>
<script src="assets/js/pages/notification.js"></script>

<!-- Superieur Admin App -->
<script src="assets/js/template.js"></script>


<script src="assets/js/pages/advanced-form-element.js"></script>


<script>
	jQuery(document).ready(function(){

		jQuery('.add-this-to-cart').on('click', function(e){

			var id = jQuery(this).data('id');
			var quantity = jQuery(this).data('quantity');



			jQuery.ajax({
                url: 'ajax/ajax-cart.php',
                type: 'POST',
                data: 'type=add_to_cart&id='+id+'&quantity='+quantity,
                success: function (data) {
                	
                	if ( data.count > 0 ) {
                		jQuery('.cart-count').html('<span class="badge badge-dark badge-pill">'+data.count+'</span>');
                	}else{
                		jQuery('.cart-count').html('');
                	}

                    jQuery.toast({
                        heading: data.msg_header,
                        text: data.msg_body,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: data.msg_type,
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });

		});


        jQuery('.add-all-to-cart').on('click', function(e){

            var id = $(this).data('id');
            var quantity = $('.product-quantity').val();



            jQuery.ajax({
                url: 'ajax/ajax-cart.php',
                type: 'POST',
                data: 'type=add_to_cart&id='+id+'&quantity='+quantity,
                success: function (data) {
                    
                    if ( data.count > 0 ) {
                        jQuery('.cart-count').html('<span class="badge badge-dark badge-pill">'+data.count+'</span>');
                    }else{
                        jQuery('.cart-count').html('');
                    }

                    jQuery.toast({
                        heading: data.msg_header,
                        text: data.msg_body,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: data.msg_type,
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });

        });


        jQuery('.cart-qty').on('keyup change', function () {
            var id = jQuery(this).data('id');            
            var value = parseInt(jQuery(this).val() );

            var line_total = jQuery(this).parent().siblings('.line-total');

            jQuery.ajax({
                url: 'ajax/ajax-cart.php',
                type: 'POST',
                data: 'type=update_cart_quantity&id='+id+'&quantity='+value,
                success: function (data) {

                    jQuery('.cart-count').html('<span class="badge badge-dark badge-pill">'+data.count+'</span>');
                    jQuery('.cart-sub-total').html('Rs. '+data.sub_total);
                    jQuery('.cart-total').html('Rs. '+data.total);
                    jQuery(line_total).html(data.line_total);
                    
                    jQuery.toast({
                        heading: data.msg_header,
                        text: data.msg_body,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: data.msg_type,
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
        });


        jQuery('.delete-cart-item').on('click', function () {
            var id = jQuery(this).data('id');
            var row = '#row-'+id;

            jQuery.ajax({
                url: 'ajax/ajax-cart.php',
                type: 'POST',
                data: 'type=delete_cart_item&id='+id,
                success: function (data) {

                    if ( data.count > 0 ) {
                        jQuery('.cart-count').html('<span class="badge badge-dark badge-pill">'+data.count+'</span>');
                    }else{
                        jQuery('.cart-count').html('');
                    }

                    jQuery('.cart-sub-total').html('Rs. '+data.sub_total);
                    jQuery('.cart-total').html('Rs. '+data.total);
                    jQuery(row).fadeOut('linear');

                    jQuery.toast({
                        heading: data.msg_header,
                        text: data.msg_body,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: data.msg_type,
                        hideAfter: 3000,
                        stack: 6
                    });
                }
            });
        });

	});
</script>

<script>
$(function(){

    setInterval(function() {

        $('[data-bid-end-time]').each(function() {

            var endTime = new Date($(this).data('bid-end-time'));          
            endTime = (Date.parse(endTime) / 1000);

            var now = new Date();
            now = (Date.parse(now) / 1000);

            var timeLeft = endTime - now;

            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
  
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }

            $(this).children('.bid-countdown').children('.bid-days').html(days + "d");
            $(this).children('.bid-countdown').children('.bid-hours').html(hours + "h");
            $(this).children('.bid-countdown').children('.bid-minutes').html(minutes + "m");
            $(this).children('.bid-countdown').children('.bid-seconds').html(seconds + "s");

        });


    }, 1000);
        
});
</script>