<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="form-group directorist-excerpt-field">

	<?php $listing_form->field_label_template( $data );?>

	<textarea name="<?php echo esc_attr( $data['field_key'] ); ?>" id="<?php echo esc_attr( $data['field_key'] ); ?>" class="form-control" cols="30" rows="5" placeholder="<?php echo esc_attr( $data['placeholder'] ); ?>"><?php echo esc_textarea( $data['value'] ); ?></textarea>
	<input type="hidden" id="has_excerpt" value="<?php echo esc_attr( $data['value'] ); ?>">

	<?php $listing_form->field_description_template( $data ); ?>
	
</div>