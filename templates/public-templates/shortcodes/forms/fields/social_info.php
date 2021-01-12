<?php
/**
 * @author  AazzTech
 * @since   6.7
 * @version 6.7
 */
?>

<div class="form-group directorist-social-info-field">
	<?php $form->add_listing_label_template( $data );?>

	<div id="social_info_sortable_container">
		<input type="hidden" id="is_social_checked">
		<?php
		if ( !empty( $data['value'] ) ) {
			foreach ( $data['value'] as $index => $social_info ) {
				?>

				<div class="atbdp_social_field_wrapper" id="socialID-<?php echo $index; ?>">
					
					<div class="atbdp_social_field_social-name">
						<div class="form-group">
							<select name="<?php echo esc_attr( $data['field_key'] ); ?>[<?php echo esc_attr( $index ); ?>][id]" id="atbdp_social" class="form-control">
								<?php foreach (ATBDP()->helper->social_links() as $nameID => $socialName) { ?>
									<option value="<?php echo esc_attr($nameID); ?>" <?php selected($nameID, $social_info['id']); ?>><?php echo esc_html($socialName); ?></option>
								<?php } ?>
							</select>
						</div>
					</div>

					<div class="atbdp_social_field_social-url">
						<input type="url" name="<?php echo esc_attr( $data['field_key'] ); ?>[<?php echo esc_attr( $index ); ?>][url]" class="form-control directory_field atbdp_social_input" value="<?php echo esc_url($social_info['url']); ?>" placeholder="<?php esc_attr_e('eg. http://example.com', 'directorist'); ?>">
					</div>

					<div class="atbdp_social_field_action">
						<span data-id="<?php echo esc_attr( $index ); ?>" class="removeSocialField dashicons dashicons-trash" title="<?php esc_attr_e('Remove this item', 'directorist'); ?>"></span>
						<span class="adl-move-icon dashicons dashicons-move"></span>
					</div>

				</div>
				<?php
			}
		}
		?>
	</div>

	<button type="button" class="btn btn-primary btn-sm" id="addNewSocial"> <span class="plus-sign">+</span><?php esc_html_e('Add New', 'directorist'); ?></button>

</div>