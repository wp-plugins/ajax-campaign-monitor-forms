<html>
<head>
<?php wp_head(); ?>
<script type="text/javascript" src="<?php echo site_url().'/wp-includes/js/tinymce/tiny_mce_popup.js'; ?>"></script>
</head>

<body>
	<form id="cm_ajax_tinymce_subscriber" action="" method="post">

		<input type="hidden" name="cm_ajax_response" value="ajax">
		<input type="hidden" name="cm_ajax_shortcode" value="1">
		<input type="hidden" name="cm_ajax_shortcode_action" value="generateshortcode">
		<?php echo wp_nonce_field('cm_ajax_generate_shortcode'); ?>
	
		<p>Enter your API key and the List ID below, and hit "Add Shortcode" to add the shortcode to your post</p>
	
		<p><label for="cm_ajax_tinymce_subscriber_account_api_key">Account API Key:</label><br/>
		<input class="widefat" id="cm_ajax_tinymce_subscriber_account_api_key" name="cm_ajax_tinymce_subscriber_account_api_key" size="32" type="text" /></p>
	
		<p><label for="cm_ajax_tinymce_subscriber_list_api_key">List API Key</label><br/>
		<input class="widefat" id="cm_ajax_tinymce_subscriber_list_api_key" name="cm_ajax_tinymce_subscriber_list_api_key" size="32" type="text"  /></p>
	
		<p><label for="cm_ajax_tinymce_subscriber_show_name_field">Show name field</label><br/>
		<input id="cm_ajax_tinymce_subscriber_show_name_field" name="cm_ajax_tinymce_subscriber_show_name_field" type="checkbox" checked=checked /></p>
	
		<input type="submit" name="Add Shortcode" value="Add Shortcode">
		<span style="display:none;" class="cm_ajax_loading"><img alt="Loading..." src="<?php echo WP_PLUGIN_URL.'/ajax-campaign-monitor-forms/ajax-loading.gif'; ?>"></span>
	
	</form>
	<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('form#cm_ajax_tinymce_subscriber input:submit').click(function() {

				jQuery('form#cm_ajax_tinymce_subscriber input:submit').hide();
				jQuery('form#cm_ajax_tinymce_subscriber .cm_ajax_loading').show();
				jQuery.ajax(
					{ type: 'POST',
					  url: '<?php echo get_admin_url(); ?>',
					  data: jQuery('form#cm_ajax_tinymce_subscriber').serialize()+'&cm_ajax_response=ajax',
					  success: function(data) {
						jQuery('form#cm_ajax_tinymce_subscriber .cm_ajax_loading').hide();
						var shortcode = '[cm_ajax_subscribe id='+data+']';
						tinyMCEPopup.execCommand("mceInsertContent", false, shortcode);
						tinyMCEPopup.close();
					  }
					}
				);
				return false;
				});
			});
	</script>
	</body>
</html>
