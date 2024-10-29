<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

if ( current_user_can( 'delete_plugins' ) && !is_multisite() && !is_network_admin() ) {
	
	/**
	 * Get all option values.
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
	 * If Delete-Option for internal SEO link entries is enabled.
	 *
	 * @since      1.0.0
	 */
	if ( $purgeInternalByDeactivation == 'true' ) {
		
		// Query all SEO link entries with an internal link type.
		$args = array(
			'post_type' => 'autoseolink',
			'meta_key' => 'autoseolinks_link_type',
			'meta_value' => 'autoseolinks-type-internal'				
		);
		$internalLinkQuery = new WP_Query( $args );
		
		// Delete the posts.
		if ( $internalLinkQuery->have_posts() ) :
			while ( $internalLinkQuery->have_posts() ) : $internalLinkQuery->the_post();
				wp_delete_post( get_the_ID() );
			endwhile; wp_reset_postdata();
		endif;
	}
	
	/**
	 * If Delete-Option for external SEO link entries is enabled.
	 *
	 * @since      1.0.0
	 */
	if ( $purgeExternalByDeactivation == 'true' ) {
		
		// Query all SEO link entries with an internal link type.
		$args = array(
			'post_type' => 'autoseolink',
			'meta_key' => 'autoseolinks_link_type',
			'meta_value' => 'autoseolinks-type-external'				
		);
		$externalLinkQuery = new WP_Query( $args );
		
		// Delete the posts.
		if ( $externalLinkQuery->have_posts() ) :
			while ( $externalLinkQuery->have_posts() ) : $externalLinkQuery->the_post();
				wp_delete_post( get_the_ID() );
			endwhile; wp_reset_postdata();
		endif;
	}
	
	/**
	 * If Delete-Option for plugin settings is enabled.
	 *
	 * @since      1.0.0
	 */
	if ( $purgeOptionsByDeactivation == 'true' ) {			
		if ( $excludedPosts ) { delete_option('autoseolinks_options_exclude_posts'); }
		if ( $seoLinkLimit ) { delete_option('autoseolinks_options_limit_seo_links'); }
		if ( $internalLinkTargetLimit ) { delete_option('autoseolinks_options_limit_internal_targets'); }
		if ( $purgeInternalByDeactivation ) { delete_option('autoseolinks_options_delete_internal_links'); }
		if ( $purgeExternalByDeactivation ) { delete_option('autoseolinks_options_delete_external_links'); }
		if ( $purgeOptionsByDeactivation ) { delete_option('autoseolinks_options_delete_options'); }			
	}
}