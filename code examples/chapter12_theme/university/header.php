<!DOCTYPE html>
<!--[if lt IE 7]><html lang="en" class="ie6"><![endif]--> 
<!--[if IE 7]><html lang="en" class="ie7"><![endif]--> 
<!--[if IE 8]><html lang="en" class="ie8"><![endif]--> 
<!--[if IE 9]><html lang="en" class="ie9"><![endif]--> 
<!--[if gt IE 9]><html lang="en"><![endif]-->
<!--[if !IE]>--><html lang="en"><!--<![endif]-->
<head>
<meta charset="<?php bloginfo('charset'); ?>" />
<title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); if ( is_home() ) echo ' | The University'; ?></title>

<?php if (is_singular() || is_page() ) : if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php 
	  $keywords = '';
	  $tags = get_the_tags();
	  if (!empty($tags)) foreach($tags as $tag) { $keywords[] = strtolower($tag->name); }
		$cats = get_the_category();
	  if (!empty($cats)) foreach($cats as $category) { $keywords[] = strtolower($category->cat_name); }
	  if (!empty($keywords)) $keywords = implode(", ", array_unique($keywords)); 
	?>
<meta name="keywords" content="<?php esc_attr_e($keywords); ?>" />
<?php $desc = get_the_excerpt(); ?>
<meta name="description" content="<?php esc_attr_e($desc); ?>" />
<?php endwhile; endif; elseif(is_home()) : ?>
<meta name="description" content="<?php bloginfo('description'); ?>" />
<?php endif; ?>

<?php 
if ( is_search() ) { 
	echo '<meta name="robots" content="noindex, nofollow" /> ';
}
//$theme = us2011_get_options(); 
?>
<meta name="verify-v1" content="<?php echo get_theme_mod('google_meta_key', ''); ?>" >
<meta name="viewport" content="width = device-width, initial-scale = 1.0">

<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>" type="text/css" media="screen,projection" />

<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); // support for comment threading ?>

<!-- [if lte IE 8]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script><![endif]-->
<!--[if lte IE 8]><script src="scripts/css3-mediaqueries.js"></script><![endif]-->
<!--[if IE]><script src="js/modernizr-1.7.min.js"></script><![endif]-->

<?php get_template_part('wp_head'); ?>

</head>

<body <?php body_class( ); ?>>
<div id="wrapper">

	<div id="header" class="section"> 
		<img src="<?php header_image(); ?>" height="<?php echo get_custom_header()->height; ?>" width="<?php echo get_custom_header()->width; ?>" alt="" />
		<h1 class="header"> <a href="/"><?php bloginfo('name'); ?></a> </h1>
		
		<?php do_action('edu_after_title'); ?>
	</div>

	<div id="nav-top">
		<?php wp_nav_menu( array( 'theme_location' => 'top-navigation', 'menu_class' => 'nav' ) ); ?>
	</div>