;(function ($) {
    // Modal
    $( '.atbdp-toggle-modal' ).on( 'click', function( e ) {
        e.preventDefault();

        var data_target = $( this ).data( 'target' );

        $( data_target ).toggleClass( 'show' );
    });
})(jQuery);