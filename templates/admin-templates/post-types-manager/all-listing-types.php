<div class="wrap">
    <h1 class="wp-heading-inline"><?php _e( 'Directory Types', 'directorist' ) ?></h1>
    <a href="<?php echo esc_attr( $data['add_new_link'] ); ?>" class="page-title-action"><?php _e( 'Add new directory', 'directorist' ) ?></a>
    <a href="#" data-target="cptm-import-directory-modal" class="page-title-action cptm-modal-toggle"><?php _e( 'Import', 'directorist' ) ?></a>
    <?php atbdp_show_flush_alerts( ['page' => 'all-listing-type'] ) ?>

    <hr class="wp-header-end">

    <form method="GET"> 
        <?php $data['post_types_list_table']->display() ?>
    </form>

    <div class="cptm-modal-container cptm-import-directory-modal">
        <div class="cptm-modal-wrap">
            <div class="cptm-modal">
                <div class="cptm-modal-content">
                    <div class="cptm-modal-header">
                        <h3 class="cptm-modal-header-title"><?php _e( 'Import', 'directorist' ); ?></h3>
                        <div class="cptm-modal-actions">
                            <a href="#" class="cptm-modal-action-link cptm-modal-toggle" data-target="cptm-import-directory-modal">
                                <span class="fa fa-times"></span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="cptm-modal-body cptm-center-content cptm-content-wide">
                        <form action="#" method="post" class="cptm-import-directory-form">
                            <div class="cptm-form-group cptm-mb-10">
                                <input type="text" name="directory-name" class="cptm-form-control cptm-text-center cptm-form-field" placeholder="Directory Name">
                            </div>

                            <div class="cptm-form-group-feedback cptm-text-center cptm-mb-10"></div>

                            <div class="cptm-file-input-wrap">
                                <label for="directory-import-file" class="cptm-btn cptm-btn-secondery"><?php _e( 'Select File', 'directorist' ); ?></label>
                                <button type="submit" class="cptm-btn cptm-btn-primary">
                                    <span class="cptm-loading-icon cptm-d-none">
                                        <span class="fa fa-spin fa fa-spinner"></span>
                                    </span>
                                    <?php _e( 'Import', 'directorist' ); ?>
                                </button>
                                <input id="directory-import-file" name="directory-import-file" type="file" accept=".json" class="cptm-d-none cptm-form-field cptm-file-field">
                            </div>
                        </form>
                    </div>
                </div>

                <div class="cptm-section-alert-area cptm-import-directory-modal-alert cptm-d-none">
                    <div class="cptm-section-alert-content">
                        <div class="cptm-section-alert-icon cptm-alert-success">
                            <span class="fa fa-check"></span>
                        </div>

                        <div class="cptm-section-alert-message">
                            <?php _e( 'The directory has been imported successfuly, redirecting...', 'directorist' ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>