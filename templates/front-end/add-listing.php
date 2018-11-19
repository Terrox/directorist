<?php
$p_id = get_query_var('atbdp_listing_id', 0);
if (!empty($p_id)) {
    $p_id = absint($p_id);
    $listing  = get_post( $p_id ); //@TODO; ADD security to prevent user from editing other posts from front end and backend (except admin)
    // kick the user out if he tries to edit the listing of other user
    if ($listing->post_author != get_current_user_id() && !current_user_can('edit_others_at_biz_dirs')){
        echo '<p class="error">'.__('You do not have permission to edit this listing', ATBDP_TEXTDOMAIN).'</p>';
        return;
    }

    $listing_info['never_expire']           = get_post_meta($p_id, '_never_expire', true);
    $listing_info['featured']               = get_post_meta($p_id, '_featured', true);
    $listing_info['price']                  = get_post_meta($p_id, '_price', true);
    $listing_info['videourl']               = get_post_meta($p_id, '_videourl', true);
    $listing_info['listing_status']         = get_post_meta($p_id, '_listing_status', true);
    $listing_info['tagline']                = get_post_meta($p_id, '_tagline', true);
    $listing_info['excerpt']                = get_post_meta($p_id, '_excerpt', true);
    $listing_info['address']                = get_post_meta($p_id, '_address', true);
    $listing_info['phone']                  = get_post_meta($p_id, '_phone', true);
    $listing_info['email']                  = get_post_meta($p_id, '_email', true);
    $listing_info['website']                = get_post_meta($p_id, '_website', true);
    $listing_info['social']                 = get_post_meta($p_id, '_social', true);
    $listing_info['manual_lat']             = get_post_meta($p_id, '_manual_lat', true);
    $listing_info['manual_lng']             = get_post_meta($p_id, '_manual_lng', true);
    $listing_info['bdbh']                   = get_post_meta($p_id, '_bdbh', true);
    $listing_info['listing_img']            = get_post_meta($p_id, '_listing_img', true);
    $listing_info['hide_contact_info']      = get_post_meta($p_id, '_hide_contact_info', true);
    $listing_info['expiry_date']            = get_post_meta($p_id, '_expiry_date', true);

    extract($listing_info);
    //for editing page
    $p_tags = wp_get_post_terms($p_id, ATBDP_TAGS);
    $p_locations = wp_get_post_terms($p_id, ATBDP_LOCATION);
    $p_cats = wp_get_post_terms($p_id, ATBDP_CATEGORY);
}
// prevent the error if it is not edit listing page when listing info var is not defined.
if (empty($listing_info )) {$listing_info = array();}

$t = get_the_title();
$t = !empty( $t ) ? esc_html($t) : __('No Title ', ATBDP_TEXTDOMAIN);
$tg = !empty( $tagline ) ? esc_html($tagline) : '';
$ad = !empty( $address ) ? esc_html($address) : '';
$image = (!empty($listing_img[0])) ? "<img src='". esc_url(wp_get_attachment_image_url($listing_img[0], 'thumbnail'))."'>": '';
/*build the markup for google map info window*/
$info_content = "<div class='map_info_window'> <h3> {$t} </h3>";
$info_content .= "<p> {$tg} </p>";
$info_content .= $image ; // add the image if available
$info_content .= "<p> {$ad}</p></div>";
// grab social information
$social_info = !empty( $social ) ? (array) $social : array();
$listing_img = !empty( $listing_img ) ? (array) $listing_img : array();

// get the category and location lists/array
$categories = get_terms(ATBDP_CATEGORY, array('hide_empty' => 0));
$locations = get_terms(ATBDP_LOCATION, array('hide_empty' => 0));
$listing_tags = get_terms(ATBDP_TAGS, array('hide_empty' => 0));

// get the map zoom level from the user settings
$map_zoom_level = get_directorist_option('map_zoom_level', 16);
$disable_map = get_directorist_option('disable_map');
$disable_price = get_directorist_option('disable_list_price');
$enable_video_url = get_directorist_option('atbd_video_url',1);
$disable_contact_info = get_directorist_option('disable_contact_info');

// get the custom terms and conditions
$listing_terms_condition_text = get_directorist_option('listing_terms_condition_text');

/* @todo: Shahadat -> this page heavily modified, please test it better */
?>

