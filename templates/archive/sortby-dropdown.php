<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

if ( ! defined( 'ABSPATH' ) ) exit;
?>

<div class="directorist-dropdown directorist-sortby-dropdown">

	<a class="directorist-dropdown__toggle directorist-btn directorist-btn-sm directorist-btn-px-15 directorist-btn-outline-primary directorist-toggle-hasIcon" href="#"><?php echo esc_html( $listings->sort_by_text ); ?><span class="directorist-icon-caret"></span></a>

	<div class="directorist-dropdown__links directorist-dropdown__links--right">

		<form method="post" action="">
			<?php
			$current_order = !empty($_GET['sort']) ? $_GET['sort'] : '';
			foreach ($listings->get_sort_by_link_list() as $key => $value) {
				$active_class = ( $value['key'] == $current_order ) ? ' active' : '';
				?>
				<a class="directorist-dropdown__links--single <?php echo esc_attr( $active_class );?>" data="<?php echo $value['link']; ?>"><?php echo esc_html($value['label']);?></a>
				<?php
			}
			?>
		</form>

	</div>

</div>