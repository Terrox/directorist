;(function ($) {
    /* Add review to the database using ajax*/
    var submit_count = 1;
    $("#atbdp_review_form").on("submit", function () {
        if (submit_count > 1) {
            // show error message
            swal({
                title: atbdp_public_data.warning,
                text: atbdp_public_data.not_add_more_than_one,
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return false; // if user try to submit the form more than once on a page load then return false and get out
        }
        var $form = $(this);
        var $data = $form.serialize();

        var field_field_map = [
            { type: 'name', field_key: 'post_id' },
            { type: 'id', field_key: '#atbdp_review_nonce_form' },
            { type: 'id', field_key: '#guest_user_email' },
            { type: 'id', field_key: '#reviewer_name' },
            { type: 'id', field_key: '#review_content' },
            { type: 'id', field_key: '#review_rating' },
            { type: 'id', field_key: '#review_duplicate' },
        ];

        var _data = { action: 'save_listing_review' };
        _data = prepear_form_data( $form, field_field_map, _data );

        // atbdp_do_ajax($form, 'save_listing_review', _data, function (response) {

        jQuery.post(atbdp_public_data.ajaxurl, _data, function(response) {
            var output = '';
            var deleteBtn = '';
            var d;
            var name = $form.find("#reviewer_name").val();
            var content = $form.find("#review_content").val();
            var rating = $form.find("#review_rating").val();
            var ava_img = $form.find("#reviewer_img").val();
            var approve_immediately = $form.find("#approve_immediately").val();
            var review_duplicate = $form.find("#review_duplicate").val();
            if (approve_immediately === 'no') {
                if(content === '') {
                    // show error message
                    swal({
                        title: "ERROR!!",
                        text: atbdp_public_data.review_error,
                        type: "error",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    if (submit_count === 1) {
                        $('#client_review_list').prepend(output); // add the review if it's the first review of the user
                        $('.atbdp_static').remove();
                    }
                    submit_count++;
                    if (review_duplicate === 'yes') {
                        swal({
                            title: atbdp_public_data.warning,
                            text: atbdp_public_data.duplicate_review_error,
                            type: "warning",
                            timer: 3000,
                            showConfirmButton: false
                        });
                    } else {
                        swal({
                            title: atbdp_public_data.success,
                            text: atbdp_public_data.review_approval_text,
                            type: "success",
                            timer: 4000,
                            showConfirmButton: false
                        });
                    }
                }


            } else if (response.success) {
                output +=
                    '<div class="atbd_single_review" id="single_review_' + response.data.id + '">' +
                    '<input type="hidden" value="1" id="has_ajax">' +
                    '<div class="atbd_review_top"> ' +
                    '<div class="atbd_avatar_wrapper"> ' +
                    '<div class="atbd_review_avatar">' + ava_img + '</div> ' +
                    '<div class="atbd_name_time"> ' +
                    '<p>' + name + '</p>' +
                    '<span class="review_time">' + response.data.date + '</span> ' + '</div> ' + '</div> ' +
                    '<div class="atbd_rated_stars">' + print_static_rating(rating) + '</div> ' +
                    '</div> ';
                if( atbdp_public_data.enable_reviewer_content ) {
                output +=
                    '<div class="review_content"> ' +
                    '<p>' + content + '</p> ' +
                    //'<a href="#"><span class="fa fa-mail-reply-all"></span>Reply</a> ' +
                    '</div> ';
                }
                output +=
                    '</div>';

                // output += '<div class="single_review"  id="single_review_'+response.data.id+'">' +
                //     '<div class="review_top">' +
                //     '<div class="reviewer"><i class="fa fa-user" aria-hidden="true"></i><p>'+name+'</p></div>' +
                //     '<span class="review_time">'+d+'</span>' +
                //     '<div class="br-theme-css-stars-static">' + print_static_rating(rating)+'</div>' +
                //     '</div>' +
                //     '<div class="review_content">' +
                //     '<p> '+ content+ '</p>' +
                //     '</div>' +
                //     '</div>';

                // as we have saved a review lets add a delete button so that user cann delete the review he has just added.
                deleteBtn += '<button class="directory_btn btn btn-danger" type="button" id="atbdp_review_remove" data-review_id="' + response.data.id + '">Remove</button>';
                $form.append(deleteBtn);
                if (submit_count === 1) {
                    $('#client_review_list').prepend(output); // add the review if it's the first review of the user
                    $('.atbdp_static').remove();
                }
                var sectionToShow = $("#has_ajax").val();
                var sectionToHide = $(".atbdp_static");
                var sectionToHide2 = $(".directory_btn");
                if (sectionToShow) {
                    // $(sectionToHide).hide();
                    $(sectionToHide2).hide();
                }
                submit_count++;
                // show success message
                swal({
                    title: atbdp_public_data.review_success,
                    type: "success",
                    timer: 800,
                    showConfirmButton: false
                });

                //reset the form
                $form[0].reset();
                // remove the notice if there was any
                $r_notice = $('#review_notice');
                if ($r_notice) {
                    $r_notice.remove();
                }
            } else {
                // show error message
                swal({
                    title: "ERROR!!",
                    text: atbdp_public_data.review_error,
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });

        return false;
    });
})(jQuery);