<div id="directorist" class="directorist atbd_wrapper atbd_add_listing_wrapper">
    <div class="<?php echo is_directoria_active() ? 'container': ' container-fluid'; ?>">
        <form action="<?= esc_url($_SERVER['REQUEST_URI']); ?>" method="post">
            <?php
                do_action('atbdb_before_add_listing_from_frontend');//for dev purpose
                ?>
            <div class="atbdp-form-fields">
            <div class="atbd_add_listing_title">
                <h3><?= !empty($p_id) ? __('Update Listing', ATBDP_TEXTDOMAIN) : __('Add Listing', ATBDP_TEXTDOMAIN); ?></h3>
            </div>

            <!--add nonce field security -->
            <?php  ATBDP()->listing->add_listing->show_nonce_field(); ?>
            <input type="hidden" name="add_listing_form" value="1">
            <input type="hidden" name="listing_id" value="<?= !empty($p_id) ?  esc_attr($p_id) : ''; ?>">


        <?php
        //to show validation notification @todo;letter need to validate with ajax action and identify the required field with color
            $all_validation = ATBDP()->listing->add_listing->add_listing_to_db();
            echo $all_validation;
        ?>

        <div class="row">
            <div class="col-md-12">
                    <?php
                    /**
                     * It fires before the listing title
                     * @param string $type Page type.
                     * @since 1.1.1
                     **/
                    do_action('atbdp_edit_before_title_fields', 'add_listing_page_frontend');
                    ?>
                    <div class="atbd_content_module atbd_general_information_module">
                        <div class="atbd_content_module__tittle_area">
                            <div class="atbd_area_title">
                                <h4><?php esc_html_e('General information', ATBDP_TEXTDOMAIN) ?></h4>
                            </div>
                        </div>

                        <div class="atbdb_content_module_contents">
                            <div class="form-group">
                                <label for="listing_title"><?php esc_html_e('Title:', ATBDP_TEXTDOMAIN); echo '<span style="color: red"> *</span>'; ?></label>
                                <input type="text" name="listing_title" value="<?= !empty($listing->post_title) ? esc_attr($listing->post_title):'';?>" class="form-control directory_field" placeholder="<?= __('Enter a title', ATBDP_TEXTDOMAIN); ?>"/>
                            </div>

                            <div class="form-group">
                                <label for="listing_content"><?php esc_html_e('Long Description', ATBDP_TEXTDOMAIN) ?></label>
                                <?php wp_editor(
                                    !empty($listing->post_content) ? wp_kses($listing->post_content, wp_kses_allowed_html('post')) :'',
                                    'listing_content',
                                    array(
                                        'media_buttons' => false,
                                        'quicktags'     => true,
                                        'editor_height' => 200
                                    )); ?>
                            </div>

                            <div class="atbd_optional_field">
                                <label for="atbd_optional_field_check"><input id="atbd_optional_field_check" type="checkbox"> Tagline/Motto of your business or listing (optional)</label>
                                <div class="atbd_tagline_moto_field">
                                    <div class="form-group">
                                        <label for="atbdp_excerpt"><?php esc_html_e('Tag-line/Motto', ATBDP_TEXTDOMAIN); ?></label>
                                        <input type="text" name="tagline" value="<?= !empty($tagline) ? esc_attr($tagline): ''; ?>" class="form-control directory_field" placeholder="<?= __('Your Organization\'s motto or tag-line', ATBDP_TEXTDOMAIN); ?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="atbdp_excerpt"><?php esc_html_e('Short Description/Excerpt(eg. Text shown on Image Hover in grid layout):', ATBDP_TEXTDOMAIN) ?></label>
                                        <!--@todo; later let user decide if he wants to show tinymce or normal textarea-->
                                        <textarea name="excerpt" id="atbdp_excerpt"  class="form-control directory_field" cols="30" rows="5" placeholder="<?= __('Short Description or Excerpt', ATBDP_TEXTDOMAIN); ?>"> <?= !empty($excerpt) ? esc_textarea( stripslashes($excerpt)) : ''; ?> </textarea>
                                    </div>
                                </div>
                            </div>

                            <!--***********************************************************************
                                 Run the custom field loop to show all published custom fields asign to form
                                 **************************************************************************-->
                            <?php
                            // custom fields information
                            //// get all the custom field that has posted by admin ane return the field
                            $custom_fields  = new WP_Query( array(
                                'post_type'      => ATBDP_CUSTOM_FIELD_POST_TYPE,
                                  'posts_per_page' => -1,
                                'post_status'    => 'publish',
                                'meta_key'       => 'associate',
                                'meta_value'     => 'form'
                            ) );
                            $fields = $custom_fields->posts;

                            foreach ($fields as $post){
                                setup_postdata($post);
                                $post_id = $post->ID;
                                $cf_required = get_post_meta(get_the_ID(), 'required', true);
                                $post_meta = get_post_meta( $post_id );
                                ?>
                                <div class="form-group">
                                    <label for=""><?php the_title(); ?><?php if($cf_required){echo '<span style="color: red"> *</span>'; }?></label>
                                    <?php
                                    if( isset( $post_meta[ $post->ID ] ) ) {
                                        $value = $post_meta[0];
                                    }
                                    $value =  get_post_meta($p_id, $post_id, true); ///store the value for the db
                                    $cf_meta_default_val = get_post_meta(get_the_ID(), 'default_value', true);

                                    if( isset( $post_id ) ) {
                                        $cf_meta_default_val = $post_id[0];
                                    }
                                    $cf_meta_val = get_post_meta(get_the_ID(), 'type', true);
                                    $cf_rows = get_post_meta(get_the_ID(), 'rows', true);
                                    $cf_placeholder = get_post_meta(get_the_ID(), 'placeholder', true);

                                    switch ($cf_meta_val){
                                        case 'text' :
                                            echo '<div>';
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<input type="text" name="custom_field[%d]" class="form-control directory_field" placeholder="%s" value="%s"/>',$post_id,$cf_placeholder, $value );
                                            echo '</div>';
                                            break;
                                        case 'textarea' :
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));

                                            printf( '<textarea  class="form-control directory_field" name="custom_field[%d]" class="textarea" rows="%d" placeholder="%s">%s</textarea>', $post->ID, (int) $cf_rows,esc_attr( $cf_placeholder ), esc_textarea( $value ) );
                                            break;
                                        case 'radio':
                                            $choices = get_post_meta(get_the_ID(), 'choices', true);
                                            $choices = explode( "\n", $choices );
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            echo '<ul class="atbdp-radio-list radio vertical">';
                                            foreach( $choices as $choice ) {
                                                if( strpos( $choice, ':' ) !== false ) {
                                                    $_choice = explode( ':', $choice );
                                                    $_choice = array_map( 'trim', $_choice );

                                                    $_value  = $_choice[0];
                                                    $_label  = $_choice[1];
                                                } else {
                                                    $_value  = trim( $choice );
                                                    $_label  = $_value;
                                                }

                                                $_checked = '';
                                                if( trim( $value ) == $_value ) $_checked = ' checked="checked"';

                                                printf( '<li><label><input type="radio" name="custom_field[%d]" value="%s"%s>%s</label></li>', $post->ID, $_value, $_checked, $_label );
                                            }
                                            echo '</ul>';
                                            break;

                                        case 'select' :
                                            $choices = get_post_meta(get_the_ID(), 'choices', true);
                                            $choices = explode( "\n", $choices );
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<select name="custom_field[%d]" class="form-control directory_field">', $post->ID );
                                            if( ! empty( $field_meta['allow_null'][0] ) ) {
                                                printf( '<option value="">%s</option>', '- '.__( 'Select an Option', 'advanced-classifieds-and-directory-pro' ).' -' );
                                            }
                                            foreach( $choices as $choice ) {
                                                if( strpos( $choice, ':' ) !== false ) {
                                                    $_choice = explode( ':', $choice );
                                                    $_choice = array_map( 'trim', $_choice );

                                                    $_value  = $_choice[0];
                                                    $_label  = $_choice[1];
                                                } else {
                                                    $_value  = trim( $choice );
                                                    $_label  = $_value;
                                                }

                                                $_selected = '';
                                                if( trim( $value ) == $_value ) $_selected = ' selected="selected"';

                                                printf( '<option value="%s"%s>%s</option>', $_value, $_selected, $_label );
                                            }
                                            echo '</select>';
                                            break;

                                        case 'checkbox' :
                                            $choices = get_post_meta(get_the_ID(), 'choices', true);
                                            $choices = explode( "\n", $choices );

                                            $values = explode( "\n", $value );
                                            $values = array_map( 'trim', $values );
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            echo '<ul class="atbdp-checkbox-list checkbox vertical">';

                                            foreach( $choices as $choice ) {
                                                if( strpos( $choice, ':' ) !== false ) {
                                                    $_choice = explode( ':', $choice );
                                                    $_choice = array_map( 'trim', $_choice );

                                                    $_value  = $_choice[0];
                                                    $_label  = $_choice[1];
                                                } else {
                                                    $_value  = trim( $choice );
                                                    $_label  = $_value;
                                                }

                                                $_checked = '';
                                                if( in_array( $_value, $values ) ) $_checked = ' checked="checked"';

                                                printf( '<li><label><input type="hidden" name="custom_field[%s][]" value="" /><input type="checkbox" name="custom_field[%d][]" value="%s"%s>%s</label></li>', $post->ID, $post->ID, $_value, $_checked, $_label );
                                            }
                                            echo '</ul>';
                                            break;
                                        case 'url'  :
                                            echo '<div>';
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<input type="text" name="custom_field[%d]" class="form-control directory_field" placeholder="%s" value="%s"/>', $post->ID, esc_attr( $cf_placeholder ), esc_url( $value ) );
                                            echo '</div>';
                                            break;

                                        case 'date'  :
                                            echo '<div>';
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<input type="date" name="custom_field[%d]" class="form-control directory_field" placeholder="%s" value="%s"/>', $post->ID, esc_attr( $cf_placeholder ), esc_attr( $value ) );
                                            echo '</div>';
                                            break;

                                        case 'email'  :
                                            echo '<div>';
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<input type="email" name="custom_field[%d]" class="form-control directory_field" placeholder="%s" value="%s"/>', $post->ID, esc_attr( $cf_placeholder ), esc_attr( $value ) );
                                            echo '</div>';
                                            break;
                                        case 'color'  :
                                            echo '<div>';
                                            printf('<p style="font-style: italic">%s</p>', get_post_meta(get_the_ID(), 'instructions', true));
                                            printf( '<input type="text" name="custom_field[%d]" id="color_code2" class="my-color-field" value="%s"/>', $post->ID, $value );
                                            echo '</div>';
                                            break;
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                            ?>

                            <div class="form-group">
                                <label for="at_biz_dir-location"><?php esc_html_e('Location:', ATBDP_TEXTDOMAIN); ?></label>
                                <?php if (!empty($p_locations)) {
                                    $output = array();
                                    foreach ($p_locations as $p_location) {
                                        $output[]= $p_location->name;
                                    }
                                    echo '<p class="c_cat_list">'. __('Current Location:', ATBDP_TEXTDOMAIN) .join(', ', $output) .'</p>';
                                } ?>
                                <select name="tax_input[at_biz_dir-location][]" class="form-control" id="at_biz_dir-location" multiple="multiple">

                                    <?php foreach ($locations as $location) {
                                        echo "<option id='atbdp_location' value='$location->term_id'>$location->name</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="at_biz_dir-tags"><?php esc_html_e('Tags:', ATBDP_TEXTDOMAIN); ?></label>
                                <?php if (!empty($p_tags)) {
                                    $output = array();
                                    foreach ($p_tags as $p_tag) {
                                        $output[]= $p_tag->name;
                                    }
                                    echo '<p class="c_cat_list">'. __('Current Tags:', ATBDP_TEXTDOMAIN) .join(', ', $output) .'</p>';
                                } ?>
                                <select name="tax_input[at_biz_dir-tags][]" class="form-control" id="at_biz_dir-tags" multiple="multiple" >

                                    <?php foreach ($listing_tags as $l_tag) { ?>
                                        <option id='atbdp_tag' value='<?= $l_tag->name ?>'><?= esc_html($l_tag->name) ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <?php if (!$disable_price) { ?>
                                <div class="form-group">
                                    <!--@todo; Add currency Name near price-->
                                    <label for="price"><?php esc_html_e('Price ( Optional---Leave it blank to hide it)', ATBDP_TEXTDOMAIN) ?></label>
                                    <input type="text" id="price" name="price" value="<?= !empty($price) ? esc_attr($price): ''; ?>" class="form-control directory_field" placeholder="<?= __('Price of this listing. Eg. 100', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>
                            <?php } ?>

                            <!--***********************************************************************
                                Run the custom field loop to show all published custom fields asign to Category
                             **************************************************************************-->
                            <!--@ Options for select the category.-->
                            <div class="form-group">

                                <label for="atbdp_select_cat"><?php esc_html_e('Select Category', ATBDP_TEXTDOMAIN) ?></label>
                                <?php

                                $current_val = esc_attr(get_post_meta($p_id, '_admin_category_select', true) );
                                $categories = get_terms(ATBDP_CATEGORY, array('hide_empty' => 0));
                                echo '<select class="form-control directory_field" id="cat-type" name="admin_category_select">';
                                echo '<option value="">'.__( "--Select a Category--", ATBDP_TEXTDOMAIN ).'</option>';
                                foreach ($categories as $key => $cat_title){
                                    $term_id = $cat_title->term_id;
                                    printf( '<option value="%s" %s>%s</option>', $term_id, selected( $term_id, $current_val), $cat_title->name );
                                }
                                echo '</select>';
                                $term_id_selected = $current_val;
                                ?>
                                <input type="hidden" id="value_selected" value="<?php echo $term_id_selected?>">
                            </div>

                            <?php
                            if($enable_video_url) {
                                ?>
                                <div class="form-group">
                                    <label for="videourl"><?php esc_html_e('Video Url', ATBDP_TEXTDOMAIN) ?></label>
                                    <input type="text" id="videourl" name="videourl" value="<?= !empty($videourl) ? esc_url($videourl): ''; ?>" class="form-control directory_field" placeholder="<?= __('Only YouTube & Vimeo URLs.', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>
                            <?php } ?>
                        </div>
                    </div><!-- end .atbd_custom_fields_contents -->

                    <?php if (!$disable_contact_info){ ?>
                        <div class="atbd_content_module atbd_contact_information">
                            <div class="atbd_content_module__tittle_area">
                                <div class="atbd_area_title">
                                    <h4><?php esc_html_e('Contact Information', ATBDP_TEXTDOMAIN) ?></h4>
                                </div>
                            </div>

                            <div class="atbdb_content_module_contents">
                                <div class="form-check">
                                    <input type="checkbox" name="hide_contact_info" class="form-check-input" id="hide_contact_info" value="1" <?php if(!empty($hide_contact_info) ) {checked($hide_contact_info); } ?> >
                                    <label class="form-check-label" for="hide_contact_info"><?php esc_html_e('Check it to hide Contact Information for this listing', ATBDP_TEXTDOMAIN); ?></label>
                                </div>

                                <div class="form-group">
                                    <label for="address"><?php esc_html_e('Address:', ATBDP_TEXTDOMAIN); ?></label>
                                    <input type="text" name="address" id="address" value="<?= !empty($address) ? esc_attr($address): ''; ?>" class="form-control directory_field" placeholder="<?php esc_html_e('Listing address eg. Houghton Street London WC2A 2AE UK', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="atbdp_phone_number"><?php esc_html_e('Phone Number:', ATBDP_TEXTDOMAIN); ?></label>
                                    <input type="tel" name="phone" id="atbdp_phone_number" value="<?= !empty($phone) ? esc_attr($phone): ''; ?>" class="form-control directory_field" placeholder="<?php esc_attr_e('Phone Number', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="atbdp_email"><?php esc_html_e('Email:', ATBDP_TEXTDOMAIN); ?></label>
                                    <input type="email" name="email" id="atbdp_email" value="<?= !empty( $email ) ? esc_attr($email) : ''; ?>" class="form-control directory_field" placeholder="<?php esc_attr_e('Enter Email', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="atbdp_website"><?php esc_html_e('Website:', ATBDP_TEXTDOMAIN); ?></label>

                                    <input type="text" id="atbdp_website" name="website" value="<?= !empty( $website ) ? esc_url($website) : ''; ?>" class="form-control directory_field" placeholder="<?php esc_attr_e('Listing website eg. http://example.com', ATBDP_TEXTDOMAIN); ?>"/>
                                </div>

                                <div class="form-group">
                                    <?php
                                    /**
                                     * It fires before social information fields
                                     * @param string $type Page type.
                                     * @param array $listing_info Information of the current listing
                                     * @since 1.1.1
                                     **/
                                    do_action('atbdp_edit_before_social_info_fields', 'add_listing_page_frontend', $listing_info);


                                    ATBDP()->load_template('meta-partials/social', array('social_info' => $social_info));

                                    /**
                                     * It fires after social information fields
                                     * @param string $type Page type.
                                     * @param array $listing_info Information of the current listing
                                     * @since 1.1.1
                                     **/
                                    do_action('atbdp_edit_after_social_info_fields', 'add_listing_page_frontend', $listing_info);

                                    ?>
                                </div>
                            </div>
                        </div><!-- end .atbd_general_information_module -->

                        <div class="atbd_content_module atbd_location_map_setting">
                            <div class="atbd_content_module__tittle_area">
                                <div class="atbd_area_title">
                                    <h4><?php esc_html_e('Location (Map)', ATBDP_TEXTDOMAIN) ?></h4>
                                </div>
                            </div>
                            
                            <div class="atbdb_content_module_contents">
                                <div class="cor-wrap form-group">
                                    <?php $map_guide = sprintf("<span class='color:#c71585;'>%s</span>", __('SET 0 to LAT & LONG Field to HIDE MAP FOR THIS LISTING', ATBDP_TEXTDOMAIN)); ?>
                                    <label for="manual_coordinate"><input type="checkbox" name="manual_coordinate" value="1" id="manual_coordinate" <?= (!empty($manual_coordinate)) ? 'checked' : ''; ?> > <?php
                                        printf(__('Enter Coordinates ( latitude and longitude) Manually ? or set the marker on the map anywhere by clicking on the map. %s', ATBDP_TEXTDOMAIN), $map_guide)
                                        ?>
                                    </label>
                                </div>

                                <?php if (!$disable_map) { ?>
                                    <!--Show map only if it is not disabled in the settings-->
                                    <div class="row">
                                        <div id="hide_if_no_manual_cor" class="clearfix">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="manual_lat"> <?php _e('Latitude', ATBDP_TEXTDOMAIN); ?>  </label>
                                                    <input type="text" name="manual_lat" id="manual_lat"
                                                           value="<?= !empty($manual_lat) ? esc_attr($manual_lat) : ''; ?>"
                                                           class="form-control directory_field"
                                                           placeholder="<?php esc_attr_e('Enter Latitude eg. 24.89904', ATBDP_TEXTDOMAIN); ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group">
                                                    <label for="manual_lng"> <?php _e('Longitude', ATBDP_TEXTDOMAIN); ?> </label>
                                                    <input type="text" name="manual_lng" id="manual_lng"
                                                           value="<?= !empty($manual_lng) ? esc_attr($manual_lng) : ''; ?>"
                                                           class="form-control directory_field"
                                                           placeholder="<?php esc_attr_e('Enter Longitude eg. 91.87198', ATBDP_TEXTDOMAIN); ?>"/>
                                                </div>
                                            </div>

                                            <div class="col-md-3 col-sm-12">
                                                <div class="form-group lat_btn_wrap">
                                                    <button class="btn btn-primary"
                                                            id="generate_admin_map"><?php _e('Generate on Map', ATBDP_TEXTDOMAIN); ?></button>
                                                </div>
                                            </div> <!-- ends #hide_if_no_manual_cor-->
                                        </div> <!--ends .row -->
                                    </div> <!--ends .row-->
                                           <!--Google map will be generated here using js-->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="map_wrapper">
                                                <div id="floating-panel">
                                                    <button class="btn btn-danger"
                                                            id="delete_marker"><?php _e('Delete Marker', ATBDP_TEXTDOMAIN); ?></button>
                                                </div>

                                                <div id="gmap"></div>
                                            </div>
                                        </div> <!--ends .col-md-12-->
                                    </div><!--ends .row-->

                                <?php } ?>
                            </div>
                        </div> <!--./end atbd_location_map_setting-->
                    <?php } ?>

                <div class="directorist-contact-fields atbdp_info_module">
                    <div class="atbdp_info_module">
                        <?php
                        /**
                         * It fires after the google map preview area
                         * @param string $type Page type.
                         * @param array $listing_info Information of the current listing
                         * @since 1.1.1
                         **/
                        do_action('atbdp_edit_after_googlemap_preview', 'add_listing_page_frontend', $listing_info, $p_id);?>
                    </div>
                    <div class="atbd_content_module">
                        <div class="atbd_content_module__tittle_area">
                            <div class="atbd_area_title">
                                <h4><?php esc_html_e('Imges & Video', ATBDP_TEXTDOMAIN) ?></h4>
                            </div>
                        </div>

                        <div class="atbdb_content_module_contents">
                            <!--Image Uploader-->
                            <div id="_listing_gallery">
                                <?php  ATBDP()->load_template('media-upload', array('listing_img'=> $listing_img)); ?>
                            </div>
                        </div>
                    </div>


                    <div style="text-align: center">
                        <input id="listing_t" type="checkbox" name="t_c_check">
                        <?php
                        if (get_directorist_option('listing_terms_condition') == 1){
                            printf('<span style="color: red"> *</span>');
                        }
                        ?>
                        <label for="listing_t"><?php echo __('I Agree with all ',ATBDP_TEXTDOMAIN);?><a style="color: red" href="" id="listing_t_c" "><?php echo __('terms & conditions',ATBDP_TEXTDOMAIN);?></a></label>
                        <div id="tc_container" style="display: none">
                            <p style='padding:25px; border-radius: 10px; border:1px solid brown; font-size:13px; text-align:justify' class='alert-danger'><?php _e($listing_terms_condition_text, ATBDP_TEXTDOMAIN);?></p>
                        </div>
                    </div>
                    <?php
                    /**
                     * It fires before rendering submit listing button on the front end.
                     */
                    do_action('atbdp_before_submit_listing_frontend');
                    ?>
                    <div class="btn_wrap list_submit">
                        <button type="submit" class="btn btn-primary listing_submit_btn"><?= !empty($p_id) ? __( 'Update Listing', ATBDP_TEXTDOMAIN) : __( 'Submit listing', ATBDP_TEXTDOMAIN); ?></button>
                    </div>

                    <div class="clearfix"></div>
            </div> <!--ends col-md-12 -->
        </div><!--ends .row--></div>
        </form>
    </div> <!--ends container-fluid-->
</div>
<script>



    jQuery(document).ready(function ($) {
        <?php if(class_exists('ATBDP_Fee_Manager') ) { ?>
//        $('#fm_plans_container').on('click', function(){
//            $('.atbdp-form-fields').fadeIn(1000);
//            $('#fm_plans_container').fadeOut(300)
//        });
        <?php } ?>
        $(function () {
            $('#color_code2').wpColorPicker();
        });
        //it shows the hidden term and conditions
        $(function () {
            $('#listing_t_c').on('click', function (e) {
                e.preventDefault();
                $('#tc_container').fadeIn(500);
            })
        });

        // Load custom fields of the selected category in the custom post type "atbdp_listings"
        $( '#cat-type' ).on( 'change', function() {
            $( '#atbdp-custom-fields-list' ).html( '<div class="spinner"></div>' );

            var data = {
                'action'  : 'atbdp_custom_fields_listings_front',
                'post_id' : $( '#atbdp-custom-fields-list' ).data('post_id'),
                'term_id' : $(this).val()
            };
            $.post( ajaxurl, data, function(response) {
                $( '#atbdp-custom-fields-list' ).html( response );
            });
            $('#atbdp-custom-fields-list-selected').hide();
        });
        var selected_cat = $('#value_selected').val();
        if(!selected_cat){

        }else{
            $(window).on("load", function () {
                $('#atbdp-custom-fields-list-selected').html('<div class="spinner"></div>');
                var data = {
                    'action': 'atbdp_custom_fields_listings_front_selected',
                    'post_id': $('#atbdp-custom-fields-list-selected').data('post_id'),
                    'term_id': selected_cat
                };
                $.post(ajaxurl, data, function (response) {
                    $('#atbdp-custom-fields-list-selected').html(response);
                });
            });
        }

        // Bias the auto complete object to the user's geographical location,
        // as supplied by the browser's 'navigator.geolocation' object.
        <?php if (!$disable_map) { ?>
        // initialize all vars here to avoid hoisting related misunderstanding.
        var placeSearch, map, autocomplete, address_input, markers, info_window, $manual_lat, $manual_lng,
            saved_lat_lng, info_content;
        $manual_lat = $('#manual_lat');
        $manual_lng = $('#manual_lng');
        saved_lat_lng = {
            lat:<?= (!empty($manual_lat)) ? floatval($manual_lat) : '51.5073509' ?>,
            lng: <?= (!empty($manual_lng)) ? floatval($manual_lng) : '-0.12775829999998223' ?> }; // default is London city
        info_content = "<?= $info_content; ?>";
        markers = [];// initialize the array to keep track all the marker
        info_window = new google.maps.InfoWindow({
            content: info_content,
            maxWidth: 400
        });


        address_input = document.getElementById('address');
        address_input.addEventListener('focus', geolocate);
        // this function will work on sites that uses SSL, it applies to Chrome especially, other browsers may allow location sharing without securing.
        function geolocate() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var geolocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    var circle = new google.maps.Circle({
                        center: geolocation,
                        radius: position.coords.accuracy
                    });
                    autocomplete.setBounds(circle.getBounds());
                });
            }
        }


        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                (address_input),
                {types: ['geocode']});

            // When the user selects an address from the dropdown, populate the necessary input fields and draw a marker
            autocomplete.addListener('place_changed', fillInAddress);
        }

        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();

            // set the value of input field to save them to the database
            $manual_lat.val(place.geometry.location.lat());
            $manual_lng.val(place.geometry.location.lng());
            map.setCenter(place.geometry.location);
            var marker = new google.maps.Marker({
                map: map,
                position: place.geometry.location
            });

            marker.addListener('click', function () {
                info_window.open(map, marker);
            });

            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);
        }

        initAutocomplete(); // start google map place auto complete API call


        function initMap() {
            /* Create new map instance*/
            map = new google.maps.Map(document.getElementById('gmap'), {
                zoom: <?php echo !empty($map_zoom_level) ? intval($map_zoom_level) : 16; ?>,
                center: saved_lat_lng
            });
            var marker = new google.maps.Marker({
                map: map,
                position: saved_lat_lng,
                draggable: true,
                title: '<?php _e('You can drag the marker to your desired place to place a marker', ATBDP_TEXTDOMAIN); ?>'
            });
            marker.addListener('click', function () {
                info_window.open(map, marker);
            });
            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);

            // create a Geocode instance
            var geocoder = new google.maps.Geocoder();

            document.getElementById('generate_admin_map').addEventListener('click', function (e) {
                e.preventDefault();
                geocodeAddress(geocoder, map);
            });


            // This event listener calls addMarker() when the map is clicked.
            google.maps.event.addListener(map, 'click', function (event) {
                deleteMarker(); // at first remove previous marker and then set new marker;
                // set the value of input field to save them to the database
                $manual_lat.val(event.latLng.lat());
                $manual_lng.val(event.latLng.lng());
                // add the marker to the given map.
                addMarker(event.latLng, map);
            });
            // This event listener update the lat long field of the form so that we can add the lat long to the database when the MARKER is drag.
            google.maps.event.addListener(marker, 'dragend', function (event) {
                // set the value of input field to save them to the database
                $manual_lat.val(event.latLng.lat());
                $manual_lng.val(event.latLng.lng());
            });
        }

        /*
         * Geocode and address using google map javascript api and then populate the input fields for storing lat and long
         * */

        function geocodeAddress(geocoder, resultsMap) {
            var address = address_input.value;
            geocoder.geocode({'address': address}, function (results, status) {
                if (status === 'OK') {
                    // set the value of input field to save them to the database
                    $manual_lat.val(results[0].geometry.location.lat());
                    $manual_lng.val(results[0].geometry.location.lng());
                    resultsMap.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: resultsMap,
                        position: results[0].geometry.location
                    });

                    marker.addListener('click', function () {
                        info_window.open(map, marker);
                    });

                    // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
                    markers.push(marker);
                } else {
                    alert('<?php _e('Geocode was not successful for the following reason: ', ATBDP_TEXTDOMAIN); ?>' + status);
                }
            });
        }

        initMap();


        // adding features of creating marker manually on the map on add listing page.
        /*var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
         var labelIndex = 0;*/


        // Adds a marker to the map.
        function addMarker(location, map) {
            // Add the marker at the clicked location, and add the next-available label
            // from the array of alphabetical characters.
            var marker = new google.maps.Marker({
                position: location,
                /*label: labels[labelIndex++ % labels.length],*/
                draggable: true,
                title: '<?php _e('You can drag the marker to your desired place to place a marker', ATBDP_TEXTDOMAIN); ?>',
                map: map
            });
            marker.addListener('click', function () {
                info_window.open(map, marker);
            });
            // add the marker to the markers array to keep track of it, so that we can show/hide/delete them all later.
            markers.push(marker);
        }

        // Delete Marker
        $('#delete_marker').on('click', function (e) {
            e.preventDefault();
            deleteMarker();

        });

        function deleteMarker() {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            markers = [];
        }
        <?php } ?>



    }); // ends jquery ready function.


</script>