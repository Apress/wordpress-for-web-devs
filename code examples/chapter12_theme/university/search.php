<?php 
get_header();
$search = esc_attr( apply_filters( 'the_search_query', get_search_query( false ) ) ); 
?>
<div id="content" class="section">
	
	<h2 class="archive-title"><?php printf(__('Search Results for "%s"'), $search); ?>
		 <a href="<?php bloginfo("url"); echo '/?s='.$search.'&feed=rss2'; ?>"><img src="<?php bloginfo('template_url'); ?>/images/rss.gif" alt="Get an RSS feed of these results" /></a> </h2>
	
		<?php if (have_posts()) :
			$page = get_query_var('paged');
			if (!isset($page) || empty($page))
				$start = 1;
			else
				$start = ($page - 1) * get_option('posts_per_page') + 1;
		?>
		<ol class="search-results" start="<?php echo $start; ?>">
			<?php while (have_posts()) : the_post(); ?>

		<li <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		    <h3><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>      	
			<?php the_excerpt(); // autop ?>
		</li> <!-- #post-n -->

		<?php endwhile; else: ?>
			<p><?php _e('Sorry, no posts matched your criteria. Try a different search:'); ?></p>
			<?php get_template_part( 'searchform' ); ?>
		<?php endif; ?>
		</ol>
		
	<?php get_template_part( 'nav' ); ?>
	
</div> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>