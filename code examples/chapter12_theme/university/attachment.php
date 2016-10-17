<?php get_header(); ?>
<?php $theme = us2011_get_options(); ?>
<div id="content" class="section">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<?php $attachment_link = get_the_attachment_link($post->ID, true, array(450, 800)); ?>
	
	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

			<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>      	
			
			<p class="attachment"><?php echo $attachment_link; ?></p>
			
			<div class="navigation">
				<p class="previous"><?php next_image_link( __( '&larr; Older') ); ?></p>
				<p class="next"><?php previous_image_link( __( 'Newer &rarr;' ) ); ?></p>
				<p class="clear"><!-- --></p>
			</div><!-- .navigation -->
			
			<p class="postmetadata">
			<?php if ($theme['shortlink']) the_shortlink(wp_get_shortlink(), null, '<br />Sharing this page? The short link is: ', ''); ?> 
			<?php if (!empty($theme['problem_report'])) echo '<br /><a href="' . esc_url(get_page_link($theme['problem_report'])) . 'Report a problem with this page.</a>'; ?>
			<?php edit_post_link(__('Edit this file\'s details' ), '<br /><span class="edit_link">', ' &raquo;</span>'); ?>
			<?php wp_delete_post_link('Trash this file', ' | ', ' &raquo;</p>', 'Move this file to the trash'); ?>
			</p>
		
		<?php comments_template(); ?>
	</div> <!-- #post-n -->
	<?php endwhile; else: ?>

	<p>Sorry, no attachments matched your criteria.</p>

	<?php endif; ?>
	
</div> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>