<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="atbd_saved_items_wrapper">

    <table class="table table-bordered atbd_single_saved_item table-responsive-sm">

        <?php if ( $dashboard->fav_listing_items() ): ?>

            <thead>
                <tr>
                    <th><?php esc_html_e( 'Listing Name', 'directorist' ); ?></th>
                    <th><?php esc_html_e( 'Category', 'directorist' ); ?></th>
                    <th><?php esc_html_e( 'Unfavourite', 'directorist' ); ?></th>
                </tr>
            </thead>

            <tbody>

                <?php foreach ($dashboard->fav_listing_items() as $item): ?>

                    <tr>

                        <td class="thumb_title">
                            <div class="img_wrapper">
                                <a href="<?php echo esc_url( $item['permalink'] );?>"><img src="<?php echo esc_url( $item['img_src'] );?>" alt="<?php echo esc_attr( $item['title'] );?>"></a>
                                <h4><a href="<?php echo esc_url( $item['permalink'] );?>"><?php echo esc_html( $item['title'] );?></a></h4>
                            </div>
                        </td>

                        <td class="saved_item_category">
                            <a href="<?php echo esc_url( $item['category_link'] );?>"><span class="<?php echo esc_attr( $item['icon'] );?>"></span><?php echo esc_html( $item['category_name'] );?></a>
                        </td>

                        <td class="remove_saved_item"><?php echo $item['mark_fav_html'];?></td>

                    </tr> 
                    
                <?php endforeach; ?>

            </tbody>

        <?php else: ?>

            <tr><td><div class="directorist_not-found"><?php esc_html_e( 'Nothing found!', 'directorist' ); ?></div></td></tr>

        <?php endif; ?>

    </table>

</div>