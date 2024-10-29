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
 * First let's check if  a form has been submitted, or not.
 *
 * @since 1.0.0
 */ 
if ( isset( $_POST['autoseolinks_submit_type'] ) ) :
	
	/**
	 * Collect all submitted data and sanitize them.
	 *
	 * @since 1.0.0
	 */ 
	$submitType = sanitize_html_class($_POST['autoseolinks_submit_type']);	
	$seoWord = sanitize_text_field($_POST['autoseolinks_link_word']);
	$autoseolinksLinkType = sanitize_html_class($_POST['autoseolinks_link_type']);
	if ( $autoseolinksLinkType == 'autoseolinks-type-internal' ) {
		$autoseolinksInternalLinkID = sanitize_html_class($_POST['autoseolinks_link_internal']);
		$autoseolinksExternalURL = false;
	} elseif ( $autoseolinksLinkType == 'autoseolinks-type-external' ) {
		$autoseolinksExternalURL = esc_url_raw($_POST['autoseolinks_link_external']);
		$autoseolinksInternalLinkID = false;
	}
	if ( isset( $_POST['autoseolinks_id'] ) ) {				
		$submittedSeoPostID = sanitize_html_class($_POST['autoseolinks_id']);
	} else {
		$submittedSeoPostID = false;
	}
	
	/**
	 * Prepare submitted data for error handling
	 *
	 * @since 1.0.0
	 */ 
	$autoseolinksErrors = array();
	switch ( $submitType ) {
		case 'autoseolinks_submit_create' :
			if ( !$seoWord || $seoWord == '' ) { $autoseolinksErrors[] = 'create_error_word'; }
			if ( !$autoseolinksLinkType || !$autoseolinksLinkType == in_array( $autoseolinksLinkType, array( 'autoseolinks-type-internal', 'autoseolinks-type-external' ) ) ) { $autoseolinksErrors[] = 'create_error_link_type'; }
			
			if ( $autoseolinksLinkType == 'autoseolinks-type-internal' && ( $autoseolinksInternalLinkID == '' || $autoseolinksInternalLinkID == 'noInternalPosts' ) ) {
				$autoseolinksErrors[] = 'create_error_internal_post';		
			} elseif ( $autoseolinksLinkType == 'autoseolinks-type-external' && $autoseolinksExternalURL == '' ) {
				$autoseolinksErrors[] = 'create_error_external_url';
			}
			break;
			
		case 'autoseolinks_submit_update' :
			if ( !$seoWord || $seoWord == '' ) { $autoseolinksErrors[] = 'update_error_word'; }
			if ( !$autoseolinksLinkType || !$autoseolinksLinkType == in_array( $autoseolinksLinkType, array( 'autoseolinks-type-internal', 'autoseolinks-type-external' ) ) ) { $autoseolinksErrors[] = 'update_error_link_type'; }
			
			if ( $autoseolinksLinkType == 'autoseolinks-type-internal' && ( $autoseolinksInternalLinkID == '' || $autoseolinksInternalLinkID == 'noInternalPosts' ) ) {
				$autoseolinksErrors[] = 'update_error_internal_post';			
			} elseif ( $autoseolinksLinkType == 'autoseolinks-type-external' && $autoseolinksExternalURL == '' ) {
				$autoseolinksErrors[] = 'update_error_external_url';
			}
			break;
			
		case 'autoseolinks_submit_delete' :
			if ( $submittedSeoPostID && get_post_type( $submittedSeoPostID ) != 'autoseolink' ) {
				$autoseolinksErrors[] = 'delete_error';
			}
			break;
	}
	
	/**
	 * Create, update or delete posts in the database.
	 *
	 * @since 1.0.0
	 */ 
	switch ( $submitType ) {
		case 'autoseolinks_submit_create' :
			if ( !$autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-internal' ) {
				$autoseolinksPostArgs = array(
					'post_title' => $seoWord,
					'post_status' => 'publish',
					'post_type' => 'autoseolink',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'meta_input' => array( 'autoseolinks_link_type' => sanitize_meta('autoseolinks_link_type', $autoseolinksLinkType, 'post'),
					'autoseolinks_internal_post_id' => sanitize_meta('autoseolinks_internal_post_id', $autoseolinksInternalLinkID, 'post') )
				);
				wp_insert_post( $autoseolinksPostArgs, false );
				
			} elseif ( !$autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-external' ) {
				$autoseolinksPostArgs = array(
					'post_title' => $seoWord,
					'post_status' => 'publish',
					'post_type' => 'autoseolink',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'meta_input' => array( 'autoseolinks_link_type' => sanitize_meta('autoseolinks_link_type', $autoseolinksLinkType, 'post'),
					'autoseolinks_link_external' => sanitize_meta('autoseolinks_link_external', $autoseolinksExternalURL, 'post') )
				);
				wp_insert_post( $autoseolinksPostArgs, false );
				
			}
			break;
		
		case 'autoseolinks_submit_update' :
			if ( !$autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-internal' ) {
				$autoseolinksPostArgs = array(
					'ID' => $submittedSeoPostID,
					'post_title' => $seoWord,
					'post_status' => 'publish',
					'post_type' => 'autoseolink',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'meta_input' => array( 'autoseolinks_link_type' => sanitize_meta('autoseolinks_link_type', $autoseolinksLinkType, 'post'), 
					'autoseolinks_internal_post_id' => sanitize_meta('autoseolinks_internal_post_id', $autoseolinksInternalLinkID, 'post') )
				);
				wp_insert_post( $autoseolinksPostArgs, false );
				
			} elseif ( !$autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-external' ) {
				$autoseolinksPostArgs = array(
					'ID' => $submittedSeoPostID,
					'post_title' => $seoWord,
					'post_status' => 'publish',
					'post_type' => 'autoseolink',
					'comment_status' => 'closed',
					'ping_status' => 'closed',
					'meta_input' => array( 'autoseolinks_link_type' => sanitize_meta('autoseolinks_link_type', $autoseolinksLinkType, 'post'),
					'autoseolinks_link_external' => sanitize_meta('autoseolinks_link_external', $autoseolinksExternalURL, 'post') )
				);
				wp_insert_post( $autoseolinksPostArgs, false );
			}
			break;
			
		case 'autoseolinks_submit_delete' :
			if ( !$autoseolinksErrors ) {
				wp_delete_post( $submittedSeoPostID, true );				
			}
			break;
	}
	 

