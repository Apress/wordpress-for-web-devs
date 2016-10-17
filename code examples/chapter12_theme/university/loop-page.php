<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	
    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>     
 
	<?php the_content('Read more...'); ?>
	
	<?php 
	/*
	$children = wp_list_pages('order=ASC&orderby=menu_order&title_li=&echo=0&child_of='.get_the_ID() ); 
	
	if (!empty($children)) { ?>
	<h3>More in <?php the_title(); ?>:</h3>
   	<ul class="after">
	<?php echo $children; ?>
	</ul>
	<?php } */ ?>
	
	<?php
	$attachments = get_children(array(
		'post_type' => 'attachment',
		'posts_per_page' => -1,
		'post_status' => 'inherit',
		'post_parent' => get_the_ID()
		));
	if ($attachments) { ?> 
	   <ul class="attachments">	<?php 
		foreach ($attachments as $attachment) {
			if (substr($attachment->post_mime_type, 0, 5) != 'image') {
				$type = sanitize_html_class($attachment->post_mime_type);
				echo '<li class='.esc_attr($type).'>';
				the_attachment_link($attachment->ID, false);
				echo '</li>';
			}
		}
	?> </ul>	
	<?php } ?>
	
	
	<p>
	<?php edit_post_link(__('Edit this entry' ), '<br /><span class="edit_link">', ' &raquo;</span>'); ?>
    </p>

</div> <!-- #post-n -->

<?php endwhile; else: ?>
	<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
<?php endif; ?>