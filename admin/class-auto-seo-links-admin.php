<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin
 * @author     Arvid Schmeling <info@arvid-schmeling.de>
 */
class Auto_Seo_Links_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
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

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_Seo_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_Seo_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_style( 'select2_css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/auto-seo-links-admin.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Auto_Seo_Links_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Auto_Seo_Links_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( 'select2_js', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-core', '', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-autocomplete', '', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery-ui-tooltip', '', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'thickbox', '', array(), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/auto-seo-links-admin.min.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Add the SEO Link List page in the admin area
	 *
	 * @since  1.0.0
	 */
	public function add_seo_links_page() {
		
		add_menu_page( 
	        __( 'Auto SEO Links', 'auto-seo-links' ),
			__( 'Auto SEO Links', 'auto-seo-links' ),
	        'manage_options',
	        $this->plugin_name,
			array( $this, 'display_seo_links_page' ),	        
	        'dashicons-admin-links',
	        100
	    );
	    
	    add_submenu_page(
	    	'auto-seo-links', 
	    	__( 'Auto SEO Links', 'auto-seo-links' ), 
	    	__( 'SEO Links', 'auto-seo-links' ),
	    	'manage_options', 
	    	'auto-seo-links', 
	    	array( $this, 'display_seo_links_page' )
	    );
	    
	    add_submenu_page(
	    	'auto-seo-links', 
	    	__( 'Auto SEO Links - Options', 'auto-seo-links' ), 
	    	__( 'Options', 'auto-seo-links' ),
	    	'manage_options', 
	    	'auto-seo-links-options', 
	    	array( $this, 'display_seo_options_page' )
	    );
	}
	
	/**
	 * Render the SEO Link List page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_seo_links_page() {
		include_once 'partials/auto-seo-links-admin-link-list.php';
	}
	
	/**
	 * Render the SEO Link List page for plugin
	 *
	 * @since  1.0.0
	 */
	public function display_seo_options_page() {
		include_once 'partials/auto-seo-links-admin-options.php';
	}

}
