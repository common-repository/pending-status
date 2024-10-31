<?php

// Don't load directly
if (!defined('ABSPATH')) { exit; }

class r34ps {

	const NAME = 'Pending Status';
	public $version = '';
	
	public $function_details = array();
	
	public $default_subject = '';
	public $default_message = '';


	public function __construct() {
	
		// Set version
		$this->version = $this->_get_version();

		// Default strings
		$this->default_subject = sprintf(__('A new post is pending review on %1$s', 'pending-review'), get_bloginfo('name'));
		$this->default_message = __('A post on your website has been set to "pending review." You can review the post at the link below.', 'pending-status');
		
		// Admin page
		add_action('admin_menu', array(&$this, 'admin_page'), 10, 0);

		// Enqueue admin scripts
		add_action('admin_enqueue_scripts', array(&$this, 'admin_enqueue_scripts'), 10, 0);
		
		// Send notifications on save post
		add_action('save_post', array(&$this, 'save_post'), 10, 3);
		
		// Add dashboard widget
		add_action('wp_dashboard_setup', array(&$this, 'wp_dashboard_setup'), 10, 0);
			
	}
	
	public function admin_page() {
		add_options_page(
			__('Pending Status', 'pending-status'),
			__('Pending Status', 'pending-status'),
			'manage_options',
			'pending-status',
			array(&$this, 'admin_page_callback'),
			34
		);
	}
	
	public function admin_enqueue_scripts() {
		wp_enqueue_style('r34ps-admin-style', plugin_dir_url(__FILE__) . 'assets/admin-style.css', false, $this->version);
	}

	public function admin_page_callback() {
		// Update settings
		if (isset($_POST['r34ps-nonce']) && wp_verify_nonce($_POST['r34ps-nonce'], 'r34ps-admin')) {
			
			if (!empty($_POST['r34ps_notification_recipients'])) {
				update_option('r34ps_notification_recipients', filter_var_array($_POST['r34ps_notification_recipients'], FILTER_SANITIZE_EMAIL));
			}
			else {
				delete_option('r34ps_notification_recipients'); // Need to reset to erase options being deselected
			}

			if (!empty($_POST['r34ps_notification_subject'])) {
				update_option('r34ps_notification_subject', filter_input(INPUT_POST, 'r34ps_notification_subject', FILTER_SANITIZE_STRING));
			}
			else {
				update_option('r34ps_notification_subject', $this->default_subject);
			}

			if (!empty($_POST['r34ps_notification_message'])) {
				update_option('r34ps_notification_message', filter_input(INPUT_POST, 'r34ps_notification_message', FILTER_SANITIZE_STRING));
			}
			else {
				update_option('r34ps_notification_message', $this->default_message);
			}

			// Display admin notice
			echo '<div class="notice notice-success"><p>' . __('Settings updated.', 'pending-status') . '</p></div>';
		}
		
		// Get list of administrators and editors
		$admins_and_editors = get_users(array(
			'role__in' => array('administrator', 'editor'),
		));
		
		// Get current settings
		$r34ps_notification_recipients = get_option('r34ps_notification_recipients') ?? null;
		$r34ps_notification_subject = get_option('r34ps_notification_subject') ?? $this->default_subject;
		$r34ps_notification_message = get_option('r34ps_notification_message') ?? $this->default_message;
		
		// Load page template
		include_once(plugin_dir_path(__FILE__) . 'templates/admin/r34ps-admin.php');
	}
	
	public function save_post($post_id, $post, $update) {
		if (isset($post->post_status) && $post->post_status == 'pending') {
			// Avoid duplicate notifications
			global $r34ps_notification_sent;
			if	(
					wp_doing_ajax() ||
					wp_is_post_revision($post_id) ||
					wp_is_post_autosave($post_id) ||
					(defined('REST_REQUEST') && REST_REQUEST) ||
					did_action('save_post') > 1 ||
					did_action('save_post_' . $post->post_type) > 1
				)
			{ return; }
			// if (!current_user_can('edit_others_posts')) { // Don't send if the user is an administrator or editor
				// Get list of recipients
				if ($r34ps_notification_recipients = get_option('r34ps_notification_recipients')) {
					// Set subject and message
					$r34ps_notification_subject = get_option('r34ps_notification_subject') ?? $this->default_subject;
					$r34ps_notification_message = (get_option('r34ps_notification_message') ?? $this->default_message) . "\n\n" . get_edit_post_link($post_id);
					// Send email
					$r34ps_notification_sent = wp_mail(
						$r34ps_notification_recipients,
						html_entity_decode(filter_var($r34ps_notification_subject, FILTER_SANITIZE_STRING)),
						html_entity_decode(filter_var($r34ps_notification_message, FILTER_SANITIZE_STRING))
					);
				}
			// }
		}
	}
	
	public function wp_dashboard_setup() {
		if (current_user_can('edit_others_posts')) {
			wp_add_dashboard_widget('r34ps_dashboard_widget', __('Pending Status', 'pending-status'), 'r34ps_dashboard_widget', null, null, 'side', 'high');
		}
	}


	// Get current plugin version
	private function _get_version() {
		if (!function_exists('get_plugin_data')) {
			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
		}
		$plugin_data = get_plugin_data(dirname(__FILE__) . '/pending-status.php', false, false);
		return $plugin_data['Version'];
	}
	
		
}
