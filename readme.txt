=== PJW Query Child Of  ===
Tags: query, page, child
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=paypal%40ftwr%2eco%2euk&item_name=Peter%20Westwood%20WordPress%20Plugins&no_shipping=1&cn=Donation%20Notes&tax=0&currency_code=GBP&bn=PP%2dDonationsBF&charset=UTF%2d8
Contributors: westi
Requires at least: 2.0
Tested up to: 3.1
Stable tag: 1.10

== Description ==
This plugin allows you to run loops within your WordPress templates where you query for children of the current page.

The plugin extra arguments to the list of arguments supported by query_posts().

The query argument `child_of` is used to add a WHERE to the database query to limit the pages returned to those with a post_page equal to the argument provided.

The query argument `child_limit` is used to limit the number of pages returned.

The query argument `child_offset` is used to offset the limiting to allow for pagination if required.


== Changelog ==

= v0.01 =
* Initial Release

= v0.02 =
* Fix logical bug.

= v1.00 =
* Improved release with added child_limit and child_offset variables

= v1.10 =
* Added page template examples to documentation and repository.
* Added extra FAQ answers.
* Changed the child_of query variable to rewrite to using post_parent instead if the WordPress version is new enough (v2.6 or later)

== Installation ==

1. Upload to your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen.
3. Use the new query variables in calls to query_posts()

== Frequently Asked Questions ==

= How can I use this in a page template? =

The plugin is used when you call query_posts() from a theme template file so as to run your own query.

The following code is an example of what you could do to generate a list of the first 10 child pages from a parent page:

`
<div id="children">
        <dl>
        <?php query_posts('static=true&child_limit=10&child_of='.$id.'&order=ASC'); ?>
        <?php if(have_posts()) : while (have_posts()) : the_post(); ?>
        <dt><a href="<?php the_permalink();?>"><?php the_title();?>:</a></dt>
                <dd style=""><em><?php the_excerpt(); ?></em></dd>
        <?php endwhile; endif; ?>
        </dl>
</div>
`

= How can I create a a page template which lists children of children? =

If you want to create a hierarchical display with children of children then you will need to use nested loops which requires some care.

You will need to have the most up-to-date version of this plugin and then you can use the examples which are included with it in the page-templates folder.

The basic loops needed for a nested solution are as follows:

`
<div id="children">
        <dl>
        <?php query_posts('static=true&posts_per_page=-1&post_parent='.$id.'&order=ASC'); ?>
        <?php if(have_posts()) : while (have_posts()) : the_post(); ?>
		<?php 	$inner_query = new WP_Query("post_type=page&posts_per_page=-1&post_parent={$id}&order=ASC");
				while ($inner_query->have_posts()) : $inner_query->the_post(); ?>
		        	<dt><a href="<?php the_permalink();?>"><?php the_title();?>:</a></dt>
                	<dd style=""><em><?php the_excerpt(); ?></em></dd>
        <?php endwhile; endwhile; endif; ?>
        </dl>
</div>
`

= How do I set an excerpt for a Page? =

If you want to set an excerpt for a page then you need to install my Page Excerpt plugin and this will add an excerpt box to the "Edit Page" so that you can enter one.

This plugin can be found here: http://wordpress.org/extend/plugins/pjw-page-excerpt/