else : // If no form has been submitted.
	
	/**
	 * Set all variables to 'false' in order to avoid PHP conflicts in the template parts.
	 *
	 * @since 1.0.0
	 */ 
	$submitType = false;
	$seoWord = false;
	$autoseolinksLinkType = false;	
	$autoseolinksInternalLinkID = false;	
	$autoseolinksExternalURL = false;	
	$submittedSeoPostID = false;
	$autoseolinksErrors = array();
	
endif;




/**
 * Pre-load query for the internal link select listing.
 *
 * Let's start with collecting all public post types and exclude the ones we don't need.
 *
 * @since 1.0.0
 */ 
$publicPostTypes = get_post_types( array('public' => true ), 'object' );
							
if ( $publicPostTypes ) {
	if ( isset( $publicPostTypes['autoseolink'] ) ) { unset( $publicPostTypes['autoseolink'] ); }
	if ( isset( $publicPostTypes['attachment'] ) ) { unset( $publicPostTypes['attachment'] ); }
}

/**
 * Store the post-type names and post objects into arrays.
 * Now we can use them in our template parts without loading from the database over and over again.
 *
 * @since 1.0.0
 */ 
$internal_post_queries = array();
$publicPostTypeName = array();
foreach ( $publicPostTypes as $publicPostType ) {
	$publicPostTypeName[] = $publicPostType->label;
	$internal_post_queries[] = new WP_Query( array( 'post_type' => $publicPostType->name, 'post_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'title'  ) );
}




/**
 * Collect data for the "Generated" column.
 *
 * Start with getting all existing SEO link entries in an array and give them a default count value of 0.
 *
 * @since 1.0.0
 */
$seoLinkEntries = new WP_Query( array( 'post_type' => 'autoseolink', 'post_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'modified' ) );
$seoLinksGenerated = array();
if ( $seoLinkEntries->have_posts() ) :
	while ( $seoLinkEntries->have_posts() ) : $seoLinkEntries->the_post();		
		$seoLinksGenerated[get_the_ID()]['title'] = get_the_title();
		$seoLinksGenerated[get_the_ID()]['type'] = get_post_meta( get_the_ID(), 'autoseolinks_link_type', true );
		$seoLinksGenerated[get_the_ID()]['internal_target'] = get_post_meta( get_the_ID(), 'autoseolinks_internal_post_id', true );
		$seoLinksGenerated[get_the_ID()]['count'] = 0;
	endwhile; wp_reset_postdata();
endif;

/**
 * Get the plugin's option values and start the loop for every published post.
 *
 * @since 1.0.0
 */
$excludedPosts = get_option('autoseolinks_options_exclude_posts');
if ( $excludedPosts && $excludedPosts != 'false' ) { 
	$excludedPosts = explode( '|', $excludedPosts );
} else {
	$excludedPosts = array();
}
$seoLinkLimit = get_option('autoseolinks_options_limit_seo_links');
$internalLinkTargetLimit = get_option('autoseolinks_options_limit_internal_targets');


foreach ( $internal_post_queries as $internal_post_query ) {
	if ( $internal_post_query->have_posts() ) :
		while ( $internal_post_query->have_posts() ) : $internal_post_query->the_post();
			$internalPostID = get_the_ID();
			$seoLinkCount = 1;
			$internalTargetCount = array();
			
			if ( !in_array( $internalPostID, $excludedPosts ) ) { // Continue only if the post / page is not excluded
				foreach ( $seoLinksGenerated as &$seoLinkGenerated ) { // loop through existing keywords
					
					
					
					$seoWordCheck = preg_match( "/". $seoLinkGenerated['title'] . "/", get_the_content() );
					
					// Conditionals for general link limit option
					if ( $seoWordCheck != false &&
						 $seoWordCheck != 0 &&
						 ($seoLinkCount <= $seoLinkLimit || $seoLinkLimit == 0 ) &&						 
						 $seoLinkGenerated['internal_target'] != $internalPostID )
					{	
						// Conditionals for internal target limit						
						if ( $seoLinkGenerated['type'] == 'autoseolinks-type-internal' ) {
							
							$internalTargets = array();
							$internalTargets = array_keys( $internalTargetCount );
							if ( !in_array( $seoLinkGenerated['internal_target'], $internalTargets ) ) {
								$i = 1;								
								$internalTargetCount[$seoLinkGenerated['internal_target']] = $i;
								if ( $internalTargetCount[$seoLinkGenerated['internal_target']] <= $internalLinkTargetLimit || $internalLinkTargetLimit == 0 ) {
									$seoLinkGenerated['count'] = $seoLinkGenerated['count'] + 1;
									$seoLinkCount++;
								}
							} else {
								$i = $internalTargetCount[$seoLinkGenerated['internal_target']];
								$i++;
								$internalTargetCount[$seoLinkGenerated['internal_target']] = $i;
								if ( $internalTargetCount[$seoLinkGenerated['internal_target']] <= $internalLinkTargetLimit  || $internalLinkTargetLimit == 0 ) {
									$seoLinkGenerated['count'] = $seoLinkGenerated['count'] + 1;
									$seoLinkCount++;
								}
							}
							
						} else {
							$seoLinkGenerated['count'] = $seoLinkGenerated['count'] + 1;
							$seoLinkCount++;
						}
					}
					
				}
			}
			unset($internalPostID);
		endwhile; wp_reset_postdata();
	endif;
}


/**
 * Last, but not least, we include the layout from our template-part files.
 *
 * @since 1.0.0
 */	
include_once('template-parts/auto-seo-link-create.php');
include_once('template-parts/auto-seo-link-list.php');
?>