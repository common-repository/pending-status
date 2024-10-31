<?php
/*
Plugin Name: Pending Status
Plugin URI: https://room34.com
Description: Get notified when your site has posts pending review.
Version: 1.0.3
Author: Room 34 Creative Services, LLC
Author URI: http://room34.com
License: GPLv2
Text Domain: pending-status
Domain Path: /i18n/languages/
*/

/*  Copyright 2024 Room 34 Creative Services, LLC (email: info@room34.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


// Don't load directly
if (!defined('ABSPATH')) { exit; }


// Load required files
require_once(plugin_dir_path(__FILE__) . 'functions.php');
require_once(plugin_dir_path(__FILE__) . 'class-pending-status.php');


// Initialize plugin functionality
function r34ps_plugins_loaded() {

	// Instantiate class
	global $r34ps;
	$r34ps = new r34ps();
	
	// Conditionally run update function
	if (is_admin() && version_compare(get_option('r34ps_version'), $r34ps->version, '<')) { r34ps_update(); }
	
}
add_action('plugins_loaded', 'r34ps_plugins_loaded');


// Install
function r34ps_install() {
	global $r34ps;

	// Flush rewrite rules
	flush_rewrite_rules();
	
	// Remember previous version
	$previous_version = get_option('r34ps_version');
	update_option('r34ps_previous_version', $previous_version);
	
	// Set version
	if (isset($r34ps->version)) {
		update_option('r34ps_version', $r34ps->version);
	}

	// Admin notice with link to settings
	$notices = get_option('r34ps_deferred_admin_notices', array());
	$notices[] = array(
		'content' => '<p>' . sprintf(__('Thank you for installing %1$sPending Status%2$s. If you would like to set up email notifications for pending posts, please visit the %3$sSettings%4$s page.'), '<strong>', '</strong>', '<a href="' . admin_url('options-general.php?page=pending-status') . '"><strong>', '</strong></a>') . '</p>',
		'status' => 'info'
	);
	update_option('r34ps_deferred_admin_notices', $notices);
	
}
register_activation_hook(__FILE__, 'r34ps_install');


// Updates
function r34ps_update() {
	global $r34ps;
	
	// Remember previous version
	$previous_version = get_option('r34ps_version');
	update_option('r34ps_previous_version', $previous_version);
	
	// Update version
	if (isset($r34ps->version)) {
		update_option('r34ps_version', $r34ps->version);
	}
	
	// Version-specific updates
	
}


// Deferred install/update admin notices
function r34ps_deferred_admin_notices() {
	if ($notices = get_option('r34ps_deferred_admin_notices', array())) {
		foreach ((array)$notices as $notice) {
			echo '<div class="notice notice-' . esc_attr($notice['status']) . ' is-dismissible r34ps-admin-notice">' . wp_kses_post($notice['content']) . '</div>';
		}
	}
	delete_option('r34ps_deferred_admin_notices');
}
add_action('admin_notices', 'r34ps_deferred_admin_notices');
