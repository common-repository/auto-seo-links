<?php

/**
 * Provide a template part for a admin page view.
 *
 * This file is used to markup the SEO link list.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin/partials/template-parts
 */
?>

<h2><?php _e('SEO Links', 'auto-seo-links'); ?></h2>

<?php
	/**
	 * Let's query the existing SEO links and store them in a variable.
	 *
	 * We need to do that here already because we need that query at two different locations:
	 * - The search function (for the auto-complete feature)
	 * - The SEO link list itself
	 * 
	 * @since 1.0.0
	 */	
	$autoseolinks_link_query = new WP_Query( array( 'post_type' => 'autoseolink', 'post_per_page' => -1, 'post_status' => 'publish', 'orderby' => 'modified'  ) );
	
	/**	 
	 * Show search function if there're published SEO links.
	 * 
	 * @since 1.0.0
	 */	
	if ( $autoseolinks_link_query->have_posts() ) :
	
?>
<form class="autoseolinks-filter">
	<script>
		jQuery( function() {
			var availableTags = [			
				<?php 
					$autoseolinksFilterCount = 0;
					
					while ( $autoseolinks_link_query->have_posts() ) : $autoseolinks_link_query->the_post();
						$autoseolinksFilterCount++;
						
						if ( $autoseolinksFilterCount == 1 ) {
							echo '"' . get_the_title() . '"';
						} else {
							echo ', "' . get_the_title() . '"';
						}
					endwhile; wp_reset_postdata();
				?>
			];
			jQuery( "#autoseolinks-filter" ).autocomplete({
				source: availableTags
			});
		} );
	</script>

	<input type="text" id="autoseolinks-filter" placeholder="<?php _e( 'Search SEO Link', 'auto-seo-links' ); ?>">
	<button type="button" id="autoseolinks-filter-button"><?php _e( 'Search', 'auto-seo-links' ); ?></button>
</form>
<?php endif;

	/**
	 * Output submit notification about successful or unsuccessful SEO link creation.
	 *
	 * @since 1.0.0
	 */
	if ( $submitType == 'autoseolinks_submit_update' && $autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-warning"></span><?php _e( 'An error occured while updating the SEO link. Please check the red high-lighted fields.', 'auto-seo-links' ); ?> <a href="#autoseolinks-post-<?php echo sanitize_html_class($submittedSeoPostID); ?>"><span class="dashicons dashicons-admin-links"></span></a></p>
	</div>
	
<?php
	} elseif ( $submitType == 'autoseolinks_submit_update' && !$autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-yes"></span><?php _e( 'The SEO link has been updated successfully.', 'auto-seo-links' ); ?></p>
	</div>
	
<?php
	} elseif ( $submitType == 'autoseolinks_submit_delete' && $autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-warning"></span><?php _e( 'An error occured while deleting the SEO link. Please try again later.', 'auto-seo-links' ); ?></p>
	</div>

<?php
	} elseif ( $submitType == 'autoseolinks_submit_delete' && !$autoseolinksErrors ) {
?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-yes"></span><?php _e( 'The SEO link has been deleted successfully.', 'auto-seo-links' ); ?></p>
	</div>
<?php
	}
	
	/**	 
	 * Here comes the SEO link list table.
	 * 
	 * @since 1.0.0
	 */	
