<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/admin
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Easy_Widget_Columns_Admin {

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
	 * Register the admin menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 * @link	 http://codex.wordpress.org/Administration_Menus
	 */
	public function add_admin_menu() {
		
		add_options_page( __( 'Easy Widget Columns Settings', 'easy-widget-columns' ), __( 'Widget Columns', 'easy-widget-columns' ), 'manage_options', $this->plugin_name, array( $this, 'display_settings_page' ) );
		
	}
	
	/**
	 * Render the plugin settings page.
	 *
	 * @since    1.0.0
	 */
	public function display_settings_page() {
		
		include_once( 'partials/easy-widget-columns-admin-display.php' );
		
	}
	
	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @link	 https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
	 */
	public function add_action_links( $links ) {
		
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', 'easy-widget-columns' ) . '</a>',
		);
		
		return array_merge( $settings_link, $links );
		
	}
	
	/**
	 * Validate the input fields.
	 *
	 * @since    1.0.0
	 */
	public function validate( $input ) {
		
		$valid = array();
		
		// Radio buttons
		$valid['ewc_load_css'] = ( isset( $input['ewc_load_css'] ) && !empty( $input['ewc_load_css'] ) ) ? absint( $input['ewc_load_css'] ) : 0;
		
		return $valid;
		
	}
	
	/**
	 * Register setting and its sanitization callback.
	 *
	 * @since    1.0.0
	 */
	public function options_update() {
		
		register_setting( $this->plugin_name, $this->plugin_name, array($this, 'validate') );
		
	}
	
	/**
	 * Register inline scripts for the Customizer preview.
	 *
	 * Override the reflowWidgets JS function in customize-preview-widgets.js
	 * to trigger a full-page refresh whenever a widget is moved in the sidebar.
	 *
	 * @since    1.1.5
	 */
	public function inline_customizer_scripts() {
		
		$js = 'wp.customize.widgetsPreview.SidebarPartial.prototype.reflowWidgets = function() { wp.customize.selectiveRefresh.requestFullRefresh(); };';
		wp_add_inline_script( 'customize-preview-widgets', $js );
		
	}
	
	/**
	 * Enqueue the scripts for the Customizer preview window.
	 *
	 * @since    1.1.5
	 */
	public function enqueue_customizer_preview_scripts() {
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/customizer-preview.min.js', array( 'jquery', 'customize-preview-widgets' ), $this->version, false );
		
	}
			
}
