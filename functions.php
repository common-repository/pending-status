<?php

// Don't load directly
if (!defined('ABSPATH')) { exit; }


function r34ps_dashboard_widget() {
	// Get all public post types on the site
	$post_types = get_post_types(array('public' => true), 'objects');
	
	// Iterate through each post type
	global $wpdb;
	$r34ps_status = array();
	foreach ((array)$post_types as $post_type) {
		$sql =	'SELECT COUNT(`ID`) as count FROM `' . $wpdb->posts . '` ' .
				'WHERE `post_type` = "' . esc_sql($post_type->name) . '" ' .
				'AND `post_status` = "pending"';
		$r34ps_results = $wpdb->get_results($sql);
		$count = intval($r34ps_results[0]->count);
		if ($count > 0) {
			$r34ps_status[] = array(
				'label' => $post_type->label,
				'count' => $count,
				'url' => admin_url('edit.php?post_type=' . esc_attr($post_type->name) . '&post_status=pending'),
				'view_items' => $post_type->labels->view_items,
			);
		}
	}
	if (!empty($r34ps_status)) {
		echo '<p>' . __('You have one or more posts pending review.', 'pending-status') . '</p><table class="r34ps-table"><tbody>';
		foreach ((array)$r34ps_status as $item) {
			echo '<tr><td><strong>' . wp_kses_post($item['label']) . ':&nbsp;&nbsp;</strong></td><td>' . intval($item['count']);
			if ($item['count'] > 0) {
				echo '&nbsp;&nbsp;<small><a href="' . esc_url($item['url']) . '">' . wp_kses_post($item['view_items']) . '</a></small>';
			}
			echo '</td></tr>';
		}
		echo '</tbody></table>';
	}
	else {
		echo '<p>' . __('You currently have no posts pending review.', 'pending-status') . '</p>';
	}
	?>
	<?php
}