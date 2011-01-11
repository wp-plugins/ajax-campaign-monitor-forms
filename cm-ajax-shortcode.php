<?php



class CM_ajax_shortcode {



	private $sc_count = 1;
	private $settings = Array();



	/**
	 * PHP4 compat
	 */
	function CM_ajax_shortcode() {
		$this->__construct();
	}



	/**
	 * Constructor
	 */
	function __construct() {

		add_action ( 'init', array ( &$this, 'init' ), 1 );
		add_action ( 'init', array ( &$this, 'ajax_receiver' ), 2 );

	}



	/**
     * Actions to be run on WordPress' init() hook
     */
	function init() {

		add_shortcode ( 'cm_ajax_subscribe', array ( &$this, 'cm_ajax_subscribe' ) );

	}



	/**
	 * Parse the shortcode, and render the form
	 *
	 */
	function cm_ajax_subscribe($atts,$content=null,$code="") {

		$args = shortcode_atts( Array (
										'account_id' => '',
										'list_id' => '',
										'show_name_field' => TRUE
									  ),
								$atts);

		$this->number = 'shortcode_'.$this->sc_count++;
		$this->settings[$this->number] = $args;

		ob_start();

		if (isset($this->result)) {
			if ($this->result) {
				$success_style = '';
				$failed_style = 'style="display: none;"';
				$submit_style = 'style="display: none;"';
			} else {
				$success_style = 'style="display: none;"';
				$failed_style = '';
				$submit_style = '';
			}
		} else {
				$success_style = 'style="display: none;"';
				$failed_style = 'style="display: none;"';
				$submit_style = '';
		}

		// Main signup form
		?>
		<form method="POST" id="cm_ajax_form_<?php echo $this->number; ?>">
		<input type="hidden" name="cm_ajax_action_<?php echo $this->number; ?>" value="subscribe">
		<input type="hidden" name="cm_ajax_shortcode" value="<?php echo $this->number; ?>">
		<?php if (!isset($instance['show_name_field']) || $instance['show_name_field']) :  ?>
				<p><label for="cm-ajax-name"><?php _e('Name:', 'cm_ajax'); ?></label>
				<input class="widefat" id="cm-ajax-name" name="cm-ajax-name" type="text" /></p>
		<?php endif; ?>

		<p><label for="cm-ajax-email"><?php _e('Email:', 'cm_ajax'); ?></label>
		<input class="widefat" id="cm-ajax-email" name="cm-ajax-email" type="text" /></p>

		<p style="width: 100%; text-align: center;">
		<span <?php echo $success_style; ?> class="cm_ajax_success">Great news, we've signed you up.</span>
		<span <?php echo $failed_style; ?> class="cm_ajax_failed">Sorry, we weren't able to sign you up. Please check your details, and try again.<br/><br/></span>
		<span style="display:none;" class="cm_ajax_loading"><img alt="Loading..." src="<?php echo WP_PLUGIN_URL.'/ajax-campaign-monitor-forms/ajax-loading.gif'; ?>"></span>
		<input <?php echo $submit_style; ?> type="submit" name="cm-ajax-submit" value="<?php _e('Register', 'cm_ajax'); ?>">
		</p>
		</form>
		<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery('form#cm_ajax_form_<?php echo $this->number; ?> input:submit').click(function() {

					jQuery('form#cm_ajax_form_<?php echo $this->number; ?> input:submit').hide();
					jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_success').hide();
					jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_failed').hide();
					jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_loading').show();
					jQuery.ajax(
						{ type: 'POST',
						  data: jQuery('form#cm_ajax_form_<?php echo $this->number; ?>').serialize()+'&cm_ajax_response=ajax',
						  success: function(data) {
										jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_loading').hide();
										if (data == 'SUCCESS') {
											jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_success').show();
										} else {
											jQuery('form#cm_ajax_form_<?php echo $this->number; ?> input:submit').show();
											jQuery('form#cm_ajax_form_<?php echo $this->number; ?> .cm_ajax_failed').show();
										}
									}
						}
					);
					return false;
					});
				});
		</script>
		
		<?php

		$contents = ob_get_contents();
		ob_end_clean();

		return $contents;
	}


	/**
	 * Handle Ajax requests
	 *
	 */
	function ajax_receiver() {

		//FIXME revisit
		if ( ! isset ( $_POST['cm_ajax_shortcode'] ) )
			return;

		$number = $_POST['cm_ajax_shortcode'];

		error_log ("NUMBER: $number\n\nSETTINGS: ".print_r($this->settings,1));
		die();

		switch ( $_POST['cm_ajax_action_'.$this->number] ) {

			case 'subscribe':
				$this->subscribe();
				break;

			default:
				break;
		}

		if( isset ( $_POST['cm_ajax_response'] ) && $_POST['cm_ajax_response'] == 'ajax' ) {
			die();
		}

	}



	/**
	 * Subscribe someone to a list
	 *
	 */
	function subscribe() {

		//FIXME revisit
		$settings = $this->get_settings();

		if ( ! isset ( $settings[$this->number] ) || ! is_array ( $settings[$this->number] ) )
			return FALSE;
		else
			$settings = $settings[$this->number];

		$cm = new CS_REST_Subscribers($settings['list_api_key'], $settings['account_api_key']);

		$record = Array (
			'EmailAddress' => $_POST['cm-ajax-email'],
			'Resubscribe' => true
		);

		if ($settings['show_name_field']) {
			$record['Name'] = $_POST['cm-ajax-name'];
		}

		$result = $cm->add ( $record );
		
		if( isset ( $_POST['cm_ajax_response'] ) && $_POST['cm_ajax_response'] == 'ajax' ) {
			if ($result->was_successful()) {
				echo 'SUCCESS';
			} else {
				echo 'FAILED';
			}
		} else {
			$this->result = $result->was_successful();
		}
		return;
	}




}

$CM_ajax_shortcode = new CM_ajax_shortcode();

?>
