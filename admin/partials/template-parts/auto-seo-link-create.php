<?php

/**
 * Provide a template part for a admin page view.
 *
 * This file is used to markup the SEO link creation form after it has been submitted.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin/partials/template-parts
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php
/**
 * Enable jQuery UI Tooltips on this admin page.
 *
 * @since 1.0.0
 */
?>
<script>
	jQuery( function() {
		jQuery( ".tooltip" ).tooltip({
			track: true,
			content: function () {
				return jQuery(this).prop('title');
			}
		});
	});
</script>

<h2><?php _e('Add New SEO Link', 'auto-seo-links'); ?></h2>

<?php	
	/**
	 * Output submit notification about successful or unsuccessful SEO link creation.
	 *
	 * @since 1.0.0
	 */
	if ( $submitType == 'autoseolinks_submit_create' && $autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-warning"></span><?php _e( 'An error occured while creating the SEO link. Please check the red high-lighted fields.', 'auto-seo-links' ); ?></p>
	</div>
	
<?php
	} elseif ( $submitType == 'autoseolinks_submit_create' && !$autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-yes"></span><?php _e( 'The SEO link has been added successfully.', 'auto-seo-links' ); ?></p>
	</div>
	
<?php }

	/**
	 * The SEO link creation form table.
	 *
	 * @since 1.0.0
	 */
?>
<div class="autoseolinks-responsive-table">
	<div class="autoseolinks-table link-create-table">
	
		<!-- TABLE HEADLINE -->
		<div class="autoseolinks-table-row">
			<div class="autoseolinks-table-head"><span>&nbsp;</span></div>
			<div class="autoseolinks-table-head">
				<span class="tooltip" title="<?php _e('The SEO keyword which will be replaced with the appropriate link.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Word', 'auto-seo-links'); ?></span> <span class="required">*</span>
			</div>
			<div class="autoseolinks-table-head">
				<span class="tooltip" title="<?php _e('Choose the link destination type:<br /><br /><strong>Internal Post</strong> - Select a single post or page from a list of all available posts / pages in your WordPress system.<br /><br /><strong>External URL</strong> - Type in a custom URL which will be opened in a new browser tab.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Type', 'auto-seo-links'); ?></span> <span class="required">*</span>
			</div>
			<div class="autoseolinks-table-head">
				<span class="tooltip" title="<?php _e('Provide a target where your link should lead to.<br /><br /><strong>Internal Link</strong> - Choose a post / page from the list.<br /><br /><strong>External URL</strong> - Type in an external URL.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Link Target', 'auto-seo-links'); ?></span> <span class="required">*</span>
			</div>
			<div class="autoseolinks-table-head">
				<span class="tooltip" title="<?php _e('After you filled all the previous fields, hit the icon to create your SEO link entry.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Action', 'auto-seo-links'); ?></span>
			</div>
			<div class="autoseolinks-table-head"><span>&nbsp;</span></div>
		</div>
	
		<!-- TABLE CONTENT -->
		<div class="autoseolinks-table-row autoseolinks-type-internal">
			<form action="" method="post">
				<div class="autoseolinks-table-cell"><span>&nbsp;</span></div>
				
				<?php			
					/**
					 * The SEO keyword. Nothing special, just a text input field.
					 * 
					 * @since 1.0.0
					 */				
				?>			
				<div class="autoseolinks-table-cell<?php if ( in_array( 'create_error_word', $autoseolinksErrors, false ) ) { ?> autoseolinksError<?php } ?>">
					<input type="text" name="autoseolinks_link_word" value="<?php if ( $autoseolinksErrors ) { echo sanitize_text_field($seoWord); } ?>">
				</div>
				
				<?php			
					/**
					 * Pre-selection of link-type. No dynamic stuff necessary since there're just these two types.
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell<?php if ( in_array( 'create_error_link_type', $autoseolinksErrors, false ) ) { ?> autoseolinksError<?php } ?>">
					<select name="autoseolinks_link_type">
						<option value="autoseolinks-type-internal"<?php if ( $autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-internal' ) { ?> selected<?php } ?>><?php _e('Internal Post', 'auto-seo-links' ); ?></option>
						<option value="autoseolinks-type-external"<?php if ( $autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-external' ) { ?> selected<?php } ?>><?php _e('External URL', 'auto-seo-links' ); ?></option>
					</select>
				</div>
				
				<?php			
					/**
					 * Link Target - Internal Link Selection and External URL field are now merged in one column.
					 * 
					 * @since 1.0.0
					 */				
				?>		
				<div class="autoseolinks-table-cell<?php if ( in_array( 'create_error_internal_post', $autoseolinksErrors, false ) || in_array( 'create_error_external_url', $autoseolinksErrors, false ) ) { ?> autoseolinksError<?php } ?>">
					
					<?php			
						/**
						 * Select Box for Internal Link Target.
						 * 
						 * @since 1.0.0
						 */				
					?>
					<select name="autoseolinks_link_internal" class="autoseolinks-select">
						<?php
							/**
							 * Build the select box out of the post / page query we did before
							 * 
							 * @since 1.0.0
							 */							
							$internalLinkPostCount = 0;
							$i = 0;
							foreach ( $internal_post_queries as $internal_post_query ) {
								if ( $internal_post_query->have_posts() ) :
						?>
									<optgroup label="<?php echo $publicPostTypeName[$i]; ?>">
						<?php while ( $internal_post_query->have_posts() ) : $internal_post_query->the_post(); $internalLinkPostCount++; ?>
										<option value="<?php the_ID(); ?>"<?php if ( $submitType == 'autoseolinks_submit_create' && $autoseolinksErrors && $autoseolinksLinkType == 'autoseolinks-type-internal' && $autoseolinksInternalLinkID == get_the_ID() ) { ?> selected<?php } ?>><?php the_title(); ?></option>
						<?php endwhile; wp_reset_postdata(); ?>
									</optgroup>
						<?php endif;
								$i++;
							}
							
							/**
							 * Output a "No posts available" message if there're no public post types in the system or the internal link counter is equal 0
							 * 
							 * @since 1.0.0
							 */							 
							if ( !$publicPostTypes || $internalLinkPostCount == 0 ) {
						?>
								<option value="noInternalPosts"><?php _e('No posts available', 'auto-seo-links' ); ?></option>
						<?php } ?>
					</select>
					<!--<span class="hidden-placeholder-internal">&nbsp;</span>-->
					
					<?php			
						/**
						 * Text input field for external URLs.
						 * 
						 * @since 1.0.0
						 */				
					?>
					<input type="url" name="autoseolinks_link_external" value="<?php if ( $autoseolinksErrors && $autoseolinksExternalURL ) { echo esc_url_raw($autoseolinksExternalURL); } ?>" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-ZäöüÄÖÜ0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$" placeholder="<?php _e('http://example.com', 'auto-seo-links'); ?>">
				</div>
	
				<?php			
					/**
					 * Submit button to fire the form and creating a brand-new SEO link.
					 * 
					 * @since 1.0.0
					 */				
				?>			
				<div class="autoseolinks-table-cell">
					<button name="autoseolinks_submit_type" type="submit" class="autoseolinks-submit" value="autoseolinks_submit_create" title="<?php _e('Create this entry', 'auto-seo-links'); ?>"><span class="dashicons dashicons-welcome-add-page"></span></button>
				</div>
				
				<div class="autoseolinks-table-cell"><span>&nbsp;</span></div>
			</form>
		</div>
		
	</div>
</div>

<br /><br /><br />