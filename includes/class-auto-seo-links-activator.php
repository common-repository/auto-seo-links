<?php

/**
 * Fired during plugin activation
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/includes
 * @author     Arvid Schmeling <info@arvid-schmeling.de>
 */
class Auto_Seo_Links_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		
		/**
		 * Drag the option's values from the database into variables.
		 *
		 * @since      1.0.0
		 */
		$excludedPosts = get_option('autoseolinks_options_exclude_posts');		
		$seoLinkLimit = get_option('autoseolinks_options_limit_seo_links');
		$internalLinkTargetLimit = get_option('autoseolinks_options_limit_internal_targets');
		$purgeInternalByDeactivation = get_option('autoseolinks_options_delete_internal_links');
		$purgeExternalByDeactivation = get_option('autoseolinks_options_delete_external_links');
		$purgeOptionsByDeactivation = get_option('autoseolinks_options_delete_options');
		
		/**
		 * Check if the options exist in the database.
		 * If not, create them.
		 *
		 * @since      1.0.0
		 */
		if ( !$excludedPosts ) {
			add_option( 'autoseolinks_options_exclude_posts', 'false' );
		}
		
		if ( !$seoLinkLimit ) {
			add_option( 'autoseolinks_options_limit_seo_links', 0 );
		}
		
		if ( !$internalLinkTargetLimit ) {
			add_option( 'autoseolinks_options_limit_internal_targets', 0 );
		}
		
		if ( !$purgeInternalByDeactivation ) {
			add_option( 'autoseolinks_options_delete_internal_links', 'false' );
		}
		
		if ( !$purgeExternalByDeactivation ) {
			add_option( 'autoseolinks_options_delete_external_links', 'false' );
		}
		
		if ( !$purgeOptionsByDeactivation ) {
			add_option( 'autoseolinks_options_delete_options', 'false' );
		}
		
	}

}
