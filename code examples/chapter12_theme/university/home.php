<?php get_header(); ?>
<div id="content" class="section">
	
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Slideshow') ) : endif; ?>
		
	<?php get_template_part( 'loop', 'home' ); ?>
	
	<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Home Page Primary') ) : endif; ?>

</div> <!-- #content -->

<?php get_sidebar(); ?>

<div class="features">
	<div class="feature section">
		<?php wp_reset_query();

		// Get the ID of a given category
		$cat = get_cat_ID( 'News' );

		// Get the URL of this category
		$cat_link = get_category_link( $cat );
		?>
		<h2 class="more-stories"><?php if (!empty($cat_link)) echo '<a href="'.$cat_link.'">Faculty News</a>'; else echo 'Faculty News'; ?></h2>
	    <ul class="more-stories nobullet">
	        <?php 		
			// LOOP 5: more entries, titles only
			$loop5 = new WP_Query( array('posts_per_page'=> 3, 'cat' => $cat ) );
			while ($loop5->have_posts()) : $loop5->the_post(); ?>
			<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
	        </li>
			<?php endwhile; ?>
		</ul>
	</div>
	<div class="feature section">
		<?php wp_reset_query();

		// Get the ID of a given category
		$cat = get_cat_ID( 'Courses' );

		// Get the URL of this category
		$cat_link = get_category_link( $cat );
		?>
		<h2 class="more-stories"><?php if (!empty($cat_link)) echo '<a href="'.$cat_link.'">Latest Courses</a>'; else echo 'Latest Courses'; ?></h2>
	    <ul class="more-stories nobullet">
	        <?php 		
			// LOOP 3: more entries, titles only
			$loop3 = new WP_Query( array('posts_per_page'=> 3, 'cat' => $cat ) );
			while ($loop3->have_posts()) : $loop3->the_post(); ?>
			<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
	        </li>
			<?php endwhile; ?>
		</ul>
	</div>
	<div class="feature section">
		<?php wp_reset_query();

		// Get the ID of a given category
		$cat = get_cat_ID( 'Books' );

		// Get the URL of this category
		$cat_link = get_category_link( $cat );
		?>
		<h2 class="more-stories"><?php if (!empty($cat_link)) echo '<a href="'.$cat_link.'">New Books</a>'; else echo 'New Books'; ?></h2>
	    <ul class="more-stories nobullet">
	        <?php 		
			// LOOP 4: more entries, titles only
			$loop4 = new WP_Query( array('posts_per_page'=> 3, 'cat' => $cat ) );
			while ($loop4->have_posts()) : $loop4->the_post(); ?>
			<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		        <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
	        </li>
			<?php endwhile; ?>
		</ul>
	</div>
</div>

<?php get_footer(); ?>