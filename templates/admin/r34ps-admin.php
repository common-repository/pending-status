<?php
// Don't load directly
if (!defined('ABSPATH')) { exit; }

// Only load in admin
if (!is_admin()) { exit; }
?>

<div class="wrap r34ps">
	<h2><?php echo get_admin_page_title(); ?></h2>

	<div class="metabox-holder columns-2">
	
		<div class="column-1">

			<div class="postbox">

				<div class="inside">
	
					<form method="post" action="" class="r34ps-admin" autocomplete="force-off">
					<?php
					wp_nonce_field('r34ps-admin','r34ps-nonce'); 
					?>
					
					<h3><?php _e('Email Notification Recipients', 'pending-status'); ?></h3>

					<p><?php _e('Check the box next to the name of each administrator/editor you would like to receive an email notification when a post has been set to "pending review." Note: Your site must be properly configured to send emails.', 'pending-status'); ?></p>

					<table class="form-table"><tbody>
						<tr class="r34ps-table-header-row">
							<th style="width: 10%;"></th>
							<th style="width: 30%;"><?php _e('Name', 'pending-status'); ?></th>
							<th style="width: 30%;"><?php _e('Email', 'pending-status'); ?></th>
							<th style="width: 30%;"><?php _e('Role', 'pending-status'); ?></th>
						</tr>
						<?php
						foreach ((array)$admins_and_editors as $user) {
							?>
							<tr>
								<td><input type="checkbox" name="r34ps_notification_recipients[]" value="<?php echo esc_attr($user->data->user_email); ?>"<?php if (in_array($user->data->user_email, (array)$r34ps_notification_recipients)) { echo ' checked="checked"'; } ?> /></td>
								<td><strong><?php echo wp_kses_post($user->data->display_name); ?></strong></td>
								<td><?php echo wp_kses_post($user->data->user_email); ?></td>
								<td><?php echo wp_kses_post(ucwords(implode(', ', $user->roles))); ?></td>
							</tr>
							<?php
						}
						?>
					</tbody></table>
					
					<h3><?php _e('Email Notification Message', 'pending-status'); ?></h3>
					
					<p><?php _e('Customize the message administrators and editors will receive. The URL to review the post will automatically be added to the end of the message.', 'pending-status'); ?></p>
					
					<table class="form-table"><tbody>
						<tr>
							<td><strong><?php _e('Subject:', 'pending-status'); ?></strong></td>
							<td><input type="text" style="width: 100%;" name="r34ps_notification_subject" value="<?php echo esc_attr($r34ps_notification_subject); ?>" /></td>
						</tr>
						<tr>
							<td><strong><?php _e('Message:', 'pending-status'); ?></strong></td>
							<td><textarea name="r34ps_notification_message" style="width: 100%;"><?php echo esc_textarea($r34ps_notification_message); ?></textarea></td>
						</tr>
					</tbody></table>					

					<div style="text-align: right;">
						<input type="submit" value="<?php echo esc_attr(__('Save Changes', 'pending-status')); ?>" class="button button-primary" />
					</div>

					</form>
				
				</div>
			
			</div>

		</div>
	
		<div class="column-2">

			<div class="postbox">

				<h3 class="hndle"><span><?php _e('Pending Status Support', 'pending-status'); ?></span></h3>
		
				<div class="inside">
	
					<p><?php echo sprintf(__('For support with the %1$s plugin, please use the %2$sWordPress Support Forums%3$s or email %4$s.', 'pending-status'), '<strong>Pending Status</strong>', '<a href="https://wordpress.org/support/plugin/pending-status" target="_blank">', '</a>', '<a href="mailto:support@room34.com">support@room34.com</a>'); ?></p>
		
				</div>

			</div>

			<div class="postbox">

				<h3 class="hndle"><span>Thank You!</span></h3>
		
				<div class="inside">
	
					<a href="https://room34.com/about/payments/?type=WordPress+Plugin&plugin=Pending+Status&amt=9" target="_blank"><img src="<?php echo dirname(dirname(plugin_dir_url(__FILE__))); ?>/assets/room34-logo-on-white.svg" alt="Room 34 Creative Services" style="display: block; height: auto; margin: 0 auto 0.5em auto; width: 200px;" /></a> 
		
					<p><?php _e('This plugin is free to use. However, if you find it to be of value, we welcome your donation (suggested amount: USD $9), to help fund future development.', 'pending-status'); ?></p>

					<p><a href="https://room34.com/about/payments/?type=WordPress+Plugin&plugin=Pending+Status&amt=9" target="_blank" class="button"><?php _e('Make a Donation', 'pending-status'); ?></a></p>
					
				</div>
		
			</div>
		
			<p><small>Pending Status v. <?php echo wp_kses_post(get_option('r34ps_version')); ?></small></p>
		
		</div>
	
	</div>

</div>