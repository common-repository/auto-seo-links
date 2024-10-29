<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/includes
 * @author     Arvid Schmeling <info@arvid-schmeling.de>
 */
class Auto_Seo_Links_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		if ( current_user_can( 'activate_plugins' ) && is_multisite() && !is_network_admin() ) {
	
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

	}

}
