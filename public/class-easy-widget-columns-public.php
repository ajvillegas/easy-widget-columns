<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/public
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Easy_Widget_Columns_Public {

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
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Grab all options
		$options = get_option( $this->plugin_name );
		
		// Abort if the "Do NOT load the CSS" option is selected
		if ( 1 == $options['ewc_load_css'] ) {
			return;
		}
		
		// Check if current locale is RTL (Right To Left)	
		if ( is_rtl() ) {
			$column_classes = 'easy-widget-columns-public-rtl.css';
		} else {
			$column_classes = 'easy-widget-columns-public.css';
		}
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/' . $column_classes, array(), $this->version, 'all' );

	}

	/**
	 * Load embedded styles.
	 *
	 * @since	1.0.0
	 */
	public function embedded_styles() {
		
		// Check if current locale is RTL (Right To Left)
	    if ( is_rtl() ) {
		    $embedded_css = '.widget-row:after,.widget-row .wrap:after{clear:both;content:"";display:table;}.widget-row .full-width{float:right;width:100%;}';
		} else {
			$embedded_css = '.widget-row:after,.widget-row .wrap:after{clear:both;content:"";display:table;}.widget-row .full-width{float:left;width:100%;}';
		}
	    
	    echo '<style type="text/css">' . $embedded_css . '</style>';
	    
	}	

}
