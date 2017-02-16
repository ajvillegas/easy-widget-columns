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
	<label for="<?php echo $widget->get_field_id('ewc_width'); ?>"><?php _e('Column width:', 'easy-widget-columns'); ?></label><br>
	<select name="<?php echo $widget->get_field_name('ewc_width'); ?>" class="ewc-select" style="width: 100%">
		<option value="none" data-icon="none" <?php selected( $instance['ewc_width'], 'none' ) ?>><?php _e('None', 'easy-widget-columns'); ?></option>
		<option value="full-width" data-icon="full-width" <?php selected( $instance['ewc_width'], 'full-width' ) ?>><?php _e('1/1', 'easy-widget-columns'); ?></option>
		<option value="one-half" data-icon="one-half" <?php selected( $instance['ewc_width'], 'one-half' ) ?>><?php _e('1/2', 'easy-widget-columns'); ?></option>
		<option value="one-third" data-icon="one-third" <?php selected( $instance['ewc_width'], 'one-third' ) ?>><?php _e('1/3', 'easy-widget-columns'); ?></option>
		<option value="two-thirds" data-icon="two-thirds" <?php selected( $instance['ewc_width'], 'two-thirds' ) ?>><?php _e('2/3', 'easy-widget-columns'); ?></option>
		<option value="one-fourth" data-icon="one-fourth" <?php selected( $instance['ewc_width'], 'one-fourth' ) ?>><?php _e('1/4', 'easy-widget-columns'); ?></option>
		<option value="three-fourths" data-icon="three-fourths" <?php selected( $instance['ewc_width'], 'three-fourths' ) ?>><?php _e('3/4', 'easy-widget-columns'); ?></option>
		<option value="one-sixth" data-icon="one-sixth" <?php selected( $instance['ewc_width'], 'one-sixth' ) ?>><?php _e('1/6', 'easy-widget-columns'); ?></option>
		<option value="five-sixths" data-icon="five-sixths" <?php selected( $instance['ewc_width'], 'five-sixths' ) ?>><?php _e('5/6', 'easy-widget-columns'); ?></option>
	</select>
</p>
