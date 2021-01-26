<?php
namespace Directorist;

class Script_Helper {
    /**
     * Get Main Script Data
     *
     * @return array
     */
    public static function get_main_script_data() {
        $data = [ 'test_data' => 'This is a test data 123' ];
        return $data;
    }



    /**
     * Get Admin Script Data
     *
     * @return array
     */
    public static function get_admin_script_data() {
        $font_type = get_directorist_option( 'font_type', 'line' );
        $icon_type = ( 'line' == $font_type ) ? 'la' : 'fa';

        $i18n_text = array(
            'confirmation_text'       => __( 'Are you sure', 'directorist' ),
            'ask_conf_sl_lnk_del_txt' => __( 'Do you really want to remove this Social Link!', 'directorist' ),
            'confirm_delete'          => __( 'Yes, Delete it!', 'directorist' ),
            'deleted'                 => __( 'Deleted!', 'directorist' ),
            'icon_choose_text'        => __( 'Select an icon', 'directorist' ),
            'upload_image'            => __( 'Select or Upload Slider Image', 'directorist' ),
            'upload_cat_image'        => __( 'Select Category Image', 'directorist' ),
            'choose_image'            => __( 'Use this Image', 'directorist' ),
            'select_prv_img'          => __( 'Select Preview Image', 'directorist' ),
            'insert_prv_img'          => __( 'Insert Preview Image', 'directorist' ),
        );
        // is MI extension enabled and active?
        $data = array(
            'nonce'                => wp_create_nonce( 'atbdp_nonce_action_js' ),
            'ajaxurl'              => admin_url( 'admin-ajax.php' ),
            'import_page_link'     => admin_url( 'edit.php?post_type=at_biz_dir&page=tools' ),
            'nonceName'            => 'atbdp_nonce_js',
            'countryRestriction'   => get_directorist_option( 'country_restriction' ),
            'restricted_countries' => get_directorist_option( 'restricted_countries' ),
            'AdminAssetPath'       => ATBDP_ADMIN_ASSETS,
            'i18n_text'            => $i18n_text,
            'icon_type'            => $icon_type
        );

        return $data;
    }


    /**
     * Get Admin Script Dependency
     *
     * @return array
     */
    public static function get_admin_script_dependency() {
        $admin_scripts_dependency = [
            'jquery',
            'wp-color-picker',
            'sweetalert',
            'select2script',
            'bs-tooltip',
        ];

        $disable_map = get_directorist_option( 'display_map_field' );
        if ( ! empty( $disable_map ) ) {
            $admin_scripts_dependency[] = 'atbdp-google-map-front';
        }

        return $admin_scripts_dependency;
    }
}   
    