(function( $ ) {

    'use strict';

    /*
    Modal Dismiss
    */
    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });


    /*
    Ajax
    */
    $('.simple-ajax-modal').magnificPopup({
        type: 'ajax',
        modal: true
    });

}).apply( this, [ jQuery ]);