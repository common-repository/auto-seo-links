<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->



<?php
/**
 * Check if the form got submitted and collect all submitted data.
 *
 * @since      1.0.0
 */	
if ( isset( $_POST['autoseolinks_submit_type'] ) ) {
 
	$submitType = sanitize_html_class($_POST['autoseolinks_submit_type']);
	
	if ( isset( $_POST['autoseolinks_options_exclude_posts'] ) ? (array) $_POST['autoseolinks_options_exclude_posts'] : array() ) {
		foreach ( $_POST['autoseolinks_options_exclude_posts'] as $excludedPost ) {
			if ( ctype_digit( $excludedPost ) == true ) {
				$excludedPosts[] = $excludedPost;
			}
		}
		
		$excludedPosts = implode( '|', $excludedPosts );
	} else { $excludedPosts = 'false'; }
	
	if ( $_POST['autoseolinks_options_limit_seo_links'] == '' || !$_POST['autoseolinks_options_limit_seo_links'] || !is_numeric($_POST['autoseolinks_options_limit_seo_links']) ) {
		$seoLinkLimit = 'false';		
	} else { $seoLinkLimit = $_POST['autoseolinks_options_limit_seo_links']; }
	
	if ( $_POST['autoseolinks_options_limit_internal_targets'] == '' || !$_POST['autoseolinks_options_limit_internal_targets'] || !is_numeric($_POST['autoseolinks_options_limit_internal_targets']) ) {
		$internalLinkTargetLimit = 'false';
	} else { $internalLinkTargetLimit = $_POST['autoseolinks_options_limit_internal_targets']; }
	
	
	if ( isset( $_POST['autoseolinks_options_delete_internal_links'] ) ) {
		$purgeInternalByDeactivation = $_POST['autoseolinks_options_delete_internal_links'];
	} else { $purgeInternalByDeactivation = 'false'; }
	
	if ( isset( $_POST['autoseolinks_options_delete_external_links'] ) ) {
		$purgeExternalByDeactivation = $_POST['autoseolinks_options_delete_external_links'];
	} else { $purgeExternalByDeactivation = 'false'; }
	
	if ( isset( $_POST['autoseolinks_options_delete_options'] ) ) {
		$purgeOptionsByDeactivation = $_POST['autoseolinks_options_delete_options'];
	} else { $purgeOptionsByDeactivation = 'false'; }
	
	/**
	 * Let's do some error handling before delivering the submitted data to the database.
	 *
	 * @since      1.0.0
	 */	
	$optionsUpdateErrors = array();
	
	if ( ctype_digit( $seoLinkLimit ) != true && $seoLinkLimit != 'false' ) {
		$optionsUpdateErrors[] = 'link-limit-error';
	}
	
	if ( ctype_digit( $internalLinkTargetLimit ) != true && $internalLinkTargetLimit != 'false' ) {
		$optionsUpdateErrors[] = 'internal-link-target-error';
	}
	
	if ( $purgeInternalByDeactivation != 'true' && $purgeInternalByDeactivation != 'false' ) {
		$optionsUpdateErrors[] = 'purge-internal-by-deactivation-error';
	}
	
	if ( $purgeExternalByDeactivation != 'true' && $purgeExternalByDeactivation != 'false' ) {
		$optionsUpdateErrors[] = 'purge-external-by-deactivation-error';
	}
	
	if ( $purgeOptionsByDeactivation != 'true' && $purgeOptionsByDeactivation != 'false' ) {
		$optionsUpdateErrors[] = 'purge-options-by-deactivation-error';
	}
	
	/**
	 * Now we're ready to push the submitted data into the database.
	 *
	 * @since      1.0.0
	 */	
	if ( !$optionsUpdateErrors ) {		
		if ( $excludedPosts ) { update_option( 'autoseolinks_options_exclude_posts', $excludedPosts ); }
		if ( $seoLinkLimit ) { update_option( 'autoseolinks_options_limit_seo_links', intval( $seoLinkLimit ) ); }
		if ( $internalLinkTargetLimit ) { update_option( 'autoseolinks_options_limit_internal_targets', intval( $internalLinkTargetLimit ) ); }
		if ( $purgeInternalByDeactivation ) { update_option( 'autoseolinks_options_delete_internal_links', $purgeInternalByDeactivation ); }
		if ( $purgeExternalByDeactivation ) { update_option( 'autoseolinks_options_delete_external_links', $purgeExternalByDeactivation ); }
		if ( $purgeOptionsByDeactivation ) { update_option( 'autoseolinks_options_delete_options', $purgeOptionsByDeactivation ); }
	}
	
} else {

	/**
	 * If no form got submitted, collect the existing data out of the database.
	 *
	 * @since      1.0.0
	 */	
	$submitType = false;
	$optionsUpdateErrors = array();
	
	$excludedPosts = get_option('autoseolinks_options_exclude_posts');
	$seoLinkLimit = get_option('autoseolinks_options_limit_seo_links');
	$internalLinkTargetLimit = get_option('autoseolinks_options_limit_internal_targets');
	$purgeInternalByDeactivation = get_option('autoseolinks_options_delete_internal_links');
	$purgeExternalByDeactivation = get_option('autoseolinks_options_delete_external_links');
	$purgeOptionsByDeactivation = get_option('autoseolinks_options_delete_options');
}

/**
 * Include options page template part.
 *
 * @since 1.0.0
 */ 
 include_once('template-parts/auto-seo-links-options.php');
?>