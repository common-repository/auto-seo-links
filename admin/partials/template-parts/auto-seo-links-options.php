<?php

/**
 * Provide a template part for a admin page view.
 *
 * This file is used to markup the plugin settings page.
 *
 * @link       http://unflow.io
 * @since      1.0.0
 *
 * @package    Auto_Seo_Links
 * @subpackage Auto_Seo_Links/admin/partials/template-parts
 */
 
?>

<h2><?php _e('Auto SEO Links - Options', 'auto-seo-links'); ?></h2>

<?php if ( $optionsUpdateErrors ) { ?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-warning"></span><?php _e( 'An error occured while updating the options. Please check the red high-lighted fields.', 'auto-seo-links' ); ?></p>
	</div>
<?php } elseif ( $submitType && !$optionsUpdateErrors ) { ?>
	<div class="autoseolinks-submit-notification">
		<p><span class="dashicons dashicons-yes"></span><?php _e( 'The options has been saved successfully.', 'auto-seo-links' ); ?></p>
	</div>
<?php } ?>

<form action="" method="post">
	<table class="form-table autoseolinks-options-table">
		
		<?php
		/**
		 * Multi-Select Menu for excluded posts / pages.
		 *
		 * @since 1.0.0
		 */
		?>
		<tr>
			<th scope="row" valign="top" style="vertical-align: top;">
				<label for="autoseolinks_options_exclude_posts"><?php _e('Exclude Posts / Pages', 'auto-seo-links'); ?></label><br />
				<span style="font-weight: 400; font-size: 0.75em;"><?php _e("Choose posts / pages where you don't want your SEO links to show up.", 'auto-seo-links'); ?></span>
			</th>
			<td style="vertical-align: top;">
				
				<select name="autoseolinks_options_exclude_posts[]" class="autoseolinks-select" style="width: 25em;" multiple="multiple">
					<?php						
						/**
						 * Here we need to query all published posts and place them (ordered by post type) in a Select2.js dropdown.
						 * 
						 * Let's start with gathering all existing post types from this system and exclude the ones we don't need.
						 * 
						 * @since 1.0.0
						 */				
						$publicPostTypes = get_post_types( array('public' => true ), 'object' );
						
						if ( $publicPostTypes ) {
							if ( isset( $publicPostTypes['autoseolinks_link'] ) ) { unset( $publicPostTypes['autoseolinks_link'] ); }
							if ( isset( $publicPostTypes['attachment'] ) ) { unset( $publicPostTypes['attachment'] ); }
						}						
						
						/**
						 * Now that we got all available post types, let's query through every single one to get the posts and build the select options
						 * 
						 * @since 1.0.0
						 */	
						if ( isset( $excludedPosts ) ) {
							$excludedPosts = explode( '|', $excludedPosts );
						}						
						foreach ( $publicPostTypes as $publicPostType ) {
							
							$internal_post_query = new WP_Query( array( 'post_type' => $publicPostType->name, 'post_per_page' => -1, 'post_status' => 'publish' ) );
								if ( $internal_post_query->have_posts() ) :
					?>
								<optgroup label="<?php echo $publicPostType->label; ?>">
					<?php while ( $internal_post_query->have_posts() ) : $internal_post_query->the_post(); ?>
									<option value="<?php the_ID(); ?>"<?php
										if ( $excludedPosts && in_array( get_the_ID(), $excludedPosts ) ) {											
											?> selected<?php										
										} ?>><?php the_title();
									?></option>
					<?php endwhile; wp_reset_postdata(); ?>
								</optgroup>
					<?php endif;
						}
					?>
				</select>				
			</td>
		</tr>
		
		<?php
		/**
		 * Input field for numbers to set a general SEO link limit per page.
		 *
		 * @since 1.0.0
		 */
		?>
		<tr>
			<th scope="row" valign="top" style="vertical-align: top;">
				<label for="autoseolinks_options_limit_seo_links"><?php _e('Maximum SEO Links', 'auto-seo-links'); ?></label><br />
				<span style="font-weight: 400; font-size: 0.75em;"><?php _e('Limit the number of SEO links on one single post / page (&nbsp;0&nbsp;=&nbsp;unlimited&nbsp;).', 'auto-seo-links'); ?></span>
			</th>
			<td style="vertical-align: top;">
				<input type="number" name="autoseolinks_options_limit_seo_links" min="0" step="1" value="<?php echo intval( $seoLinkLimit ); ?>"<?php
					if ( in_array( 'link-limit-error', $optionsUpdateErrors ) ) {
						?> class="autoseolinks-options-error"<?php
					} ?>>
			</td>
		</tr>
		
		<?php
		/**
		 * Input field for numbers to set a SEO link limit per page which lead to the same internal destination.
		 *
		 * @since 1.0.0
		 */
		?>
		<tr>
			<th scope="row" valign="top" style="vertical-align: top;">
				<label for="autoseolinks_options_limit_internal_targets"><?php _e('Maximum Internal Linkings', 'auto-seo-links'); ?></label><br />
				<span style="font-weight: 400; font-size: 0.75em;"><?php _e('Limit the number of SEO links that target the same internal destination (&nbsp;0&nbsp;=&nbsp;unlimited&nbsp;).', 'auto-seo-links'); ?></span>
			</th>
			<td style="vertical-align: top;">
				<input type="number" name="autoseolinks_options_limit_internal_targets" min="0" step="1" value="<?php echo intval( $internalLinkTargetLimit ); ?>"<?php
					if ( in_array( 'internal-link-target-error', $optionsUpdateErrors ) ) {
						?> class="autoseolinks-options-error"<?php
					} ?>>
			</td>
		</tr>
		
		<?php
		/**
		 * Purge options on plugin deactivation / deletion to clean the database from plugin related data.
		 *
		 * @since 1.0.0
		 */
		?>
		<tr>
			<th scope="row" valign="top" style="vertical-align: top;">
				<label><?php
					if ( is_multisite() ) {
						_e('Tidy Up After Plugin Deactivation', 'auto-seo-links');
					} else {
						_e('Tidy Up After Plugin Deletion', 'auto-seo-links');
					} ?></label><br />
				<span style="font-weight: 400; font-size: 0.75em;"><?php 
					if ( is_multisite() ) {
						_e('Choose if you want to clear the database from plugin data once the plugin got deactivated.<br /><strong style="color: #ff0000; font-style: italic;">Once deleted, the data will be lost!</strong>', 'auto-seo-links'); 
					} else { 
						_e('Choose if you want to clear the database from plugin data once the plugin got deleted.<br /><strong style="color: #ff0000; font-style: italic;">Once deleted, the data will be lost!</strong>', 'auto-seo-links');
						
					} ?></span>
			</th>
			<td style="vertical-align: top;">
				<input type="checkbox" name="autoseolinks_options_delete_internal_links" value="true"<?php if ( $purgeInternalByDeactivation == 'true' ) { ?> checked="checked"<?php } 
					if ( in_array( 'purge-internal-by-deactivation-error', $optionsUpdateErrors ) ) {
							?> class="autoseolinks-options-error"<?php
					} ?>>
				<span><?php _e('<strong>Internal SEO links</strong> - Delete all SEO link entries with an internal link type.', 'auto-seo-links'); ?></span>
				<br />
				<br />
				<input type="checkbox" name="autoseolinks_options_delete_external_links" value="true"<?php if ( $purgeExternalByDeactivation == 'true' ) { ?> checked="checked"<?php } 
					if ( in_array( 'purge-external-by-deactivation-error', $optionsUpdateErrors ) ) {
							?> class="autoseolinks-options-error"<?php
					} ?>>
				<span><?php _e('<strong>External SEO links</strong> - Delete all SEO link entries with an external link type.', 'auto-seo-links'); ?></span>
				<br />
				<br />
				<input type="checkbox" name="autoseolinks_options_delete_options" value="true"<?php if ( $purgeOptionsByDeactivation == 'true' ) { ?> checked="checked"<?php } 
					if ( in_array( 'purge-options-by-deactivation-error', $optionsUpdateErrors ) ) {
							?> class="autoseolinks-options-error"<?php
					} ?>>
				<span><?php _e('<strong>Plugin Settings</strong> - Delete all option configuration.', 'auto-seo-links'); ?></span>
					
			</td>
		</tr>
	</table>
	
	<input type="hidden" name="autoseolinks_submit_type" value="options_submit">
	<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Save changes', 'auto-seo-links'); ?>"></p>
</form>