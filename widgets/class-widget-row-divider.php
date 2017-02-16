<?php

/**
 * Easy Widget Columns Row Divider widget.
 *
 * Use this widget to start or close a new row of widget columns.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Row Divider widget
 */
 
class EWC_Row_Divider extends WP_Widget {
	
    /**
     * Constructor
     *
     * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes any necessary stylesheets and JavaScript.
     **/
	public function __construct() {
		
		$widget_ops = array(
			'classname' => 'ewc-row-divider',
			'description' => __( 'Use this widget to start or close a new row of widget columns.', 'easy-widget-columns' ),
			'customize_selective_refresh' => false,
		);
		
		$control_ops = array(
			'id_base' => 'ewc-row-divider',
		);
		
		parent::__construct( 'ewc-row-divider', '&#8212; ' . __( 'Widget Row', 'easy-widget-columns' ) . ' &#8212;', $widget_ops, $control_ops );
		
	}
	
    /**
     * Outputs the HTML for this widget.
     *
     * @param array args The array of form elements
	 * @param array instance The current instance of the widget
     **/
	public function widget( $args, $instance ) {
		
		extract( $args, EXTR_SKIP );
		
		$instance = wp_parse_args( (array)$instance, array(
			'show_options' => 0,
			'background_color' => '',
			'background_image' => '',
			'background_repeat' => '',
			'background_attachment' => '',
			'background_position' => '',
			'background_size' => '',
			'padding_top' => 0,
			'padding_right' => 0,
			'padding_bottom' => 0,
			'padding_left' => 0,
			'margin_top' => 0,
			'margin_right' => 0,
			'margin_bottom' => 0,
			'margin_left' => 0,
			'custom_classes' => '',
		) );
		
		// Background color
    	if ( !empty( $instance['background_color'] ) ) {
    		$background_color = $instance['background_color'];
    	} else {
	    	$background_color = '';
    	}
    	
    	// Background image
    	if ( !empty( $instance['background_image'] ) ) {
    		$background_image = ' ' . "url('" . $instance['background_image'] . "')";
    	} else {
	    	$background_image = '';
    	}
    	
    	// Background repeat
    	if ( !empty( $instance['background_repeat'] ) ) {
    		$background_repeat = ' ' . $instance['background_repeat'];
    	} else {
	    	$background_repeat = '';
    	}
    	
    	// Background attachment
    	if ( !empty( $instance['background_attachment'] ) ) {
    		$background_attachment = ' ' . $instance['background_attachment'];
    	} else {
	    	$background_attachment = '';
    	}
    	
    	// Background position
    	if ( !empty( $instance['background_position'] ) ) {
    		$background_position = ' ' . $instance['background_position'];
    	} else {
	    	$background_position = '';
    	}
    	
    	// Background size
    	if ( !empty( $instance['background_size'] ) && 'none' !== $instance['background_size'] ) {
    		$background_size = 'background-size:' . $instance['background_size'] . ';';
    	} else {
	    	$background_size = '';
    	}
    	
    	// Padding
    	$padding_top = $instance['padding_top'];
    	$padding_right = $instance['padding_right'];
    	$padding_bottom = $instance['padding_bottom'];
    	$padding_left = $instance['padding_left'];
    	$padding = 'padding:' . $padding_top . 'px ' . $padding_right . 'px ' . $padding_bottom . 'px ' . $padding_left . 'px;';
    	if ( 'padding:0px 0px 0px 0px;' == $padding ) {
        	$padding = '';
    	}
    	
    	// Margin
    	$margin_top = $instance['margin_top'];
    	$margin_right = $instance['margin_right'];
    	$margin_bottom = $instance['margin_bottom'];
    	$margin_left = $instance['margin_left'];
    	$margin = 'margin:' . $margin_top . 'px ' . $margin_right . 'px ' . $margin_bottom . 'px ' . $margin_left . 'px;';
    	if ( 'margin:0px 0px 0px 0px;' == $margin ) {
        	$margin = '';
    	}
    	
    	// Inline styles
    	if ( ( !empty($background_color) || !empty($background_image) || !empty($padding) || !empty($margin) ) ) {
	    	if ( !empty($background_color) && !empty($background_image) ) {
		    	$background = 'background:'.$background_color.$background_image.$background_repeat.$background_attachment.$background_position.';';
		    } elseif ( empty($background_color) && !empty($background_image) ) {
			    $background = 'background:'.$background_image.$background_repeat.$background_attachment.$background_position.';';
		    } elseif ( !empty($background_color) && empty($background_image) ) {
			    $background = 'background:'.$background_color.';';
		    } else {
			    $background = '';
		    }
		    $style = ' style="'.$background.$background_size.$padding.$margin.'"';
    	} else {
	    	$style = '';
    	}
    	
    	// Custom Classes
    	if ( !empty( $instance['custom_classes'] ) ) {
    		$custom_classes = ' ' . $instance['custom_classes'];
    	} else {
	    	$custom_classes = '';
    	}
    	
    	global $wp_registered_widgets;
    	
    	// Get the widget's instance number
		$widget_instance = preg_replace( '/[^0-9]/', '', $this->id );
	    $widget_row_id = 'id="widget-row-'.$widget_instance.'" ';
    	
    	// Get the widget's position in the sidebar
    	$sidebars_widgets = get_option( 'sidebars_widgets', array() );
    	$sidebar_id = $sidebars_widgets[$args['id']]; // current sidebar ID
		$position_id = array_search( $this->id, $sidebar_id );
		
    	// Assign the closing widget row markup
		if ( isset( $sidebar_id[$position_id-1] ) && !in_array( _get_widget_id_base( $sidebar_id[$position_id-1] ), array('ewc-row-divider') ) ) {
			
			// Get widget above options
	    	$widget_above_option = get_option( $wp_registered_widgets[$sidebar_id[$position_id-1]]['callback'][0]->option_name );
	    	$widget_above_index = preg_replace( '/[^0-9]/', '', $sidebar_id[$position_id-1] );
	    	$ewc_width_above = $widget_above_option[$widget_above_index]['ewc_width'];
	    	
	    	if ( !empty( $ewc_width_above ) && 'none' !== $ewc_width_above ) {
			
				echo '</div></div>';
			
			}
			
		}
    	
		// Assign the opening widget row markup
		if ( isset( $sidebar_id[$position_id+1] ) && !in_array( _get_widget_id_base( $sidebar_id[$position_id+1] ), array('ewc-row-divider') ) ) {
			
			// Get widget below options
	    	$widget_below_option = get_option( $wp_registered_widgets[$sidebar_id[$position_id+1]]['callback'][0]->option_name );
	    	$widget_below_index = preg_replace( '/[^0-9]/', '', $sidebar_id[$position_id+1] );
	    	$ewc_width_below = $widget_below_option[$widget_below_index]['ewc_width'];
	    	
	    	if ( !empty( $ewc_width_below ) && 'none' !== $ewc_width_below ) {
			
				if ( apply_filters( 'ewc_advanced_options', true ) && 1 == $instance['show_options'] ) {
					echo '<div '.$widget_row_id.' class="widget-row'.$custom_classes.'"'.$style.'><div class="wrap">';
				} else {
					echo '<div '.$widget_row_id.' class="widget-row"><div class="wrap">';
				}
				
			}
			
		}
		
	}

