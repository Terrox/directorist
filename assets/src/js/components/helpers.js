;(function ($) {
    
    /*HELPERS*/
    function print_static_rating($star_number) {
        var v;
        if ($star_number) {
            v = '<ul>';
            for (var i = 1; i <= 5; i++) {
                v += (i <= $star_number)
                    ? "<li><span class='rate_active'></span></li>"
                    : "<li><span class='rate_disable'></span></li>";
            }
            v += '</ul>';
        }

        return v;
    }

    // helper function to convert the mysql date
    Date.createFromMysql = function (mysql_string) {
        var t, result = null;

        if (typeof mysql_string === 'string') {
            t = mysql_string.split(/[- :]/);

            //when t[3], t[4] and t[5] are missing they defaults to zero
            result = new Date(t[0], t[1] - 1, t[2], t[3] || 0, t[4] || 0, t[5] || 0);
        }

        return result;
    };


    /*This function handles all ajax request*/
    function atbdp_do_ajax(ElementToShowLoadingIconAfter, ActionName, arg, CallBackHandler) {
        var data;
        if (ActionName) data = "action=" + ActionName;
        if (arg) data = arg + "&action=" + ActionName;
        if (arg && !ActionName) data = arg;
        //data = data ;

        var n = data.search(atbdp_public_data.nonceName);
        if (n < 0) {
            data = data + "&" + atbdp_public_data.nonceName + "=" + atbdp_public_data.nonce;
        }

        jQuery.ajax({
            type: "post",
            url: atbdp_public_data.ajaxurl,
            data: data,
            beforeSend: function () {
                jQuery("<span class='atbdp_ajax_loading'></span>").insertAfter(ElementToShowLoadingIconAfter);
            },
            success: function (data) {
                jQuery(".atbdp_ajax_loading").remove();
                CallBackHandler(data);
            }
        });
    }

    //adding temporary css class to post draft page
    if ($(".edit_btn_wrap .atbdp_float_active").length) {
        $("body").addClass("atbd_post_draft");
    }
    
    //
    $('.atbd_listing_no_image .atbd_lower_badge').each(function(i, elm){
        if( !$.trim( $(elm).html() ).length ) {
            $(this).addClass('atbd-no-spacing');
        }
    });

})(jQuery);