<?php
/**
 * @author  AazzTech
 * @since   6.7
 * @version 6.7
 */

$p_id                = $form->get_add_listing_id();
$fm_plan             = get_post_meta( $p_id, '_fm_plans', true );
$type                = $form->get_current_listing_type();

$plan_image          = $data['max_image_limit'];
$max_file_size       = $data['max_per_image_limit'];
$max_total_file_size = $data['max_total_image_limit'];

$slider_unl = '';
if ( !empty( $field_data['plans'] ) ) {
    $plan = atbdp_field_assigned_plan( $field_data );
    $slider_unl = ( $plan['max'] == 0 ) ? true : false;
    if (!$slider_unl) {
        $plan_image = $plan['max'];
    }
}

$listing_img            = atbdp_get_listing_attachment_ids( $p_id );
$slider_unl             = $slider_unl;
$max_file_items         = ! empty( $slider_unl ) ? '999' : $plan_image;
$min_file_items         = $data['required'] ? '1' : '';
$max_file_size_kb       = (float) $max_file_size * 1024;//
$max_total_file_size_kb = (float) $max_total_file_size * 1024;//
?>

<div class="form-group directorist-image-upload-field">
	<!-- <div id="_listing_gallery" class="ez-media-uploader" data-type="jpg, jpeg, png, gif" data-max-file-items="<?php echo esc_attr( $max_file_items ); ?>" data-min-file-items="<?php echo esc_attr( $min_file_items ); ?>" data-max-file-size="<?php echo esc_attr( $max_file_size_kb ); ?>" data-max-total-file-size="<?php echo esc_attr( $max_total_file_size_kb ); ?>" data-show-alerts="0">

		<div class="ezmu__loading-section ezmu--show">
			<span class="ezmu__loading-icon"><span class="ezmu__loading-icon-img-bg"></span></span>
		</div>

		<div class="ezmu__old-files">
			<?php
			if (!empty($listing_img)) {
				foreach ($listing_img as $image) {
					$url = wp_get_attachment_image_url($image, 'full');
					$size = filesize(get_attached_file($image));
					?>
					<span class="ezmu__old-files-meta" data-attachment-id="<?php echo esc_attr($image); ?>" data-url="<?php echo esc_url($url); ?>" data-size="<?php echo esc_attr($size / 1024); ?>" data-type="image"></span>
					<?php
				}
			}
			?>
		</div>

		<div class="ezmu-dictionary">
			<span class="ezmu-dictionary-label-drop-here"><?php esc_html_e('Drop Here', 'directorist') ?></span>
			<span class="ezmu-dictionary-label-featured"><?php esc_html_e('Preview', 'directorist') ?></span>
			<span class="ezmu-dictionary-label-drag-n-drop"><?php esc_html_e('Drag & Drop', 'directorist') ?></span>
			<span class="ezmu-dictionary-label-or"><?php esc_html_e('or', 'directorist') ?></span>
			<span class="ezmu-dictionary-label-select-files"><?php echo esc_html( $data['select_files_label'] ); ?></span>
			<span class="ezmu-dictionary-label-add-more"><?php esc_html_e('Add More', 'directorist') ?></span>

			<span class="ezmu-dictionary-alert-max-file-size"><?php esc_html_e('Maximum limit for a file is  __DT__', 'directorist') ?></span>
			<span class="ezmu-dictionary-alert-max-total-file-size"><?php esc_html_e('Maximum limit for total file size is __DT__', 'directorist') ?></span>
			<span class="ezmu-dictionary-alert-min-file-items"><?php esc_html_e('Minimum __DT__ file is required', 'directorist') ?></span>
			<span class="ezmu-dictionary-alert-max-file-items"><?php esc_html_e('Maximum limit for total file is __DT__', 'directorist') ?></span>

			<span class="ezmu-dictionary-info-max-file-size"><?php esc_html_e('Maximum allowed size per file is __DT__', 'directorist') ?></span>
			<span class="ezmu-dictionary-info-max-total-file-size"><?php esc_html_e('Maximum total allowed file size is __DT__', 'directorist') ?></span>

			<span class="ezmu-dictionary-info-type" data-show='0'></span>

			<span class="ezmu-dictionary-info-min-file-items"><?php esc_html_e('Minimum __DT__ file is required', 'directorist') ?></span>

			<span class="ezmu-dictionary-info-max-file-items" 
			data-featured="<?php echo !empty($slider_unl) ? '1' : ''; ?>">
			<?php echo !empty($slider_unl) ? __('Unlimited images with this plan!', 'directorist') : ( ( $plan_image > 1 ) ? __('Maximum __DT__ files are allowed', 'directorist') : __('Maximum __DT__ file is allowed', 'directorist') ); ?></span>
		</div>
	</div> -->

	<div class="directorist_listings-img-gallery">
		<div class="directorist_gallery-upload">
			<input type="file" name="directorist_img-input" id="directorist_img-input">
			<a href="javascript:void(0)" class="directorist_gallery-upload__btn">
				<span class="directorist_upload-icon"></span>
				<h2 class="directorist_upload-title">Drag and drop an image</h2>
				<p>or <span class="color-pink">Browse</span> to choose a file</p>
				<div class="directorist-upload__bottom">
					<span>Unlimited images with this plan</span>
				</div>
			</a>
		</div>
		<div class="directorist_gallery-preview">
			<div class="directorist_gallery-preview__single">
				<img src="https://picsum.photos/seed/picsum/80/60" alt="">
				<a href="#" class="directorist_delete-btn">
					<span class="directorist_trash"></span>
				</a>
			</div>
		</div>
	</div>
</div>