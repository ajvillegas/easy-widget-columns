<?php

/**
 * The widget functionality of the plugin.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/widgets
 */

/**
 * The widget functionality of the plugin. This class is responsible for registering
 * all the widgets.
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/widgets
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Easy_Widget_Columns_Widgets {

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
		$this->load_widget_classes();

	}
	
	/**
	 * Load widget classes.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_widget_classes() {
	
		/**
		 * The class responsible for defining the Widget Row widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-widget-row-divider.php';
		
		/**
		 * The class responsible for defining the Sub Row widget.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-widget-subrow-divider.php';
	
	}
	
	/**
	 * Register the stylesheets for the widget's admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		
		wp_enqueue_style( 'wp-color-picker' );
		
	}

	/**
	 * Register the JavaScript for the widget's admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {
		
		// Load script on widgets page only
		if ( $hook != 'widgets.php' ) {
			return;
		}
		
		// Color picker	
		wp_enqueue_script( 'wp-color-picker' );
		
		// Image uploader
		wp_enqueue_media();
		wp_register_script( 'ajv-image-upload', plugin_dir_url( __FILE__ ) . 'js/image-upload.min.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( 'ajv-image-upload', 'ajv_image_upload',
            array(
                'frame_title' => __( 'Choose or Upload Image', 'easy-widget-columns' ),
                'frame_button' => __( 'Insert Image', 'easy-widget-columns' ),
            )
        );
		wp_enqueue_script( 'ajv-image-upload' );
		
	}
	
	/**
	 * Print JavaScript in the widget's admin footer.
	 *
	 * Use the ewc_color_palette filter to add a custom color
	 * palette for the color picker control.
	 *
	 * @since    1.1.0
	 */
	public function print_scripts() {
		
		?>
		<script>
			( function( $ ) {
				
				function initColorPicker( widget ) {
					widget.find( '.color-picker' ).wpColorPicker( {
						<?php
							$ewc_color_palette = apply_filters( 'ewc_color_palette', array() );
							if ( !empty($ewc_color_palette) ) {
								$palettes = "['" . implode("','", $ewc_color_palette) . "']";
							} else {
								$palettes = 'true';
							}
						?>
						palettes: <?php echo $palettes ?>,
						width: 232,
						change: _.throttle( function() { // For Customizer
							$(this).trigger( 'change' );
						}, 3000 )
					} );
				}

				function onFormUpdate2( event, widget ) {
					initColorPicker( widget );
				}

				$( document ).on( 'widget-added widget-updated', onFormUpdate2 );

				$( document ).ready( function() {
					$( '#widgets-right .widget:has(.color-picker), .inactive-sidebar .widget:has(.color-picker)' ).each( function() {
						initColorPicker( $( this ) );
					} );
				} );
				
			}( jQuery ) );
		</script>
		<?php
			
	}
	
	/**
     * Register all widgets.
     *
     * @since   1.0.0
     *
     **/
    public function register_widgets() {
	    
	    // Register the Widget Row widget
        register_widget( 'EWC_Row_Divider' );
        
        // Register the Sub-Row widget
        register_widget( 'EWC_Sub_Row_Divider' );
        
    }

}
