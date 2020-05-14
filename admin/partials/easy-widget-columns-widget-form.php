<?php
/**
 * This file defines the markup for the custom widget select form.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin/partials
 */

?>
<p style="clear:both;">
	<label for="<?php echo esc_attr( $widget->get_field_id( 'ewc_width' ) ); ?>"><?php echo esc_html__( 'Column width:', 'easy-widget-columns' ); ?></label><br>

	<select name="<?php echo esc_attr( $widget->get_field_name( 'ewc_width' ) ); ?>" class="ewc-select" style="width: 100%">
		<option value="none" data-icon="none" <?php selected( $instance['ewc_width'], 'none' ); ?>><?php echo esc_html__( 'None', 'easy-widget-columns' ); ?></option>
		<option value="full-width" data-icon="full-width" <?php selected( $instance['ewc_width'], 'full-width' ); ?>><?php echo esc_html__( '1/1', 'easy-widget-columns' ); ?></option>
		<option value="one-half" data-icon="one-half" <?php selected( $instance['ewc_width'], 'one-half' ); ?>><?php echo esc_html__( '1/2', 'easy-widget-columns' ); ?></option>
		<option value="one-third" data-icon="one-third" <?php selected( $instance['ewc_width'], 'one-third' ); ?>><?php echo esc_html__( '1/3', 'easy-widget-columns' ); ?></option>
		<option value="two-thirds" data-icon="two-thirds" <?php selected( $instance['ewc_width'], 'two-thirds' ); ?>><?php echo esc_html__( '2/3', 'easy-widget-columns' ); ?></option>
		<option value="one-fourth" data-icon="one-fourth" <?php selected( $instance['ewc_width'], 'one-fourth' ); ?>><?php echo esc_html__( '1/4', 'easy-widget-columns' ); ?></option>
		<option value="three-fourths" data-icon="three-fourths" <?php selected( $instance['ewc_width'], 'three-fourths' ); ?>><?php echo esc_html__( '3/4', 'easy-widget-columns' ); ?></option>
		<option value="one-sixth" data-icon="one-sixth" <?php selected( $instance['ewc_width'], 'one-sixth' ); ?>><?php echo esc_html__( '1/6', 'easy-widget-columns' ); ?></option>
		<option value="five-sixths" data-icon="five-sixths" <?php selected( $instance['ewc_width'], 'five-sixths' ); ?>><?php echo esc_html__( '5/6', 'easy-widget-columns' ); ?></option>
	</select>
</p>
