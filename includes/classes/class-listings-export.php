<?php
namespace Directorist;

class Listings_Export {
    
    public function __construct() {
        # code...
    }

    public static function get_listings_data() {
        $listings_data = [];

        $listings = new \WP_Query([
            'post_type'      => ATBDP_POST_TYPE,
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        ]);

        if ( $listings->have_posts() ) {
            while ( $listings->have_posts() ) {
                $listings->the_post();
                
                $row = [];

                $row['name'] = get_the_title();

                // Directory Type
                $directory_type_id   = get_post_meta( get_the_id(), '_directory_type', true );
                $directory_type      = ( ! empty( $directory_type_id ) ) ? get_term_by( 'id', $directory_type_id, ATBDP_DIRECTORY_TYPE ) : '';
                $directory_type_slug = ( ! empty( $directory_type ) && is_object( $directory_type ) ) ? $directory_type->slug : '';
                $row['directory_type']   = $directory_type_slug;

                $row['details']          = get_the_content();
                $row['tagline']          = get_post_meta( get_the_id(), '_tagline', true );
                $row['price']            = get_post_meta( get_the_id(), '_price', true );
                $row['price_range']      = get_post_meta( get_the_id(), '_price_range', true );
                $row['post_views_count'] = get_post_meta( get_the_id(), '_post_views_count', true );
                $row['excerpt']          = get_the_excerpt();


                // Location
                $locations = [];
                $locations_ = get_the_terms( get_the_ID(), ATBDP_LOCATION );

                if ( ! empty( $locations_ ) ) {
                    foreach ( $locations_ as $location ) {
                        array_push( $locations, $location->name );
                    }
                }

                $locations = ( ! empty( $locations ) ) ? join( ',', $locations ) : '';
                $row['location'] = $locations;

                

                array_push( $listings_data, $row );
            }
        }

        return $listings_data;
    }

}