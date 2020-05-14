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
 * @subpackage Easy_Widget_Columns/widgets
 */

/**
 * This class is responsible for building the Row Divider widget.
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/widgets
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
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
			'classname'                   => 'ewc-row-divider',
			'description'                 => esc_html__( 'Use this widget to start or close a new row of widget columns.', 'easy-widget-columns' ),
			'customize_selective_refresh' => false,
		);

		$control_ops = array(
			'id_base' => 'ewc-row-divider',
		);

		// Define options filter and default values.
		$display = apply_filters(
			'ewc_advanced_options',
			array(
				'ewc_background' => array(
					'display' => true,
					'active'  => 1,
				),
				'ewc_margin'     => array(
					'display' => true,
					'active'  => 0,
				),
				'ewc_padding'    => array(
					'display' => true,
					'active'  => 0,
				),
				'ewc_class'      => array(
					'display' => true,
					'active'  => 0,
				),
			)
		);

		$this->display = $display;

		parent::__construct( 'ewc-row-divider', '&#8212; ' . esc_html__( 'Widget Row', 'easy-widget-columns' ) . ' &#8212;', $widget_ops, $control_ops );
	}

	/**
	 * Outputs the HTML for this widget.
	 *
	 * @param array $args The array of form elements.
	 * @param array $instance The current instance of the widget.
	 **/
	public function widget( $args, $instance ) {
		$instance = wp_parse_args(
			(array) $instance,
			array(
				'show_options'          => 0,
				'background_color'      => '',
				'background_image'      => '',
				'background_repeat'     => '',
				'background_attachment' => '',
				'background_position'   => '',
				'background_size'       => '',
				'padding_top'           => 0,
				'padding_right'         => 0,
				'padding_bottom'        => 0,
				'padding_left'          => 0,
				'margin_top'            => 0,
				'margin_right'          => 0,
				'margin_bottom'         => 0,
				'margin_left'           => 0,
				'custom_classes'        => '',
			)
		);

		// Background color.
		if ( ! empty( $instance['background_color'] )
			&& ( ! empty( $this->display['ewc_background']['display'] )
				&& true === $this->display['ewc_background']['display']
			) ) {
			$background_color = $instance['background_color'];
		} else {
			$background_color = '';
		}

		// Background image.
		if ( ! empty( $instance['background_image'] )
			&& ( ! empty( $this->display['ewc_background']['display'] )
				&& true === $this->display['ewc_background']['display']
			) ) {
			$background_image = ' ' . "url('" . $instance['background_image'] . "')";
		} else {
			$background_image = '';
		}

		// Background repeat.
		if ( ! empty( $instance['background_repeat'] )
			&& ( ! empty( $this->display['ewc_background']['display'] )
				&& true === $this->display['ewc_background']['display']
			) ) {
			$background_repeat = ' ' . $instance['background_repeat'];
		} else {
			$background_repeat = '';
		}

		// Background attachment.
		if ( ! empty( $instance['background_attachment'] )
			&& ( ! empty( $this->display['ewc_background']['display'] )
				&& true === $this->display['ewc_background']['display']
			) ) {
			$background_attachment = ' ' . $instance['background_attachment'];
		} else {
			$background_attachment = '';
		}

		// Background position.
		if ( ! empty( $instance['background_position'] )
			&& ( ! empty( $this->display['ewc_background']['display'] ) && true === $this->display['ewc_background']['display'] ) ) {
			$background_position = ' ' . $instance['background_position'];
		} else {
			$background_position = '';
		}

		// Background size.
		if ( ! empty( $instance['background_size'] ) && 'none' !== $instance['background_size']
			&& ( ! empty( $this->display['ewc_background']['display'] ) && true === $this->display['ewc_background']['display'] ) ) {
			$background_size = 'background-size:' . $instance['background_size'] . ';';
		} else {
			$background_size = '';
		}

		// Row padding.
		$padding_top    = $instance['padding_top'];
		$padding_right  = $instance['padding_right'];
		$padding_bottom = $instance['padding_bottom'];
		$padding_left   = $instance['padding_left'];

		if ( ( ! empty( $this->display['ewc_padding']['display'] )
			&& true === $this->display['ewc_padding']['display'] ) ) {
			$padding = 'padding:' . $padding_top . 'px ' . $padding_right . 'px ' . $padding_bottom . 'px ' . $padding_left . 'px;';

			if ( 'padding:0px 0px 0px 0px;' === $padding ) {
				$padding = '';
			}
		} else {
			$padding = '';
		}

		// Row margin.
		$margin_top    = $instance['margin_top'];
		$margin_right  = $instance['margin_right'];
		$margin_bottom = $instance['margin_bottom'];
		$margin_left   = $instance['margin_left'];

		if ( ( ! empty( $this->display['ewc_margin']['display'] )
			&& true === $this->display['ewc_margin']['display'] ) ) {
			$margin = 'margin:' . $margin_top . 'px ' . $margin_right . 'px ' . $margin_bottom . 'px ' . $margin_left . 'px;';

			if ( 'margin:0px 0px 0px 0px;' === $margin ) {
				$margin = '';
			}
		} else {
			$margin = '';
		}

		// Inline styles.
		if ( ! empty( $background_color )
			|| ! empty( $background_image )
			|| ! empty( $padding )
			|| ! empty( $margin ) ) {
			if ( ! empty( $background_color ) && ! empty( $background_image ) ) {
				$background = 'background:' . $background_color . $background_image . $background_repeat . $background_attachment . $background_position . ';';
			} elseif ( empty( $background_color ) && ! empty( $background_image ) ) {
				$background = 'background:' . $background_image . $background_repeat . $background_attachment . $background_position . ';';
			} elseif ( ! empty( $background_color ) && empty( $background_image ) ) {
				$background = 'background:' . $background_color . ';';
			} else {
				$background = '';
			}

			$style = ' style="' . $background . $background_size . $padding . $margin . '"';
		} else {
			$style = '';
		}

		// Custom Classes.
		if ( ( ! empty( $instance['custom_classes'] ) || ! empty( $instance['preset_classes'] ) )
			&& ( ! empty( $this->display['ewc_class']['display'] )
				&& true === $this->display['ewc_class']['display']
			) ) {

			// Merge preset classes with custom classes.
			if ( ! empty( $instance['preset_classes'] ) && is_array( $instance['preset_classes'] ) ) {
				$custom_classes = explode( ' ', $instance['custom_classes'] );
				foreach ( $instance['preset_classes'] as $key => $value ) {
					if ( ! in_array( $value, $custom_classes, true ) ) {
						$custom_classes[] = $value;
					}
				}
				$custom_classes = ' ' . implode( ' ', $custom_classes );
			} else {
				$custom_classes = ' ' . $instance['custom_classes'];
			}
		} else {
			$custom_classes = '';
		}

		global $wp_registered_widgets;

		// Get the widget's instance number.
		$widget_instance = preg_replace( '/[^0-9]/', '', $this->id );
		$widget_row_id   = 'id="widget-row-' . $widget_instance . '" ';

		// Get the widget's position in the sidebar.
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );
		$sidebar_id       = $sidebars_widgets[ $args['id'] ]; // Current sidebar ID.
		$position_id      = array_search( $this->id, $sidebar_id, true );

		// Assign the closing widget row markup.
		if ( isset( $sidebar_id[ $position_id - 1 ] )
			&& ! in_array( _get_widget_id_base( $sidebar_id[ $position_id - 1 ] ), array( 'ewc-row-divider', 'ewc-subrow-divider' ), true ) ) {

			// Get widget above options.
			$widget_above_option = get_option( $wp_registered_widgets[ $sidebar_id[ $position_id - 1 ] ]['callback'][0]->option_name );
			$widget_above_index  = preg_replace( '/[^0-9]/', '', $sidebar_id[ $position_id - 1 ] );

			if ( isset( $widget_above_option[ $widget_above_index ]['ewc_width'] ) ) {
				$ewc_width_above = $widget_above_option[ $widget_above_index ]['ewc_width'];
			} else {
				$ewc_width_above = '';
			}

			if ( ! empty( $ewc_width_above ) && 'none' !== $ewc_width_above ) {
				echo '</div></div>';
			}
		}

		// Assign the opening widget row markup.
		if ( isset( $sidebar_id[ $position_id + 1 ] )
			&& ! in_array( _get_widget_id_base( $sidebar_id[ $position_id + 1 ] ), array( 'ewc-row-divider', 'ewc-subrow-divider' ), true ) ) {

			// Get widget below options.
			$widget_below_option = get_option( $wp_registered_widgets[ $sidebar_id[ $position_id + 1 ] ]['callback'][0]->option_name );
			$widget_below_index  = preg_replace( '/[^0-9]/', '', $sidebar_id[ $position_id + 1 ] );

			if ( isset( $widget_below_option[ $widget_below_index ]['ewc_width'] ) ) {
				$ewc_width_below = $widget_below_option[ $widget_below_index ]['ewc_width'];
			} else {
				$ewc_width_below = '';
			}

			if ( ! empty( $ewc_width_below ) && 'none' !== $ewc_width_below ) {
				if ( apply_filters( 'ewc_advanced_options', true ) && '1' === $instance['show_options'] ) {
					echo '<div ' . wp_kses_post( $widget_row_id ) . ' class="widget-row' . esc_attr( $custom_classes ) . '"' . wp_kses_post( $style ) . '><div class="wrap">';
				} else {
					echo '<div ' . wp_kses_post( $widget_row_id ) . ' class="widget-row"><div class="wrap">';
				}
			}
		}
	}

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param array $new_instance The new instance of values to be generated via the update.
	 * @param array $old_instance The previous instance of values before the update.
	 **/
	public function update( $new_instance, $old_instance ) {
		$instance                          = $old_instance;
		$instance['show_options']          = wp_strip_all_tags( $new_instance['show_options'] );
		$instance['show_background']       = wp_strip_all_tags( $new_instance['show_background'] );
		$instance['show_margin']           = wp_strip_all_tags( $new_instance['show_margin'] );
		$instance['show_padding']          = wp_strip_all_tags( $new_instance['show_padding'] );
		$instance['show_class']            = wp_strip_all_tags( $new_instance['show_class'] );
		$instance['background_color']      = wp_strip_all_tags( sanitize_hex_color( $new_instance['background_color'] ) );
		$instance['background_image']      = esc_url( $new_instance['background_image'] );
		$instance['background_repeat']     = wp_strip_all_tags( $new_instance['background_repeat'] );
		$instance['background_attachment'] = wp_strip_all_tags( $new_instance['background_attachment'] );
		$instance['background_position']   = wp_strip_all_tags( $new_instance['background_position'] );
		$instance['background_size']       = wp_strip_all_tags( $new_instance['background_size'] );
		$instance['padding_top']           = absint( $new_instance['padding_top'] );
		$instance['padding_right']         = absint( $new_instance['padding_right'] );
		$instance['padding_bottom']        = absint( $new_instance['padding_bottom'] );
		$instance['padding_left']          = absint( $new_instance['padding_left'] );
		$instance['margin_top']            = absint( $new_instance['margin_top'] );
		$instance['margin_right']          = absint( $new_instance['margin_right'] );
		$instance['margin_bottom']         = absint( $new_instance['margin_bottom'] );
		$instance['margin_left']           = absint( $new_instance['margin_left'] );
		$instance['custom_classes']        = wp_strip_all_tags( preg_replace( array( '/\s*,\s*/', '/\s+/' ), ' ', $new_instance['custom_classes'] ) );
		$instance['preset_classes']        = array_map( 'strip_tags', $new_instance['preset_classes'] );

		return $instance;
	}

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param array $instance The array of keys and values for the widget.
	 **/
	public function form( $instance ) {
		// Sanitize filter values.
		$show_background = ! empty( $this->display['ewc_background']['active'] ) ? $this->display['ewc_background']['active'] : 0;
		$show_margin     = ! empty( $this->display['ewc_margin']['active'] ) ? $this->display['ewc_margin']['active'] : 0;
		$show_padding    = ! empty( $this->display['ewc_padding']['active'] ) ? $this->display['ewc_padding']['active'] : 0;
		$show_class      = ! empty( $this->display['ewc_class']['active'] ) ? $this->display['ewc_class']['active'] : 0;

		// Set widget default values.
		$defaults = array(
			'show_options'          => 0,
			'show_background'       => $show_background,
			'show_margin'           => $show_margin,
			'show_padding'          => $show_padding,
			'show_class'            => $show_class,
			'background_color'      => '',
			'background_image'      => '',
			'background_repeat'     => 'repeat',
			'background_attachment' => 'scroll',
			'background_position'   => 'left top',
			'background_size'       => 'auto',
			'padding_top'           => 0,
			'padding_right'         => 0,
			'padding_bottom'        => 0,
			'padding_left'          => 0,
			'margin_top'            => 0,
			'margin_right'          => 0,
			'margin_bottom'         => 0,
			'margin_left'           => 0,
			'custom_classes'        => '',
			'preset_classes'        => array(),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p><?php echo esc_html__( 'Use this widget to start or close a new row of widget columns.', 'easy-widget-columns' ); ?></p>
		<?php

		if ( apply_filters( 'ewc_advanced_options', true ) ) {
			?>
			<input type="checkbox" class="ewc-options-checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_options' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_options' ) ); ?>" value="1" <?php checked( 1, $instance['show_options'] ); ?>>
			<label class="ewc-options-label" for="<?php echo esc_attr( $this->get_field_id( 'show_options' ) ); ?>"><?php echo esc_html__( 'Advanced options', 'easy-widget-columns' ); ?></label>

			<div class="ewc-row-styles">

			<?php
			if ( ! empty( $this->display['ewc_background']['display'] ) && true === $this->display['ewc_background']['display'] ) {
				?>
				<input type="checkbox" class="ewc-label-checkbox ewc-background-checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_background' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_background' ) ); ?>" value="1" <?php checked( 1, $instance['show_background'] ); ?>>
				<label class="ewc-section-label ewc-background-label" for="<?php echo esc_attr( $this->get_field_id( 'show_background' ) ); ?>"><?php echo esc_html__( 'Row background', 'easy-widget-columns' ); ?></label>

				<div class="ewc-section-settings ewc-background-settings">
					<p style="margin-top:2px;">
						<label for="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>"><?php echo esc_html__( 'Color:', 'easy-widget-columns' ); ?></label><br>
						<input class="color-picker" id="<?php echo esc_attr( $this->get_field_id( 'background_color' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_color' ) ); ?>" type="text" value="<?php echo esc_attr( $instance['background_color'] ); ?>" data-default-color="">
					</p>

					<label for="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>"><?php echo esc_html__( 'Image:', 'easy-widget-columns' ); ?></label>
					<input type="url" class="widefat custom-media-url" name="<?php echo esc_attr( $this->get_field_name( 'background_image' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'background_image' ) ); ?>" value="<?php echo esc_attr( $instance['background_image'] ); ?>" placeholder="<?php echo esc_html__( 'Enter URL or select image', 'easy-widget-columns' ); ?>">
					<button type="button" class="button custom-media-button" id="<?php echo esc_attr( $this->get_field_id( 'media_button' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_image' ) ); ?>"><?php echo esc_html__( 'Select Image', 'easy-widget-columns' ); ?></button>

					<div class="ewc-image-properties">
						<p class="first image-properties-dropdown">
							<label for="<?php echo esc_attr( $this->get_field_id( 'background_repeat' ) ); ?>"><?php echo esc_html__( 'Repeat:', 'easy-widget-columns' ); ?></label><br>
							<select id="<?php echo esc_attr( $this->get_field_id( 'background_repeat' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_repeat' ) ); ?>">
								<?php
								$repeat_options = array(
									esc_html__( 'Tile', 'easy-widget-columns' )       => 'repeat',
									esc_html__( 'Horizontal', 'easy-widget-columns' ) => 'repeat-x',
									esc_html__( 'Vertical', 'easy-widget-columns' )   => 'repeat-y',
									esc_html__( 'No Repeat', 'easy-widget-columns' )  => 'no-repeat',
								);
								foreach ( $repeat_options as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" id="' . esc_attr( $value ) . '"', $instance['background_repeat'] === $value ? ' selected="selected"' : '', '>', esc_attr( $key ), '</option>';
								}
								?>
							</select>
						</p>

						<p class="image-properties-dropdown">
							<label for="<?php echo esc_attr( $this->get_field_id( 'background_attachment' ) ); ?>"><?php echo esc_html__( 'Attachment:', 'easy-widget-columns' ); ?></label><br>
							<select id="<?php echo esc_attr( $this->get_field_id( 'background_attachment' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_attachment' ) ); ?>">
								<?php
								$attachment_options = array(
									esc_html__( 'Scroll', 'easy-widget-columns' ) => 'scroll',
									esc_html__( 'Fixed', 'easy-widget-columns' )  => 'fixed',
								);
								foreach ( $attachment_options as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" id="' . esc_attr( $value ) . '"', $instance['background_attachment'] === $value ? ' selected="selected"' : '', '>', esc_attr( $key ), '</option>';
								}
								?>
							</select>
						</p>

						<p class="first image-properties-dropdown">
							<label for="<?php echo esc_attr( $this->get_field_id( 'background_position' ) ); ?>"><?php echo esc_html__( 'Position:', 'easy-widget-columns' ); ?></label><br>
							<select id="<?php echo esc_attr( $this->get_field_id( 'background_position' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_position' ) ); ?>">
								<?php
								$position_options = array(
									esc_html__( 'Left Top', 'easy-widget-columns' )      => 'left top',
									esc_html__( 'Left Center', 'easy-widget-columns' )   => 'left center',
									esc_html__( 'Left Bottom', 'easy-widget-columns' )   => 'left bottom',
									esc_html__( 'Right Top', 'easy-widget-columns' )     => 'right top',
									esc_html__( 'Right Center', 'easy-widget-columns' )  => 'right center',
									esc_html__( 'Right Bottom', 'easy-widget-columns' )  => 'right bottom',
									esc_html__( 'Center Top', 'easy-widget-columns' )    => 'center top',
									esc_html__( 'Center', 'easy-widget-columns' )        => 'center center',
									esc_html__( 'Center Bottom', 'easy-widget-columns' ) => 'center bottom',
								);
								foreach ( $position_options as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" id="' . esc_attr( $value ) . '"', $instance['background_position'] === $value ? ' selected="selected"' : '', '>', esc_attr( $key ), '</option>';
								}
								?>
							</select>
						</p>

						<p class="image-properties-dropdown">
							<label for="<?php echo esc_attr( $this->get_field_id( 'background_size' ) ); ?>"><?php echo esc_html__( 'Scale:', 'easy-widget-columns' ); ?></label><br>
							<select id="<?php echo esc_attr( $this->get_field_id( 'background_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'background_size' ) ); ?>">
								<?php
								$size_options = array(
									esc_html__( 'None', 'easy-widget-columns' )    => 'none',
									esc_html__( 'Cover', 'easy-widget-columns' )   => 'cover',
									esc_html__( 'Contain', 'easy-widget-columns' ) => 'contain',
								);
								foreach ( $size_options as $key => $value ) {
									echo '<option value="' . esc_attr( $value ) . '" id="' . esc_attr( $value ) . '"', $instance['background_size'] === $value ? ' selected="selected"' : '', '>', esc_attr( $key ), '</option>';
								}
								?>
							</select>
						</p>
					</div>
				</div>
				<hr>
				<?php
			}

			if ( ! empty( $this->display['ewc_margin']['display'] ) && true === $this->display['ewc_margin']['display'] ) {
				?>
				<input type="checkbox" class="ewc-label-checkbox ewc-margin-checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_margin' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_margin' ) ); ?>" value="1" <?php checked( 1, $instance['show_margin'] ); ?>>
				<label class="ewc-section-label" for="<?php echo esc_attr( $this->get_field_id( 'show_margin' ) ); ?>"><?php echo esc_html__( 'Row margin', 'easy-widget-columns' ); ?></label>

				<div class="ewc-section-settings ewc-widget-table ewc-margin-settings">
					<table class="ewc-margin-table">
						<tr>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'margin_top' ) ); ?>"><?php echo esc_html__( 'top:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'margin_top' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_top' ) ); ?>" value="<?php echo esc_attr( $instance['margin_top'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'margin_top' ) ); ?>">px</label>
							</td>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'margin_right' ) ); ?>"><?php echo esc_html__( 'right:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'margin_right' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_right' ) ); ?>" value="<?php echo esc_attr( $instance['margin_right'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'margin_right' ) ); ?>">px</label>
							</td>
						</tr>
						<tr>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'margin_bottom' ) ); ?>"><?php echo esc_html__( 'btm:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'margin_bottom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_bottom' ) ); ?>" value="<?php echo esc_attr( $instance['margin_bottom'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'margin_bottom' ) ); ?>">px</label>
							</td>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'margin_left' ) ); ?>"><?php echo esc_html__( 'left:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'margin_left' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'margin_left' ) ); ?>" value="<?php echo esc_attr( $instance['margin_left'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'margin_left' ) ); ?>">px</label>
							</td>
						</tr>
					</table>
				</div>
				<hr>
				<?php
			}

			if ( ! empty( $this->display['ewc_padding']['display'] ) && true === $this->display['ewc_padding']['display'] ) {
				?>
				<input type="checkbox" class="ewc-label-checkbox ewc-padding-checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_padding' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_padding' ) ); ?>" value="1" <?php checked( 1, $instance['show_padding'] ); ?>>
				<label class="ewc-section-label" for="<?php echo esc_attr( $this->get_field_id( 'show_padding' ) ); ?>"><?php echo esc_html__( 'Row padding', 'easy-widget-columns' ); ?></label>

				<div class="ewc-section-settings ewc-widget-table ewc-padding-settings">
					<table class="ewc-padding-table">
						<tr>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'padding_top' ) ); ?>"><?php echo esc_html__( 'top:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'padding_top' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'padding_top' ) ); ?>" value="<?php echo esc_attr( $instance['padding_top'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'padding_top' ) ); ?>">px</label>
							</td>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'padding_right' ) ); ?>"><?php echo esc_html__( 'right:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'padding_right' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'padding_right' ) ); ?>" value="<?php echo esc_attr( $instance['padding_right'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'padding_right' ) ); ?>">px</label>
							</td>
						</tr>
						<tr>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'padding_bottom' ) ); ?>"><?php echo esc_html__( 'btm:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'padding_bottom' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'padding_bottom' ) ); ?>" value="<?php echo esc_attr( $instance['padding_bottom'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'padding_bottom' ) ); ?>">px</label>
							</td>
							<td class="row-content">
								<label class="row-label" for="<?php echo esc_attr( $this->get_field_id( 'padding_left' ) ); ?>"><?php echo esc_html__( 'left:', 'easy-widget-columns' ); ?></label>
								<input type="number" step="1" min="0" id="<?php echo esc_attr( $this->get_field_id( 'padding_left' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'padding_left' ) ); ?>" value="<?php echo esc_attr( $instance['padding_left'] ); ?>" style="width:60px;">
								<label for="<?php echo esc_attr( $this->get_field_id( 'padding_left' ) ); ?>">px</label>
							</td>
						</tr>
					</table>
				</div>
				<hr>
				<?php
			}

			if ( ! empty( $this->display['ewc_class']['display'] ) && true === $this->display['ewc_class']['display'] ) {
				?>
				<input type="checkbox" class="ewc-label-checkbox ewc-class-checkbox" id="<?php echo esc_attr( $this->get_field_id( 'show_class' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_class' ) ); ?>" value="1" <?php checked( 1, $instance['show_class'] ); ?>>
				<label class="ewc-section-label" for="<?php echo esc_attr( $this->get_field_id( 'show_class' ) ); ?>"><?php echo esc_html__( 'CSS classes', 'easy-widget-columns' ); ?></label>

				<div class="ewc-section-settings ewc-class-settings">
					<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'custom_classes' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'custom_classes' ) ); ?>" value="<?php echo esc_attr( $instance['custom_classes'] ); ?>" placeholder="<?php echo esc_html__( 'Enter custom classes', 'easy-widget-columns' ); ?>">
					<?php
					$presets = apply_filters( 'ewc_preset_classes', array() );

					if ( ! empty( $presets ) ) {
						?>
						<ul class="ewc-preset-classes" id="<?php echo esc_attr( $this->get_field_id( 'preset_classes' ) ); ?>">
							<?php
							foreach ( $presets as $preset ) {
								$checked = '';

								if ( isset( $instance['preset_classes'] ) && in_array( $preset, $instance['preset_classes'], true ) ) {
									$checked = 'checked="checked"';
								}

								?>
								<li>
									<input type="checkbox" class="ewc-preset-class" id="<?php echo esc_attr( $this->get_field_id( 'preset_classes' ) ) . '-' . esc_attr( $preset ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'preset_classes' ) ); ?>[]" value="<?php echo esc_attr( $preset ); ?>" <?php echo wp_kses_post( $checked ); ?>>
									<label class="ewc-preset-label" for="<?php echo esc_attr( $this->get_field_id( 'preset_classes' ) ) . '-' . esc_attr( $preset ); ?>"><?php echo esc_attr( $preset ); ?></label>
								</li>
								<?php
							}
							?>
						</ul>

						<?php
						if ( $instance['preset_classes'] && 0 !== count( $instance['preset_classes'] ) ) {
							if ( 1 === count( $instance['preset_classes'] ) ) {
								$count_message = ' ' . esc_html__( 'class checked above', 'easy-widget-columns' );
							} else {
								$count_message = ' ' . esc_html__( 'classes checked above', 'easy-widget-columns' );
							}

							?>
							<p class="checked-count description" style="padding-bottom:0;">
								<?php echo esc_html( count( $instance['preset_classes'] ) . $count_message ); ?>
							</p>
							<?php
						}
					}
					?>
				</div>
				<hr>
				<?php
			}
			?>

			</div>
			<?php
		}
	}
}
