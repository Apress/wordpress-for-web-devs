<?php get_header(); ?>
<div id="content" class="section">
	
	<h2>I'm sorry. I couldn't find the page you requested.</h2>

	<p>You can try searching for itor looking for it in the <a href="/sitemap">site map</a>. 
	<?php echo $report; ?></p>
	
	<?php get_template_part( 'searchform' ); ?>
	
	<?php 
	global $wp_query;
	$wp_query->query_vars['is_search'] = true;
	$s = str_replace("-"," ",$wp_query->query_vars['name']);
	$loop = new WP_Query('post_type=any&s='.$s);
	?>
	<?php if ($loop->have_posts()) : ?>
		<p>I'm searching for the name of the page you tried to visit... was it one of these?</p>
		<ol>
		<?php while ($loop->have_posts()) : $loop->the_post(); ?>
			<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				<?php the_excerpt(); ?>
			</li>
		<?php endwhile; ?>
		</ol>
   	<?php endif; ?>
	
</div> <!-- #content -->
<?php get_sidebar(); ?>
<?php get_footer(); ?>