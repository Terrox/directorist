<?php
/**
 * @author  AazzTech
 * @since   6.6
 * @version 6.6
 */
?>
<div id="directorist" class="directorist atbd_wrapper dashboard_area">

    <?php
    /**
     * @hooked Directorist_Listing_Dashboard > alert_message_template - 10
     */
    do_action( 'directorist_dashboard_before_container' );
    ?>

    <div class="<?php echo esc_attr( $container_fluid ); ?>">
        <?php
        /**
         * @since 6.6
         * @hooked Directorist_Listing_Dashboard > section_title - 10
         */
        do_action( 'directorist_dashboard_title_area', $display_title );
        ?>
        <div class="atbd-dashboard-nav-toggle-icon">
            <a href="" class="atbd-dashboard-nav-toggler"><i class="la la-bars"></i></a>
        </div>
        <div class="atbd_dashboard_wrapper atbd_tab">
            <div class="atbd_user_dashboard_nav atbd_tab_nav">

                <?php
                /**
                 * @since 6.6
                 * @hooked Directorist_Listing_Dashboard > nav_tabs_template - 10
                 * @hooked Directorist_Listing_Dashboard > nav_buttons_template - 15
                 */
                do_action( 'directorist_dashboard_navigation');
                ?>

            </div>

            <div class="atbd_tab-content">

                <?php
                /**
                 * @since 6.6
                 * @hooked Directorist_Listing_Dashboard > tab_contents_html - 10
                 */
                do_action( 'directorist_dashboard_tab_contents');
                ?>
                <div class="atbd_tab_inner" id="tab1">
                    <p>Empty Content</p>
                </div>
                <div class="atbd_tab_inner" id="tab2">
                    <p>Empty Content</p>
                </div>
                <div class="atbd_tab_inner" id="tab3">
                    <p>Empty Content</p>
                </div>
            </div>
        </div>
    </div>
</div>



<?php
/**
 * @package Directorist
 * @since 5.9.3
 */
do_action('directorist_after_user_dashboard');