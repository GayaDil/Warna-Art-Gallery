<!-- jQuery 3 -->
<script src="../assets/backend/vendor_components/jquery-3.3.1/jquery-3.3.1.js"></script>

<!-- popper -->
<script src="../assets/backend/vendor_components/popper/dist/popper.min.js"></script>

<!-- Bootstrap 4.0-->
<script src="../assets/backend/vendor_components/bootstrap/dist/js/bootstrap.min.js"></script>

<script src="../assets/backend/vendor_components/magnific-popup/dist/jquery.magnific-popup.min.js"></script>
<script src="../assets/backend/js/examples.modals.js"></script> 

<!-- Bootstrap Select -->
<script src="../assets/backend/vendor_components/bootstrap-select/dist/js/bootstrap-select.js"></script>

<!-- Select2 -->
<script src="../assets/backend/vendor_components/select2/dist/js/select2.full.js"></script>






<!-- SlimScroll -->
<script src="../assets/backend/vendor_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="../assets/backend/vendor_components/fastclick/lib/fastclick.js"></script>

<!-- Sweet-Alert  -->
<script src="../assets/backend/vendor_components/sweetalert2/sweetalert.min.js"></script>
<script src="../assets/backend/js/sweet-alert.custom.js"></script>

<script src="../assets/backend/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
<script src="../assets/backend/js/pages/toastr.js"></script>
<script src="../assets/backend/js/pages/notification.js"></script>

<!-- Superieur Admin App -->
<script src="../assets/backend/js/template.js"></script>


<script src="../assets/backend/js/pages/advanced-form-element.js"></script>



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