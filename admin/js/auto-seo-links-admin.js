(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	
	$(document).ready(function() {
		
		/**
		 * Implementing Select2 Dropdowns
		 *
		 * @since 1.0.0
		 */ 		 
		$(".autoseolinks-select").select2();	
		
		/**
		 * SEO Link Type
		 *
		 * @since 1.0.0
		 */ 		 
		 // Prepare CSS classes on page load
		 $("select[name='autoseolinks_link_type']").each(function() {
			if ( $(this).val() == 'autoseolinks-type-internal' ) {
				if ( $(this).parent().parent().parent().hasClass('autoseolinks-type-external') ) {
					 $(this).parent().parent().parent().removeClass('autoseolinks-type-external');
				}
				$(this).parent().parent().parent().addClass('autoseolinks-type-internal');
				
			} else if ( $(this).val() == 'autoseolinks-type-external' ) {
				
				if ( $(this).parent().parent().parent().hasClass('autoseolinks-type-internal') ) {
					 $(this).parent().parent().parent().removeClass('autoseolinks-type-internal');
				}
				$(this).parent().parent().parent().addClass('autoseolinks-type-external');
			}
		 });		 
		 
		 // Change CSS classes on select box change
		 $("select[name='autoseolinks_link_type']").each(function() {
			$(this).change(function() {
				if ( $(this).val() == 'autoseolinks-type-internal' ) {
					if ( $(this).parent().parent().parent().hasClass('autoseolinks-type-external') ) {
						 $(this).parent().parent().parent().removeClass('autoseolinks-type-external');
					}
					$(this).parent().parent().parent().addClass('autoseolinks-type-internal');
					
				} else if ( $(this).val() == 'autoseolinks-type-external' ) {
					
					if ( $(this).parent().parent().parent().hasClass('autoseolinks-type-internal') ) {
						 $(this).parent().parent().parent().removeClass('autoseolinks-type-internal');
					}
					$(this).parent().parent().parent().addClass('autoseolinks-type-external');
				}
			});
		 });
		 
		/**
		 * SEO Link Filter
		 *
		 * @since 1.0.0
		 */ 		 
		 var autoseolinks_filter_value;
		 var autoseolinks_link_word;
		 $("#autoseolinks-filter-button").click(function() {
			 autoseolinks_filter_value = $(".autoseolinks-filter input#autoseolinks-filter").val();
			 
			 if ( autoseolinks_filter_value == '' ) {
				 $(".autoseolinks-link-entry.filtered").each(function() {
					 $(this).removeClass("filtered");
				 });
			 } else {
				 $(".autoseolinks-link-entry").each(function() {
					autoseolinks_link_word = $("input[name='autoseolinks_link_word']", this).val();
					if ( autoseolinks_filter_value != autoseolinks_link_word && !$(this).hasClass("filtered") ) {
						$(this).addClass("filtered");
					} else if ( autoseolinks_filter_value == autoseolinks_link_word && $(this).hasClass("filtered") ) {
						$(this).removeClass("filtered");
					}
				 });
			 }
			 
		 });
		 
		/**
		 * Disable Form Submit on Enter-key
		 *
		 * @since 1.0.0
		 */ 		 
		 $('form.autoseolinks-filter').on('keyup keypress', function(e) {
			var keyCode = e.keyCode || e.which;
			if (keyCode === 13) { 
				e.preventDefault();
				return false;
			}
		});
		
		$('.autoseolinks-table-row > form').each(function() {
			$(this).on('keyup keypress', function(e) {
				var keyCode = e.keyCode || e.which;
				if (keyCode === 13) { 
					e.preventDefault();
					return false;
				}
			});
		});
		
		/**
		 * SEO Link Delete Confirmation
		 *
		 * @since 1.0.0
		 */
		$(".table-cell-actions").each(function() {
			var seo_link_id = $("input[name='autoseolinks_id']", this).val();
			 
			$('#autoseolinks-delete-trigger-' + seo_link_id).click(function() {
				$('#autoseolinks-delete-' + seo_link_id).trigger("click");
			});
		});
		
	});
	
})( jQuery );