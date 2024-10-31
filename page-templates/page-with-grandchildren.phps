<?php
/*
   Template Name: Page with GrandChildren
 */
get_header(); ?>

	<div id="content" class="narrowcolumn" role="main">

		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); ?>">
		<h2><?php the_title(); ?></h2>
			<div class="entry">
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

			</div>
		</div>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
        <div id="children">
                <dl>
                <?php query_posts('static=true&posts_per_page=-1&child_of='.$id.'&order=ASC'); ?>
                <?php if(have_posts()) : while (have_posts()) : the_post(); ?>
    			<?php 	$inner_query = new WP_Query("post_type=page&posts_per_page=-1&child_of={$id}&order=ASC");
						while ($inner_query->have_posts()) : $inner_query->the_post(); ?>
    			        	<dt><a href="<?php the_permalink();?>"><?php the_title();?>:</a></dt>
                        	<dd style=""><em><?php the_excerpt(); ?></em></dd>
                <?php endwhile; endwhile; endif; ?>
                </dl>
        </div>
	</div>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
