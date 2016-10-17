<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>     
 	<p class="postmetadata before"><?php _e('Posted by '); ?><a href="<?php get_the_author_link(); ?>"><?php the_author(); ?></a></p>

	<?php //the_excerpt(); 
	the_content('Read more...'); ?>
	
   

	<?php if ( is_single() && get_the_author_meta( 'description' ) ) : // If a user has filled out their description, show a bio on their entries  ?>
	<div id="entry-author-info">
		<div id="author-avatar">
			<?php echo get_avatar( get_the_author_meta( 'user_email' ) ); ?>
		</div><!-- #author-avatar -->
		<div id="author-description">
			<h2><?php printf( __( 'About %s' ), get_the_author() ); ?></h2>
			<?php the_author_meta( 'description' ); ?>
			<h4>More Posts:</h4>
			<ul class="authorposts">
				<?php 
				$authorloop = new WP_Query( array(
								'posts_per_page' => 5,
								'author' => $post->post_author,
								) );
				while ( $authorloop->have_posts()) : $authorloop->the_post(); ?>
				<li><a href="<?php the_permalink() ?>" rel="bookmark" title="'Permanent link to <?php the_title_attribute(); ?>">
					<?php the_title(); ?></a></li>
					<?php endwhile; ?>
			</ul>
			<div id="author-link">
				<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" rel="author">
					<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>' ), get_the_author() ); ?>
				</a>
			</div><!-- #author-link	-->
		</div><!-- #author-description -->
	</div><!-- #entry-author-info -->
<?php endif; ?>
	
	
	<p class="postmetadata after">
	<?php 
	if (is_single()) { 
		_e('Filed under ' ); 
		the_category(','); 
	} 
	?>
	<?php edit_post_link(__('Edit this entry' ), '<br /><span class="edit_link">', ' &raquo;</span>'); ?>
    </p>


	<?php comments_template(); ?>
</div> <!-- #post-n -->

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>