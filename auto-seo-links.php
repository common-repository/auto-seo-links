<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://unflow.io
 * @since             1.0.0
 * @package           Auto_Seo_Links
 *
 * @wordpress-plugin
 * Plugin Name:       Auto SEO Links
 * Plugin URI:        http://unflow.io/auto-seo-links
 * Description:       Filters WordPress content for certain keywords and replace them with SEO links.
 * Version:           1.0.0
 * Author:            Unflow Media
 * Author URI:        http://unflow.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       auto-seo-links
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'PLUGIN_NAME_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-auto-seo-links-activator.php
 */
function activate_auto_seo_links() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-seo-links-activator.php';
	Auto_Seo_Links_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-auto-seo-links-deactivator.php
 */
function deactivate_auto_seo_links() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-auto-seo-links-deactivator.php';
	Auto_Seo_Links_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_auto_seo_links' );
register_deactivation_hook( __FILE__, 'deactivate_auto_seo_links' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-auto-seo-links.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_auto_seo_links() {

	$plugin = new Auto_Seo_Links();
	$plugin->run();

}
run_auto_seo_links();
