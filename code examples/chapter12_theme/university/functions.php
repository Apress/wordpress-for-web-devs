<?php

// Theme Options
//include_once('theme-options.php');
include_once('theme-customizer.php');
include_once('slideshow.php');

// Limit posts on home page
function edu_home_post_limit($query) {
	if ( !is_main_query() )
		return $query;
		
	if ( is_home() || is_front_page() ) {
		$query->set( 'posts_per_page', 1 );
		$query->set( 'cat', get_cat_ID( 'News' ) );
	}
		
	return $query;
}
//add_action('pre_get_posts', 'edu_home_post_limit');

// Theme Support
$headerargs = array(
	'flex-width'    => true,
	'width'         => 980,
	'flex-height'    => true,
	'height'        => 200,
	'default-image' => '',  //none
);
add_theme_support( 'custom-header', $headerargs );
add_theme_support( 'custom-background' );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'standard', 'audio', 'video' ) );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'nav-menus' );

// Nav Menus
add_action( 'init', 'register_edu_menus' );
function register_edu_menus() {
	register_nav_menus( array(
			'top-navigation' => __( 'Top Navigation' ),
		) );
}

// Typekit
add_action( 'wp_head', 'edu_typekit' );
function edu_typekit() {
	echo '<script type="text/javascript" src="//use.typekit.net/lxh0upi.js"></script>
	<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
}

// Excerpts
function edu_excerpt_more($more) {
	global $post;
	if (!empty($post->ID))
		return '... (<a href="'.get_permalink($post->ID).'">Continue reading</a>)';
	return '...';
}
add_filter('excerpt_more', 'edu_excerpt_more');

// Sidebars
if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
		'name' => 'Primary Sidebar',
		'id' => 'primary-sidebar',
		'description' => 'Side column, top',
        'before_widget' => '<div id="%1$s" class="widget clearfloat %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	register_sidebar(array(
		'name' => 'Secondary Sidebar',
		'id' => 'secondary-sidebar',
		'description' => 'Side column, after the primary sidebar',
        'before_widget' => '<div id="%1$s" class="widget clearfloat %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    ));
	register_sidebar(array(
			'name' => 'Home Page Slideshow',
			'id' => 'home-slideshow-sidebar',
			'description' => 'Above the main content.',
	        		'before_widget' => '<div id="%1$s" class="widget clearfloat %2$s">',
	     	   'after_widget' => '</div>',
	 	   'before_title' => '<h2 class="widgettitle">',
		   'after_title' => '</h2>',
	    ));

}