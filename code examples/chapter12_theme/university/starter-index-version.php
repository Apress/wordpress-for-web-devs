<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<meta name="viewport" content="width = device-width, initial-scale = 1.0">

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen,projection" />

<?php wp_head(); ?>

</head>

<body <?php body_class( ); ?>>
<div id="wrapper">

	<div id="header" class="section"> 
		<h1 class="header"> <a href="/"><?php bloginfo('name'); ?></a> </h1>
	</div>

	<div id="nav-top">
		<?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'format' => 'ul', 'menu_class' => 'nav' ) ); ?>
	</div>
		
<div id="content" class="section">
	
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">

	    <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>     
	 	
		<?php the_content('Read more...'); ?>

	   	<?php comments_template(); ?>
	</div> <!-- #post-n -->

	<?php endwhile; else: ?>
		<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
	<?php endif; ?>
	
</div> <!-- #content -->


<div id="sidebar" class="section">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Primary Sidebar') ) : endif; ?>    
</div>


<div id="footer" class="section">
	
	<p class="copyright"><?php echo '&copy; ' . date( ' Y ' ) . get_bloginfo( 'name' ); ?></p>
	<div class="contact"><?php echo get_theme_mod( 'edu_footer_text', '' ); ?></div>

</div>
<?php wp_footer(); ?>
</body>
</html>