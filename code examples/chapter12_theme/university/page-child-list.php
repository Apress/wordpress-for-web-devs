<?php
/*
Template Name: Page with Child Page List
*/
?>
<?php get_header(); ?>

<div id="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<div class="post" id="<?php echo $post->post_name; ?>">
	<h2><a href="<?php the_permalink(); ?>" 
title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
</h2>
    	<?php the_content(); ?>

		<?php 		
		// LOOP 2: children of the current page, with thumbnails
		$loop2 = new WP_Query( array(
								'posts_per_page' => -1,
								'child_of' => get_the_ID(),
								'order' => ASC,
								'orderby' => 'menu_order'
								) );
		while ($loop2->have_posts()) : $loop2->the_post(); ?>
		<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
			<?php the_post_thumbnail(); ?>
        </li>
		<?php endwhile; ?>  

</div><!-- .post -->
<?php endwhile; ?>
<?php else: ?>
	<p>Sorry, these posts could not be found.</p>
<?php endif; ?>
</div><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
