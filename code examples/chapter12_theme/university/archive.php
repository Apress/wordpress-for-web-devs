<?php get_header(); ?>
<div id="content" class="section">
	
	<?php if (is_category()) { ?>
		
	<h2 class="archive-title"><?php single_cat_title(); ?> Archives <a href="<?php echo get_category_feed_link(get_query_var('cat')); ?>"><img src="<?php bloginfo('template_url'); ?>/images/rss.gif" alt="RSS" /></a> </h2>
 	  
 	  <?php } elseif( is_tag() ) { ?>
		<h2 class="archive-title"><?php echo ucwords(single_tag_title("", false)); ?> Archives <a href="<?php echo get_tag_feed_link(get_query_var('tag_id')); ?>"><img src="<?php bloginfo('template_url'); ?>/images/rss.gif" alt="RSS" /></a> </h2>
 	  
 	  <?php } elseif (is_day()) { ?>
		<h2 class="archive-title"> <?php the_time('F jS, Y'); ?> Archives </h2>
 	  
 	  <?php } elseif (is_month()) { ?>
		<h2 class="archive-title"> <?php the_time('F, Y'); ?> Archives </h2>
 	  
 	  <?php } elseif (is_year()) { ?>
		<h2 class="archive-title"> <?php the_time('Y'); ?> Archives </h2>
 	  <?php } ?>
	
	<?php get_template_part( 'loop', 'list' ); ?>
	<?php get_template_part( 'nav' ); ?>
	
</div> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>