    /**
     * Processes the widget's options to be saved.
	 *
	 * @param array new_instance The new instance of values to be generated via the update.
	 * @param array old_instance The previous instance of values before the update.
     **/
	public function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;
		$instance['show_options'] = strip_tags( $new_instance['show_options'] );
		$instance['background_color'] = strip_tags( sanitize_hex_color( $new_instance['background_color'] ) );
		$instance['background_image'] = esc_url( $new_instance['background_image'] );
		$instance['background_repeat'] = strip_tags( $new_instance['background_repeat'] );
		$instance['background_attachment'] = strip_tags( $new_instance['background_attachment'] );
		$instance['background_position'] = strip_tags( $new_instance['background_position'] );
		$instance['background_size'] = strip_tags( $new_instance['background_size'] );
		$instance['padding_top'] = absint( $new_instance['padding_top'] );
		$instance['padding_right'] = absint( $new_instance['padding_right'] );
		$instance['padding_bottom'] = absint( $new_instance['padding_bottom'] );
		$instance['padding_left'] = absint( $new_instance['padding_left'] );
		$instance['margin_top'] = absint( $new_instance['margin_top'] );
		$instance['margin_right'] = absint( $new_instance['margin_right'] );
		$instance['margin_bottom'] = absint( $new_instance['margin_bottom'] );
		$instance['margin_left'] = absint( $new_instance['margin_left'] );
		$instance['custom_classes'] = strip_tags( $new_instance['custom_classes'] );
		
