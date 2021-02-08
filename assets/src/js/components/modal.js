import '../../scss/component/_modal.scss';
;(function ($) {
    // Recovery Password Modal
    $("#recover-pass-modal").hide();

    $(".atbdp_recovery_pass").on("click", function (e) {
        e.preventDefault();
        $("#recover-pass-modal").slideToggle().show();
    });

    // Report abuse [on modal closed]
    $('#atbdp-report-abuse-modal').on('hidden.bs.modal', function (e) {

        $('#atbdp-report-abuse-message').val('');
        $('#atbdp-report-abuse-message-display').html('');

    });

    // Contact form [on modal closed]
    $('#atbdp-contact-modal').on('hidden.bs.modal', function (e) {

        $('#atbdp-contact-message').val('');
        $('#atbdp-contact-message-display').html('');

    });
    
    // Template Restructured 
    // Modal
    let directoristModal = document.querySelector('.directorist-modal-js');
    $( 'body' ).on( 'click', '.directorist-btn-modal-js', function( e ) {
        e.preventDefault();

        let data_target = $(this).attr("data-directoristTarget");
        console.log($(data_target),data_target);
        $( data_target ).toggleClass( 'directorist-show' );
    });

    $('body').on('click', '.directorist-modal-close-js', function(e){
        e.preventDefault();
        $(this).closest('.directorist-modal-js').removeClass('directorist-show');
    });

    $(document).bind('click', function(e) {
        if(e.target == directoristModal){
            directoristModal.classList.remove('directorist-show');
        }
    });
    
})(jQuery);