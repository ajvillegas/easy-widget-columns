<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.alexisvillegas.com
 * @since      1.0.0
 *
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Easy_Widget_Columns
 * @subpackage Easy_Widget_Columns/includes
 * @author     Alexis J. Villegas <alexis@ajvillegas.com>
 */
class Easy_Widget_Columns {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Easy_Widget_Columns_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'easy-widget-columns';
		$this->version = '1.2.0';
		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_widget_control_hooks();
		$this->load_widgets();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Easy_Widget_Columns_Loader. Orchestrates the hooks of the plugin.
	 * - Easy_Widget_Columns_i18n. Defines internationalization functionality.
	 * - Easy_Widget_Columns_Admin. Defines all hooks for the admin area.
	 * - Easy_Widget_Columns_Control. Defines all hooks for the universal widget control functionality.
	 * - Easy_Widget_Columns_Widgets. Registers all widgets.
	 * - Easy_Widget_Columns_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-widget-columns-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-easy-widget-columns-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-widget-columns-admin.php';
		
		/**
		 * The class responsible for registering the universal widget control and outputting the column classes.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-easy-widget-columns-control.php';
		
		/**
		 * The class responsible for registering all widgets.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widgets/class-easy-widget-columns-widgets.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-easy-widget-columns-public.php';

		$this->loader = new Easy_Widget_Columns_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Easy_Widget_Columns_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Easy_Widget_Columns_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Easy_Widget_Columns_Admin( $this->get_plugin_name(), $this->get_version() );
		
		// Add menu item
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
		
		// Add settings link to the plugin
		$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
		$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );
		
		// Save/Update the plugin options
		$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );
		
		// Register inline Customizer scripts
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_admin, 'inline_customizer_scripts' );
		
		// Enqueue Customizer preview scripts
		$this->loader->add_action( 'customize_preview_init', $plugin_admin, 'enqueue_customizer_preview_scripts' );
		
	}
	
	/**
     * Register all of the hooks related to the universal widget control functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_widget_control_hooks() {
	    
        $plugin_control = new Easy_Widget_Columns_Control( $this->get_Plugin_Name(), $this->get_version() );
        
        // Enqueue styles
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_control, 'enqueue_styles' );
		
		// Enqueue scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_control, 'enqueue_scripts' );
		
		// Print JavaScript in admin footer
		$this->loader->add_action( 'admin_footer-widgets.php', $plugin_control, 'print_scripts', 9999 );
		
		// Add custom select control to the widget form
		$this->loader->add_action( 'in_widget_form', $plugin_control, 'widget_form', 10, 3 );
		
		// Process the widget's options to be saved
		$this->loader->add_action( 'widget_update_callback', $plugin_control, 'widget_update', 10, 2 );
		
		// Filter the widget's sidebar parameters
		$this->loader->add_action( 'dynamic_sidebar_params', $plugin_control, 'sidebar_params', 9999 );
        
    }
	
	/**
     * Registers the hooks responsible for registering all widgets.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_widgets() {
	    
        $plugin_widgets = new Easy_Widget_Columns_Widgets( $this->get_Plugin_Name(), $this->get_version() );
        
        // Enqueue styles
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_widgets, 'enqueue_styles' );
		
		// Enqueue scripts
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_widgets, 'enqueue_scripts' );
		
		// Print JavaScript in admin footer
		$this->loader->add_action( 'admin_footer-widgets.php', $plugin_widgets, 'print_scripts', 9999 );
        
        // Register widgets
		$this->loader->add_action( 'widgets_init', $plugin_widgets, 'register_widgets' );
        
    }

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Easy_Widget_Columns_Public( $this->get_plugin_name(), $this->get_version() );
		
		// Enqueue styles
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		
		// Load embedded styles in <head>
		$this->loader->add_action( 'wp_head', $plugin_public, 'embedded_styles', 5 );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		
		$this->loader->run();
		
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		
		return $this->plugin_name;
		
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Easy_Widget_Columns_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		
		return $this->loader;
		
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		
		return $this->version;
		
	}

}
