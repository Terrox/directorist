;(function ($) {
    
    // Dashboard Listing Ajax
    function directorist_dashboard_listing_ajax($activeTab,paged=1,search='',task='',taskdata='') {
        var tab = $activeTab.data('tab');
        $.ajax({
            url: atbdp_public_data.ajaxurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'action': 'directorist_dashboard_listing_tab',
                'tab': tab,
                'paged': paged,
                'search': search,
                'task': task,
                'taskdata': taskdata,
            },
			beforeSend: function () {
				$('#directorist-dashboard-preloader').show();
			},
            success: function success(response) {
                $('.directorist-dashboard-listings-tbody').html(response.data.content);
                $('.directorist-dashboard-pagination .nav-links').html(response.data.pagination);
                $('.directorist-dashboard-listing-nav-js a').removeClass('tabItemActive');
                $activeTab.addClass('tabItemActive');
                $('#my_listings').data('paged',paged);
            },
			complete: function () {
				$('#directorist-dashboard-preloader').hide();
			}
        });
    }

    // Dashboard Listing Tabs
    $('.directorist-dashboard-listing-nav-js a').on('click', function(event) {
        var $item = $(this);

    	if ($item.hasClass('tabItemActive')) {
    		return false;
    	}

        directorist_dashboard_listing_ajax($item);
        $('#directorist-dashboard-listing-searchform input[name=searchtext').val('');
        $('#my_listings').data('search','');

    	return false;
    });

    // Dashboard Tasks eg. delete
    $('.directorist-dashboard-listings-tbody').on('click', '.directorist-dashboard-listing-actions a[data-task]', function(event) {
    	var task       = $(this).data('task');
    	var postid     = $(this).closest('tr').data('id');
    	var $activeTab = $('.directorist-dashboard-listing-nav-js a.tabItemActive');
    	var paged      = $('#my_listings').data('paged');
    	var search     = $('#my_listings').data('search');

		if (task=='delete') {
	        swal({
	            title: atbdp_public_data.listing_remove_title,
	            text: atbdp_public_data.listing_remove_text,
	            type: "warning",
	            cancelButtonText: atbdp_public_data.review_cancel_btn_text,
	            showCancelButton: true,
	            confirmButtonColor: "#DD6B55",
	            confirmButtonText: atbdp_public_data.listing_remove_confirm_text,
	            showLoaderOnConfirm: true,
	            closeOnConfirm: false
	        },

	        function (isConfirm) {
	            if (isConfirm) {
	            	directorist_dashboard_listing_ajax($activeTab,paged,search,task,postid);

                    swal({
                        title: atbdp_public_data.listing_delete,
                        type: "success",
                        timer: 200,
                        showConfirmButton: false
                    });
	            }
	        });
		}

    	return false;
    });
})(jQuery);