?>
<div class="autoseolinks-responsive-table">
	<div class="autoseolinks-table link-list-table">	
		
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
				<span class="tooltip" title="<?php _e('After you changed all the previous fields as desired, hit the refresh icon to update your SEO link entry, or hit the trash icon to delete the entry.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Action', 'auto-seo-links'); ?></span>
			</div>
			<div class="autoseolinks-table-head">
				<span class="tooltip" title="<?php _e('Calculates an estimated number of how often this SEO keyword will be turned into a link on your whole WordPress website.', 'auto-seo-links'); ?>">?</span>
				<span><?php _e('Generated', 'auto-seo-links'); ?></span>
			</div>
		</div>
		
		<?php
			/**
			 * Start the loop to output every published SEO link.
			 * Store the post ID of every SEO link entry into a variable because we can't use the_ID() or get_the_ID() later
			 * due to other WP Queries we're going to run inside this query.
			 * 
			 * @since 1.0.0
			 */	
			if ( $autoseolinks_link_query->have_posts() ) :
				$autoseolinksRowCount = 0;
				while ( $autoseolinks_link_query->have_posts() ) : $autoseolinks_link_query->the_post();
					$autoseolinksSingleLinkID = get_the_ID();
					$autoseolinksSingleInternalLinkID = get_post_meta( $autoseolinksSingleLinkID, 'autoseolinks_internal_post_id', true );
					$autoseolinksSingleTitle = get_the_title();
					$generatedLinkCount = 0;
					if ( $autoseolinksSingleLinkID == $submittedSeoPostID ) {
						$modifyThisEntry = true;
					} else {
						$modifyThisEntry = false;
					}
		?>
	
		<div class="autoseolinks-table-row autoseolinks-link-entry">
			<?php if ( isset($submitType) && $submitType == 'autoseolinks_submit_update' && $autoseolinksErrors ) { ?><a name="autoseolinks-post-<?php echo sanitize_html_class($submittedSeoPostID); ?>"></a><?php } ?>
			<form action="" method="post">
				
				<?php
					/**
					 * A simple row count.
					 * 
					 * @since 1.0.0
					 */	
				?>
				<div class="autoseolinks-table-cell">
					<span>
						<?php 						
							$autoseolinksRowCount++; echo $autoseolinksRowCount;
						?>
					</span>
				</div>
				
				<?php			
					/**
					 * The SEO keyword.
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell<?php if ( in_array( 'update_error_word', $autoseolinksErrors, false ) && $modifyThisEntry ) { ?> autoseolinksError<?php } ?>">
					<input type="text" name="autoseolinks_link_word" value="<?php
							if ( in_array( 'update_error_word', $autoseolinksErrors, false ) && $modifyThisEntry ) {
								echo sanitize_text_field($seoWord);
							} else { the_title(); }
						?>">
				</div>
				
				<?php			
					/**
					 * Pre-selection of link-type. No dynamic stuff necessary since there're just these two types.
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell<?php if ( in_array( 'update_error_link_type', $autoseolinksErrors, false ) && $modifyThisEntry ) { ?> autoseolinksError<?php } ?>">
					<select name="autoseolinks_link_type">
						<?php $autoseolinksSingleLinkType = get_post_meta( $autoseolinksSingleLinkID, 'autoseolinks_link_type', true ); ?>
						<option value="autoseolinks-type-internal"<?php if ( $autoseolinksSingleLinkType == 'autoseolinks-type-internal' ) { ?> selected<?php } ?>
						><?php _e('Internal Post', 'auto-seo-links' ); ?></option>
						<option value="autoseolinks-type-external"<?php if ( $autoseolinksSingleLinkType == 'autoseolinks-type-external' ) { ?> selected<?php } ?>><?php _e('External URL', 'auto-seo-links' ); ?></option>
					</select>
				</div>
				
				<?php			
					/**
					 * Link Target - Internal Link Selection and External URL field are now merged in one column.
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell<?php if ( ( in_array( 'update_error_internal_post', $autoseolinksErrors, false ) || in_array( 'update_error_external_url', $autoseolinksErrors, false ) ) && $modifyThisEntry ) { ?> autoseolinksError<?php } ?>">
					
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
										<option value="<?php the_ID(); ?>"<?php 
											if ( $submitType == 'autoseolinks_submit_update' && $autoseolinksErrors && $modifyThisEntry && $autoseolinksInternalLinkID == get_the_ID() ) { ?> selected<?php
											} elseif ( get_the_ID() == $autoseolinksSingleInternalLinkID ) { ?> selected<?php } ?>><?php the_title(); ?></option>
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
					
					<?php			
						/**
						 * Text input field for external URLs.
						 * 
						 * @since 1.0.0
						 */				
					?>
					<input type="url" name="autoseolinks_link_external" pattern="^(https?://)?([a-zA-Z0-9]([a-zA-ZäöüÄÖÜ0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,6}$" value="<?php
						if ( in_array( 'update_error_external_url', $autoseolinksErrors, false ) && $modifyThisEntry ) {
								echo esc_url_raw($autoseolinksExternalURL);
							} else {
								echo get_post_meta( $autoseolinksSingleLinkID, 'autoseolinks_link_external', true );
							} ?>" placeholder="<?php _e('http://example.com', 'auto-seo-links'); ?>">
				</div>
				
				<?php			
					/**
					 * Submit area with buttons for different actions.
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell table-cell-actions">
					<input type="hidden" name="autoseolinks_id" value="<?php echo $autoseolinksSingleLinkID; ?>">
					<button name="autoseolinks_submit_type" type="submit" class="autoseolinks-submit" value="autoseolinks_submit_update" title="<?php _e('Update this entry', 'auto-seo-links'); ?>"><span class="dashicons dashicons-update"></span></button>
					
					<?php add_thickbox(); ?>
					<div id="autoseolinks-delete-link-<?php echo $autoseolinksSingleLinkID; ?>" style="display:none;">					 
						 <p style="text-align: center;">
							  <?php _e('Do you really want delete this entry?', 'auto-seo-links'); ?>
							  <br /><br />
							  <span id="autoseolinks-delete-trigger-<?php echo $autoseolinksSingleLinkID; ?>" style="border: none; background: #ff0000; color: #fff; padding: 6px 12px; font-weight: bold; cursor: pointer;">
								<span class="dashicons dashicons-trash" style="font-size: 1.45em;"></span> <?php _e('Yes, delete this entry!', 'auto-seo-links'); ?>
							  </span>						  
						 </p>
					</div>
					
					<a href="#TB_inline?width=300&height=200&inlineId=autoseolinks-delete-link-<?php echo $autoseolinksSingleLinkID; ?>" class="autoseolinks-submit thickbox" title="<?php _e('Delete this entry?', 'auto-seo-links'); ?>"><span class="dashicons dashicons-trash"></span></a>
					
					<button id="autoseolinks-delete-<?php echo $autoseolinksSingleLinkID; ?>" name="autoseolinks_submit_type" type="submit" value="autoseolinks_submit_delete" class="autoseolinks-hidden-delete-button"></button>
				</div>
				
				<?php			
					/**
					 * Counter of created links
					 * 
					 * @since 1.0.0
					 */				
				?>
				<div class="autoseolinks-table-cell">
					<span><?php echo $seoLinksGenerated[$autoseolinksSingleLinkID]['count'] ?></span>				
				</div>
			</form>
		</div>
	
		<?php
				endwhile; wp_reset_postdata();
			else :
		?>
	
		<div class="autoseolinks-table-row empty">
			<p><?php _e( "There're no entries, yet. Please submit one!", 'auto-seo-links' ); ?></p>
		</div>
	
		<?php endif; ?>
	</div>
</div>