;(function ($) {
    //Star rating
    if ($('.stars').length) {
        $(".stars").barrating({
            theme: 'fontawesome-stars'
        });
    }
    // 	prepear_form_data
    function prepear_form_data ( form, field_map, data ) {
        if ( ! data || typeof data !== 'object' ) {
        var data = {};
        }

        for ( var key in field_map) {
        var field_item = field_map[ key ];
        var field_key = field_item.field_key;
        var field_type = field_item.type;

        if ( 'name' === field_type ) {
            var field = form.find( '[name="'+ field_key +'"]' );
        } else {
            var field = form.find( field_key );
        }

        if ( field.length ) {
            var data_key = ( 'name' === field_type ) ? field_key : field.attr('name') ;
            var data_value = ( field.val() ) ? field.val() : '';

            data[data_key] = data_value;
        }
        }

        return data;
    }

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

    // Review Attatchment
    function handleFiles(files) {
        var preview = document.getElementById('atbd_up_preview');
        for (var i = 0; i < files.length; i++) {
            var file = files[i];

            if (!file.type.startsWith('image/')) {
                continue
            }

            var img = document.createElement("img");
            img.classList.add("atbd_review_thumb");

            var imgWrap = document.createElement('div');
            imgWrap.classList.add('atbd_up_prev');

            preview.appendChild(imgWrap); // Assuming that "preview" is the div output where the content will be displayed.
            imgWrap.appendChild(img);
            $(imgWrap).append('<span class="rmrf">x</span>');


            var reader = new FileReader();
            reader.onload = (function (aImg) {
                return function (e) {
                    aImg.src = e.target.result;
                };
            })(img);
            reader.readAsDataURL(file);
        }
    }

    $('#atbd_review_attachment').on('change', function (e) {
        handleFiles(this.files);
    });

    // Load page 1 as the default
    if ($('#client_review_list').length) {
        atbdp_load_all_posts(1);
    }

    // remove the review of a user
    var delete_count = 1;
    
    $(document).on('click', '#atbdp_review_remove', function (e) {
        e.preventDefault();
        if (delete_count > 1) {
            // show error message
            swal({
                title: "WARNING!!",
                text: atbdp_public_data.review_have_not_for_delete,
                type: "warning",
                timer: 2000,
                showConfirmButton: false
            });
            return false; // if user try to submit the form more than once on a page load then return false and get out
        }
        var $this = $(this);
        var id = $this.data('review_id');
        var data = 'review_id=' + id;

        swal({
            title: atbdp_public_data.review_sure_msg,
            text: atbdp_public_data.review_want_to_remove,
            type: "warning",
            cancelButtonText: atbdp_public_data.review_cancel_btn_text,
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: atbdp_public_data.review_delete_msg,
            showLoaderOnConfirm: true,
            closeOnConfirm: false
        },
            function (isConfirm) {
                if (isConfirm) {
                    // user has confirmed, now remove the review
                    atbdp_do_ajax($this, 'remove_listing_review', data, function (response) {
                        if ('success' === response) {
                            // show success message
                            swal({
                                title: "Deleted!!",
                                type: "success",
                                timer: 200,
                                showConfirmButton: false
                            });
                            $("#single_review_" + id).slideUp();
                            $this.remove();
                            $('#review_content').empty();
                            $("#atbdp_review_form_submit").remove();
                            $(".atbd_review_rating_area").remove();
                            $("#reviewCounter").hide();
                            delete_count++; // increase the delete counter so that we do not need to delete the review more than once.
                        } else {
                            // show error message
                            swal({
                                title: "ERROR!!",
                                text: atbdp_public_data.review_wrong_msg,
                                type: "error",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });

        // send an ajax request to the ajax-handler.php and then delete the review of the given id

    });

    function atbdp_load_all_posts(page) {
        // Start the transition
        //$(".atbdp_pag_loading").fadeIn().css('background','#ccc');
        var listing_id = $('#review_post_id').attr('data-post-id');
        // Data to receive from our server
        // the value in 'action' is the key that will be identified by the 'wp_ajax_' hook
        var data = {
            page: page,
            listing_id: listing_id,
            action: "atbdp_review_pagination"
        };

        // Send the data
        $.post(atbdp_public_data.ajaxurl, data, function (response) {
            // If successful Append the data into our html container
            $('#client_review_list').empty().append(response);
            // End the transition
            //$(".atbdp_pag_loading").css({'background':'none', 'transition':'all 1s ease-out'});
        });
    }

    // Handle the clicks
    $('body').on('click', '.atbdp-universal-pagination li.atbd-active', function () {
        var page = $(this).attr('data-page');
        atbdp_load_all_posts(page);

    });
})(jQuery);