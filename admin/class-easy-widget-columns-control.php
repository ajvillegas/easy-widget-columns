<?php

/**
 * The universal widget control functionality of the plugin.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin
 */

/**
 * The universal widget control functionality of the plugin.
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Easy_Widget_Columns_Control {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;
	
	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param    string    $plugin_name		The name of this plugin.
	 * @param    string    $version			The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/easy-widget-columns-admin.min.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		
		// Load script on widgets page only
		if ( $hook != 'widgets.php' )
			return;
			
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), '4.0.3', false );
		
	}
	
	/**
	 * Print JavaScript in admin footer.
	 *
	 * @since    1.0.0
	 */
	public function print_scripts() {
		
		?>
		<script>
			( function( $ ) {
				
				function initSelect2( widget ) {
					widget.find( 'select.ewc-select' ).ewcselect2( {
						minimumResultsForSearch: Infinity,
						templateResult: formatIcons,
						templateSelection: formatIcons,
						theme: 'ewc-select'
					} );
				}
				
				function formatIcons ( icon ) {
					if (!icon.id) { return icon.text; }
					var $icon = $(
						'<span><i class="ewc-icon-' + $(icon.element).data('icon') + '"></i> ' + icon.text + '</span>'
					);
					return $icon;
				}
	
				function onFormUpdate( event, widget ) {
					initSelect2( widget );
				}
	
				$( document ).on( 'widget-added widget-updated', onFormUpdate );
				
				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.ewc-select), .inactive-sidebar .widget:has(.ewc-select)' ).each( function () {
						initSelect2( $( this ) );
					} );
				} );
				
			}( jQuery ) );
		</script>
		<?php
			
	}
	
	/**
	 * Add custom select control to the widget form.
	 *
	 * Use the ewc_exclude_widgets filter to remove the control from specified widgets,
	 * and the ewc_include_widgets filter to ONLY add the control to specified widgets.
	 *
	 * The ewc_include_widgets filter will always take precedence over the ewc_exclude_widgets filter.
	 *
	 * @since	1.0.0
	 */
	public function widget_form( $widget, $return, $instance ) {
		
		// Filter which widgets the control is added to
		$ewc_include_widgets = apply_filters( 'ewc_include_widgets', array() ); // Whitelist filter
		$ewc_exclude_widgets = apply_filters( 'ewc_exclude_widgets', array() ); // Blacklist filter
		
		if ( !empty( $ewc_include_widgets ) &&
			( in_array( $widget->id_base, array( 'ewc-row-divider', 'ewc-subrow-divider' ) ) || !in_array( $widget->id_base, $ewc_include_widgets ) ) ) {
			return;
		} else if ( empty( $ewc_include_widgets ) &&
			( in_array( $widget->id_base, array( 'ewc-row-divider', 'ewc-subrow-divider' ) ) || in_array( $widget->id_base, $ewc_exclude_widgets ) ) ) {
			return;
		}
		
		// Add custom select control
		$defaults = array(
			'ewc_width' => __('none', 'easy-widget-columns'),
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		// Form markup
		include( plugin_dir_path( __FILE__ ) . 'partials/easy-widget-columns-widget-form.php' );
			
	}
	
	/**
	 * Process the widget's options to be saved.
	 *
	 * @since	1.0.0
	 */
	public function widget_update( $instance, $new_instance, $old_instance ) {
		
		$instance['ewc_width'] = strip_tags( $new_instance['ewc_width'] );
		return $instance;
		
	}
	
	/**
	 * Set default widget options.
	 *
	 * @since	1.0.0
	 */
	public function get_defaults() {
		
		return array(
			'ewc_width' => __('none', 'easy-widget-columns'),
		);
		
	}
	
	/**
	 * Get the widget's ID.
	 *
	 * @since	1.0.0
	 */
	public function get_widget_id( $widget ) {
		
		preg_match( '/-([0-9]+)$/', $widget, $matches );
		return $matches[1];
		
	}
	
	/**
	 * Filter the widget's sidebar parameters.
	 *
	 * @since	1.1.0
	 * @param   array   $params
	 * @return  array   $params
	 */
	public function sidebar_params( $params ) {
		
		global $wp_registered_widgets;
		
		// Check if widget has options
		if ( empty( $wp_registered_widgets[$params[0]['widget_id']]['callback'][0]->option_name ) ) {
			return $params;
		}
		
		// Retrieve the widget options
		$defaults = $this->get_defaults();
		$widget_id = $this->get_widget_id( $params[0]['widget_id'] );
		$options = get_option( $wp_registered_widgets[$params[0]['widget_id']]['callback'][0]->option_name );
		$options[$widget_id] = wp_parse_args( $options[$widget_id], $defaults );
		$ewc_width = $options[$widget_id]['ewc_width'];
		
		// Get the widget's position in the sidebar
		$sidebars_widgets = get_option( 'sidebars_widgets', array() );
		$sidebar_id = $sidebars_widgets[$params[0]['id']];
		$position_id = array_search( $params[0]['widget_id'], $sidebar_id );
		
		// Retrieve the widget above options
		if ( isset( $sidebar_id[$position_id-2] ) ) {
			$widget_above_option = get_option( $wp_registered_widgets[$sidebar_id[$position_id-2]]['callback'][0]->option_name );
			$widget_above_index = preg_replace( '/[^0-9]/', '', $sidebar_id[$position_id-2] );
		} else {
			$widget_above_option = '';
			$widget_above_index = '';
		}
		if ( isset( $widget_above_option[$widget_above_index]['ewc_width'] ) ) {
			$ewc_width_above = $widget_above_option[$widget_above_index]['ewc_width'];
		} else {
			$ewc_width_above = '';
		}
		
		// Determine first widget in a row and assign .first class
		if ( ( isset( $sidebar_id[$position_id-1] )
				&& in_array( _get_widget_id_base( $sidebar_id[$position_id-1] ), array('ewc-row-divider') ) )
			|| ( ( isset( $sidebar_id[$position_id-1] )
				&& isset( $sidebar_id[$position_id-2] )
				&& in_array( _get_widget_id_base( $sidebar_id[$position_id-1] ), array('ewc-subrow-divider') )
				&& 'none' !== $ewc_width_above ) ) ) {
			$first = 'first ';
		} else {
			$first = '';
		}
		
		// Determine last widget in sidebar and assign closing row markup
		if ( ( end( $sidebar_id ) == $params[0]['widget_id'] ) ) {
			$wrap_close = '</div></div>';
		} else {
			$wrap_close = '';
		}
		
		// Remove the .first class when the '1/1' option is selected
		if ( 'full-width' == $ewc_width ) {
			$first = '';
		}
		
		// Ouput the columm classes and markup
		if ( ( !empty( $ewc_width ) && 'none' !== $ewc_width ) && ( !empty( $params[0]['before_widget'] ) && !empty( $params[0]['after_widget'] ) ) ) {
			$params[0]['before_widget'] = preg_replace( '/class="/', 'class="'. $first . $ewc_width . ' ' , $params[0]['before_widget'], 1 );
			$params[0]['after_widget'] .= $wrap_close;
		}
		
		// Output data attribute in the Customizer preview window
		if ( is_customize_preview() ) {
			
			if ( ( !empty( $ewc_width ) && 'none' !== $ewc_width ) && ( !empty( $params[0]['before_widget'] ) ) ) {
				$params[0]['before_widget'] = preg_replace( '/class="/', 'data-column="true" class="' , $params[0]['before_widget'], 1 );
			} elseif ( ( !empty( $ewc_width ) && 'none' == $ewc_width ) && ( !empty( $params[0]['before_widget'] ) ) ) {
				$params[0]['before_widget'] = preg_replace( '/class="/', 'data-column="false" class="' , $params[0]['before_widget'], 1 );
			}
			
		}
			
		return $params;
		
	}

}
