<div id="header" class="section"> 
	<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
	<h1 class="header">
		<a href="/"><?php bloginfo('name'); ?></a>
	</h1>
		
	<?php get_template_part('searchform'); ?>
</div>