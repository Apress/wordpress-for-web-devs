<?php 

	//edu_users_table();
	//edu_simple_slideshow(30);
	
	//wp_reset_query();
	
	// LOOP 1: first entry, title, excerpt, post thumbnail
 the_post(); ?>

	<div <?php post_class('top-story'); ?> id="post-<?php the_ID(); ?>">
       	<h2 class="top-story"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2> 
		<?php
		//*   
		 if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) {
			 echo '<p class="alignright">';
		 	the_post_thumbnail('full', array('class' => 'full', 'alt' => ''.get_the_title().''));
			echo '</p>';
		 } 
		/**/
		 ?>       	
		<p><?php the_content('Read more...'); ?></p> 
    </div>

	<?php 
	
	
	wp_reset_query();
	
	// Get the ID of a given category
	$cat = get_cat_ID( 'News' );

	// Get the URL of this category
	$cat_link = get_category_link( $cat );
	?>
	<h2 class="more-stories"><?php if (!empty($cat_link)) echo '<a href="'.$cat_link.'">More News</a>'; else echo 'More News'; ?></h2>
    <ul class="more-stories nobullet">
        <?php 		
		// LOOP 2: more entries, titles only
		$loop2 = new WP_Query( array('posts_per_page'=> 4, 'offset'=> 1, 'cat' => $cat ) );
		while ($loop2->have_posts()) : $loop2->the_post(); ?>
		<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
	        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
        </li>
		<?php endwhile; ?>
	</ul>