		return $instance;
		
	}

    /**
     * Generates the administration form for the widget.
	 *
	 * @param array instance The array of keys and values for the widget.
     **/
	public function form( $instance ) {
		
		$defaults = array(
			'show_options' => 0,
			'background_color' => '',
			'background_image' => '',
			'background_repeat' => 'repeat',
			'background_attachment' => 'scroll',
			'background_position' => 'left top',
			'background_size' => 'auto',
			'padding_top' => 0,
			'padding_right' => 0,
			'padding_bottom' => 0,
			'padding_left' => 0,
			'margin_top' => 0,
			'margin_right' => 0,
			'margin_bottom' => 0,
			'margin_left' => 0,
			'custom_classes' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
		
		<p><?php _e('Use this widget to start or close a new row of widget columns.', 'easy-widget-columns'); ?></p> <?php
		
		if ( apply_filters( 'ewc_advanced_options', true ) ) { ?>
		
			<input class="ewc-options-checkbox" id="<?php echo $this->get_field_id( 'show_options' ); ?>" type="checkbox" name="<?php echo $this->get_field_name('show_options'); ?>" value="1" <?php checked( 1, $instance['show_options'] ); ?>/>
			<label class="ewc-options-label" for="<?php echo $this->get_field_id( 'show_options' ); ?>"><?php _e( 'Advanced options', 'easy-widget-columns' ); ?></label>
			
			<div class="ewc-row-styles">
				
				<p>
					<label class="ewc-section-label" for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Row background', 'easy-widget-columns' ); ?></label><br>
					<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Color:', 'easy-widget-columns' ); ?></label><br />
					<input class="color-picker" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" type="text" value="<?php echo $instance['background_color']; ?>" data-default-color=""/>
				</p>
				
				<p>
			        <label for="<?php echo $this->get_field_id( 'background_image' ); ?>"><?php _e( 'Image:', 'easy-widget-columns' ); ?></label>
			        <input type="text" class="widefat custom-media-url" name="<?php echo $this->get_field_name( 'background_image' ); ?>" id="<?php echo $this->get_field_id('background_image'); ?>" value="<?php echo $instance['background_image']; ?>" placeholder="<?php _e( 'Enter URL or select image', 'easy-widget-columns' ); ?>">
			        <input type="button" class="button custom-media-button" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="Select Image" style="margin-top:5px;" />
			    </p>
			    
			    <span class="ewc-image-properties">
				    
				    <p class="first image-properties-dropdown">
						<label for="<?php echo $this->get_field_id( 'background_repeat' ); ?>"><?php _e( 'Repeat:' ); ?></label><br />
						<select id="<?php echo $this->get_field_id( 'background_repeat' ); ?>" name="<?php echo $this->get_field_name( 'background_repeat' ); ?>"> <?php
							$repeat_options = array(
								__( 'Tile', 'easy-widget-columns' ) => 'repeat',
								__( 'Horizontal', 'easy-widget-columns' ) => 'repeat-x',
								__( 'Vertical', 'easy-widget-columns' ) => 'repeat-y',
								__( 'No Repeat', 'easy-widget-columns' ) => 'no-repeat',
							);
							foreach ( $repeat_options as $key => $value ) {
								echo '<option value="' . $value . '" id="' . $value . '"', $instance['background_repeat'] == $value ? ' selected="selected"' : '', '>', $key, '</option>';
							} ?>
						</select>
					</p>
					
					<p class="image-properties-dropdown">
						<label for="<?php echo $this->get_field_id( 'background_attachment' ); ?>"><?php _e( 'Attachment:' ); ?></label><br />
						<select id="<?php echo $this->get_field_id( 'background_attachment' ); ?>" name="<?php echo $this->get_field_name( 'background_attachment' ); ?>"> <?php
							$attachment_options = array(
								__( 'Scroll', 'easy-widget-columns' ) => 'scroll',
								__( 'Fixed', 'easy-widget-columns' ) => 'fixed',
							);
							foreach ( $attachment_options as $key => $value ) {
								echo '<option value="' . $value . '" id="' . $value . '"', $instance['background_attachment'] == $value ? ' selected="selected"' : '', '>', $key, '</option>';
							} ?>
						</select>
					</p>
					
					<p class="first image-properties-dropdown">
						<label for="<?php echo $this->get_field_id( 'background_position' ); ?>"><?php _e( 'Position:' ); ?></label><br />
						<select id="<?php echo $this->get_field_id( 'background_position' ); ?>" name="<?php echo $this->get_field_name( 'background_position' ); ?>"> <?php
							$position_options = array(
								__( 'Left Top', 'easy-widget-columns' ) => 'left top',
								__( 'Left Center', 'easy-widget-columns' ) => 'left center',
								__( 'Left Bottom', 'easy-widget-columns' ) => 'left bottom',
								__( 'Right Top', 'easy-widget-columns' ) => 'right top',
								__( 'Right Center', 'easy-widget-columns' ) => 'right center',
								__( 'Right Bottom', 'easy-widget-columns' ) => 'right bottom',
								__( 'Center Top', 'easy-widget-columns' ) => 'center top',
								__( 'Center', 'easy-widget-columns' ) => 'center center',
								__( 'Center Bottom', 'easy-widget-columns' ) => 'center bottom',
							);
							foreach ( $position_options as $key => $value ) {
								echo '<option value="' . $value . '" id="' . $value . '"', $instance['background_position'] == $value ? ' selected="selected"' : '', '>', $key, '</option>';
							} ?>
						</select>
					</p>
					
					<p class="image-properties-dropdown">
						<label for="<?php echo $this->get_field_id( 'background_size' ); ?>"><?php _e( 'Scale:' ); ?></label><br />
						<select id="<?php echo $this->get_field_id( 'background_size' ); ?>" name="<?php echo $this->get_field_name( 'background_size' ); ?>"> <?php
							$size_options = array(
								__( 'None', 'easy-widget-columns' ) => 'none',
								__( 'Cover', 'easy-widget-columns' ) => 'cover',
								__( 'Contain', 'easy-widget-columns' ) => 'contain',
							);
							foreach ( $size_options as $key => $value ) {
								echo '<option value="' . $value . '" id="' . $value . '"', $instance['background_size'] == $value ? ' selected="selected"' : '', '>', $key, '</option>';
							} ?>
						</select>
					</p>
					
			    </span>
			    
			    <hr>
				
				<label class="ewc-section-label" style="margin-top:7px;"><?php _e('Row margin', 'easy-widget-columns'); ?></label>
				
				<table class="ewc-widget-table">
					<tr>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'margin_top' ); ?>"><?php _e( 'top:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'margin_top' ); ?>" name="<?php echo $this->get_field_name( 'margin_top' ); ?>" value="<?php echo $instance['margin_top']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'margin_top' ); ?>">px</label>
						</td>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'margin_right' ); ?>"><?php _e( 'right:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'margin_right' ); ?>" name="<?php echo $this->get_field_name( 'margin_right' ); ?>" value="<?php echo $instance['margin_right']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'margin_right' ); ?>">px</label>
						</td>
					</tr>
					<tr>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'margin_bottom' ); ?>"><?php _e( 'btm:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'margin_bottom' ); ?>" name="<?php echo $this->get_field_name( 'margin_bottom' ); ?>" value="<?php echo $instance['margin_bottom']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'margin_bottom' ); ?>">px</label>
						</td>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'margin_left' ); ?>"><?php _e( 'left:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'margin_left' ); ?>" name="<?php echo $this->get_field_name( 'margin_left' ); ?>" value="<?php echo $instance['margin_left']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'margin_left' ); ?>">px</label>
						</td>
					</tr>
				</table>
				
				<hr><label class="ewc-section-label" style="margin-top:7px;"><?php _e( 'Row padding', 'easy-widget-columns' ); ?></label>
				
				<table class="ewc-widget-table">
					<tr>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'padding_top' ); ?>"><?php _e( 'top:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'padding_top' ); ?>" name="<?php echo $this->get_field_name( 'padding_top' ); ?>" value="<?php echo $instance['padding_top']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'padding_top' ); ?>">px</label>
						</td>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'padding_right' ); ?>"><?php _e( 'right:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'padding_right' ); ?>" name="<?php echo $this->get_field_name( 'padding_right' ); ?>" value="<?php echo $instance['padding_right']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'padding_right' ); ?>">px</label>
						</td>
					</tr>
					<tr>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'padding_bottom' ); ?>"><?php _e( 'btm:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'padding_bottom' ); ?>" name="<?php echo $this->get_field_name( 'padding_bottom' ); ?>" value="<?php echo $instance['padding_bottom']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'padding_bottom' ); ?>">px</label>
						</td>
						<td class="row-content">
							<label class="row-label" for="<?php echo $this->get_field_id( 'padding_left' ); ?>"><?php _e( 'left:', 'easy-widget-columns' ); ?></label>
							<input type="number" step="1" min="0" id="<?php echo $this->get_field_id( 'padding_left' ); ?>" name="<?php echo $this->get_field_name( 'padding_left' ); ?>" value="<?php echo $instance['padding_left']; ?>" style="width:50px;" />
							<label for="<?php echo $this->get_field_id( 'padding_left' ); ?>">px</label>
						</td>
					</tr>
				</table>
				
				<hr>
				
				<p>
					<label class="ewc-section-label" for="<?php echo $this->get_field_id( 'custom_classes' ); ?>"><?php _e( 'Custom classes', 'easy-widget-columns' ); ?></label>
					<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'custom_classes' ); ?>" name="<?php echo $this->get_field_name( 'custom_classes' ); ?>" value="<?php echo $instance['custom_classes']; ?>" />
					<span class="description" style="padding-left:2px;"><em><?php _e( 'Separate classes by a space.', 'easy-widget-columns' ) ?></em></span>
				</p>
								
			</div> <?php
			
		}
		
	}
	
}
