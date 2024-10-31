<?php
/*
   Plugin Name: PJW Query Child Of
   Plugin URI: http://blog.ftwr.co.uk/wordpress/query_child/
   Description: Allows you to use query_posts to list the children of a page.
   Author: Peter Westwood
   Version: 1.10
   Author URI: http://blog.ftwr.co.uk/

 */

class pjw_query_child_of 
{
		function pjw_query_child_of()
		{
				global $wp_version;
				
				add_filter( 'query_vars', array(&$this,'register_query_var') );
				add_filter( 'posts_where', array(&$this,'posts_where') ); 
				add_filter( 'post_limits', array(&$this, 'post_limits') );
				
				//WordPress 2.6 introduced post_parent which provides the same functionality as child_of
				if (version_compare($wp_version, '2.6', '>=')) {		
					add_filter( 'pre_get_posts', array(&$this, 'pre_get_posts') );
				}
		}

		function pre_get_posts($wp_query)
		{
			if (isset($wp_query->query_vars['child_of']))
			{
				$wp_query->query_vars['post_parent'] = $wp_query->query_vars['child_of'];
				unset($wp_query->query_vars['child_of']);
			}
		}
		
		function posts_where($where)
		{
				$parent_page = get_query_var('child_of');
				if (0 != $parent_page)
				{
						$where .= "AND (post_parent = '$parent_page')";
				}
				return $where;
		}
		
		//If a child limit has been specified then we will enforce that instead of what was already passed in.
		function post_limits($limit)
		{
				$new_limit = absint( get_query_var('child_limit') );
				$offset = absint( get_query_var('child_offset') );

				if (0 != $new_limit)
				{
						$limit = "LIMIT $offset, $new_limit";
				}
				return $limit;
		}

		// Register our new query variables
		function register_query_var($vars) {
				$vars[] = 'child_of';
				$vars[] = 'child_limit';
				$vars[] = 'child_offset';
				return $vars;
		}
}

/* Initialise outselves lambda stylee */
add_action('plugins_loaded', create_function('','global $pjw_query_child_of; $pjw_query_child_of = new pjw_query_child_of;'));
?>
