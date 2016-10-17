<?php

// add post/page header image size
add_image_size( 'header_image', 960, 170, true );

add_filter('image_size_names_choose', 'tamuq_image_sizes');
function tamuq_image_sizes( $sizes ) {
	return array_merge( $sizes, array( 'header_image' => 'Page Header' ) );
}

//*
// SlidesJS slideshow
// enqueue slideshow scripts on home page
function edu_simple_slideshow_scripts() {
	if ( is_home() || is_front_page() ) {
		wp_enqueue_script( 'slides', get_template_directory_uri().'/js/jquery.slides.js', 'jquery', '3.0.3', true );
		wp_enqueue_script( 'slideshow-init', get_template_directory_uri().'/js/slideshow-init.js', array('jquery','slides'), '', true );
		wp_enqueue_style( 'slideshow', get_template_directory_uri().'/css/slideshow.css' );
	}     
}

add_action('wp_enqueue_scripts', 'edu_simple_slideshow_scripts');

// display slideshow
function edu_simple_slideshow( $parent ) {
	// Custom loop for image slideshow
	$args = array(
		'post_parent' => $parent,
		'post_type' => 'attachment',
		'post_mime_type' => 'image', 
		'post_status' => 'inherit',
		'posts_per_page' => -1,
	);
	$slideposts = new WP_Query( $args );

	if ($slideposts->have_posts()) :
		echo '<div id="slides" class="wrap">';
		$slides = '';
		while ($slideposts->have_posts()) : $slideposts->the_post(); 
			echo wp_get_attachment_image( get_the_ID(), 'full' );
		endwhile;	
		echo '</div>';
	endif;
}