<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/public
 * @author     Arvid Schmeling <info@arvid-schmeling.de>
 */
class Auto_Seo_Links_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/auto-seo-links-public.min.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/auto-seo-links-public.min.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Replace keywords on the frontend with SEO links from the backend.
	 *
	 * @since    1.0.0
	 */
	
	public function filter_content_seo( $content ) {
		
		// Get Plugin options
		$excludedPosts = get_option('autoseolinks_options_exclude_posts');
		if ( $excludedPosts && $excludedPosts != 'false' ) { 
			$excludedPosts = explode( '|', $excludedPosts );
		} else {
			$excludedPosts = array();
		}
		$seoLinkLimit = sanitize_html_class( get_option('autoseolinks_options_limit_seo_links') );
		$seoLinkCount = 0;
		$internalLinkTargetLimit = sanitize_html_class( get_option('autoseolinks_options_limit_internal_targets') );
		
		// Get all SEO link entries
		$autoseolinksQuery = new WP_Query( array( 'post_type' => 'autoseolink', 'post_per_page' => -1, 'post_status' => 'publish' ) );		
		
		// Do the filter stuff
		$thisPostID = get_the_ID();
		if ( $autoseolinksQuery->have_posts() && !in_array( $thisPostID, $excludedPosts ) ) :
			global $post;
			$currentPermalink = get_permalink( $post->ID );
			$autoseolinksInternalTargetCount = array();			
			while ( $autoseolinksQuery->have_posts() ) : $autoseolinksQuery->the_post();
				$autoseolinksTitle = sanitize_text_field( get_the_title() );
				$autoseolinksType = sanitize_meta('autoseolinks_link_type', get_post_meta( get_the_ID(), 'autoseolinks_link_type', true ), 'post');				
				
				// Do the filter stuff for internal links
				if ( $autoseolinksType == 'autoseolinks-type-internal' ) {
					$autoseolinksInternalID = sanitize_meta('autoseolinks_internal_post_id', get_post_meta( get_the_ID(), 'autoseolinks_internal_post_id', true ), 'post');
					$autoseolinksInternalURL = get_permalink( $autoseolinksInternalID );
					
					
					// Deal with the limit SEO links option
					if ( $autoseolinksInternalURL != $currentPermalink && $seoLinkLimit > 0 && $seoLinkCount < $seoLinkLimit  ) {						
						
						// Deal with the limit internal target links option
						if ( !in_array( $autoseolinksInternalID, $autoseolinksInternalTargetCount ) ) {
							$i = 1;
							$autoseolinksInternalTargetCount[] = $autoseolinksInternalID;
							$autoseolinksInternalTargetCount[$autoseolinksInternalID][] = $i;							
							if ( $autoseolinksInternalTargetCount[$autoseolinksInternalID][0] <= $internalLinkTargetLimit || $internalLinkTargetLimit == 0 ) {
								$seoLinkCount++;
								$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksInternalURL . '" target="_self">' . $autoseolinksTitle . '</a>', $content, 1 );
							}
							
						} else {
							$i = $autoseolinksInternalTargetCount[$autoseolinksInternalID][0];
							$i++;
							$autoseolinksInternalTargetCount[$autoseolinksInternalID][0] = $i;							
							if ( $autoseolinksInternalTargetCount[$autoseolinksInternalID][0] <= $internalLinkTargetLimit || $internalLinkTargetLimit == 0 ) {
								$seoLinkCount++;
								$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksInternalURL . '" target="_self">' . $autoseolinksTitle . '</a>', $content, 1 );
							}
						}
						
					
					// If SEO link limit is 0
					} elseif ( $autoseolinksInternalURL != $currentPermalink && $seoLinkLimit == 0 ) {
						
						// Deal with the limit internal target links option
						if ( !in_array( $autoseolinksInternalID, $autoseolinksInternalTargetCount ) ) {
							$i = 1;
							$autoseolinksInternalTargetCount[] = $autoseolinksInternalID;
							$autoseolinksInternalTargetCount[$autoseolinksInternalID][] = $i;							
							if ( $autoseolinksInternalTargetCount[$autoseolinksInternalID][0] <= $internalLinkTargetLimit || $internalLinkTargetLimit == 0 ) {								
								$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksInternalURL . '" target="_self">' . $autoseolinksTitle . '</a>', $content, 1 );
							}
							
						} else {
							$i = $autoseolinksInternalTargetCount[$autoseolinksInternalID][0];
							$i++;
							$autoseolinksInternalTargetCount[$autoseolinksInternalID][0] = $i;							
							if ( $autoseolinksInternalTargetCount[$autoseolinksInternalID][0] <= $internalLinkTargetLimit || $internalLinkTargetLimit == 0 ) {								
								$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksInternalURL . '" target="_self">' . $autoseolinksTitle . '</a>', $content, 1 );
							}
						}
					}
				
				// Do the filter stuff for external links
				} elseif ( $autoseolinksType == 'autoseolinks-type-external' ) {
					$autoseolinksExternalURL = esc_url_raw( get_post_meta( get_the_ID(), 'autoseolinks_link_external', true ) );
					
					if ( $autoseolinksExternalURL != $currentPermalink && $seoLinkLimit > 0 && $seoLinkCount < $seoLinkLimit ) {
						$seoLinkCount++;						
						$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksExternalURL . '" target="_blank">' . $autoseolinksTitle . '</a>', $content, 1 );
						
					} elseif ( $autoseolinksExternalURL != $currentPermalink && $seoLinkLimit == 0 ) {
						$content = preg_replace( "/" . $autoseolinksTitle . "/", '<a href="' . $autoseolinksExternalURL . '" target="_blank">' . $autoseolinksTitle . '</a>', $content, 1 );
					}
					
				}
				
			endwhile; wp_reset_postdata();
			return $content;
		else :
			return $content;
		endif;
	}

}
