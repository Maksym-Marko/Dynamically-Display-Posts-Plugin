=== Dynamically Display Posts ===
Contributors: markomaksym
Tags: display posts, display CPT, pagination, load more button
Requires at least: 5.0
Tested up to: 5.6
Stable tag: 888
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
	WP Plugin Sceleton Generator Version: 			3.0
	WP Plugin Sceleton Generator Author: 			Maksym Marko
	WP Plugin Sceleton Generator Author Website:	

This plugin allows you to display a list of posts on your website on any page.

== Description ==

<p>
	This plugin allows you to display a list of posts on your website on any page. 
	You can display the default WordPress post types or Custom Post Types by placing the shortcode to the page where you want to collect the post items.
</p>

<p>
	You should use the shortcode below to place it on the page. 
</p>
<p style="font-weight: bold;">
	[mx_ddp_post_template post_type="news_sport" term_ids="18,19" posts_per_page="5" pagination="none" default_image_url="http://yourdomain.com/path-to-image/no-photo.jpg"]
</p>

<h3>Where the properties are:</h3>

<ul>
	<li>
		<b>post_type</b> - The post type to display (default value = 'post')
	</li>
	<li>
		<b>term_ids</b> - The exists taxonomy IDs of the current (post_type prop.) post type. You should place list of category IDs separated by comma (,). (default value is not specified)
	</li>
	<li>
		<b>posts_per_page</b> - Number of posts on each page (default value = '10')
	</li>
	<li>
		<b>pagination</b> - Type of navigation. Defined values: none, numbers, load_more (default value = 'numbers')
	</li>
	<li>
		<b>default_image_url</b> - If a post doesn't have any thumbnail, you can set up the default image (default value is not specified)
	</li>
	<li>
		<b>search_bar</b> - Display search bar. Defined values: on, off (default value = 'on')
	</li>
</ul>

<p>
	<b>How does it work?</b>
</p>

<iframe width="600" height="320" src="https://www.youtube.com/embed/q3LcB2gtDWE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins > Add New'
2. Search for 'Dynamically Display Posts'
3. Activate the plugin from your Plugins page.

= From WordPress.org =

1. Download 'Dynamically Display Posts'.
2. Upload the 'Dynamically Display Posts' directory to your '/wp-content/plugins/' directory, using your favorite method (ftp, sftp, scp, etc...)
3. Activate 'Dynamically Display Posts' from your Plugins page.

== Screenshots ==

1. How the posts feed looks like

== Changelog ==

= 1.0 =
* Dynamically Display Posts