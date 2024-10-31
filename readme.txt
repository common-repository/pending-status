=== Pending Status ===
Contributors: room34
Donate link: https://room34.com/payments
Tags: post status, pending, pending review, workflow, notifications
Requires at least: 4.9
Requires PHP: 7.0.0
Tested up to: 6.7
Stable tag: 1.0.3
License: GPLv2

Get notified when your site has posts pending review.

== Description ==

**Pending Status** is a super-simple solution for WordPress sites that need very basic workflow functionality. It's easy to set up and doesn't overload your site with unnecessary features.

If you have Contributors who can create, but not publish, their own content on your site, Pending Status notifies you of any pending posts that are ready to review. By default, all users with the Administrator or Editor role will see a **Pending Status** box on the Dashboard, showing the counts of pending posts, with a convenient link to the list of pending posts for that post type.

Optionally, you can also identify one or more Administrators/Editors to receive email notifications whenever a post is saved with "pending" status. The subject and message of the email are fully editable, and a direct edit link for the post is included in the body of the email.

Pending Status works with *all* publicly queryable post types: Posts, Pages, and even Custom Post Types created by third party plugins (e.g. WooCommerce, The Events Calendar, etc.), or your own custom code.

== Installation ==

== Frequently Asked Questions ==

= How do I set up email notifications? =

By default the plugin displays a "Pending Status" widget on the admin Dashboard, but does not automatically send email notifications. To set up email notifications, navigate to **Settings &gt; Pending Status** and check the boxes next to the administrators or editors who should receive an email notification. Here you can also customize the text of the email message.

= I've set up email notifications, but I'm not receiving them. Why not? =

Pending Status uses the built-in WordPress email functions to send notifications. Some web hosts do not allow websites to send email. We recommend using the [Check &amp; Log Email](https://wordpress.org/plugins/check-email/) plugin to test whether or not you can send email from your WordPress site. If your host does not allow sending mail directly from the web server, we recommend using the [WP Mail SMTP](https://wordpress.org/plugins/wp-mail-smtp/) plugin to configure your site to route email through the mail server of your choice.

== Screenshots ==

== Changelog ==

= 1.0.3 - 2024.10.04 =

* Removed unnecessary `load_plugin_textdomain()` call, and set `$translate` input parameter to `false` on `get_plugin_data()` call, as it may cause PHP notices as of WordPress 6.7. See the [WordPress Trac](https://core.trac.wordpress.org/ticket/62154#comment:8) for more details.
* Refactored code in main plugin file to incorporate Room 34's standard mechanisms for admin notices and plugin install/update functionality.
* i18n: Updated `.pot` translation file.
* Bumped "tested up to" to 6.7.

= 1.0.2 - 2024.04.09 =

* i18n: Updated `.pot` file.
* Bumped "Tested up to" to 6.5.
* Hotfix: Added `blueprint.json` for WordPress Playground support.

= 1.0.1 - 2022.05.11 =

* Fixed minor text issue on admin page.
* Bumped "Tested up to" to 6.0.

= 1.0.0 - 2022.02.28 =

* Original version.

== Upgrade Notice ==
