<?php

add_filter( 'wp_kses_allowed_html', 'my_allowed_tags', 10, 2 );


add_action( 'customize_register', 'edu_customizer_sections' );
function edu_customizer_sections( $wp_customize ) {

	$wp_customize->add_section( 'edu_footer', array(
		'title' => 'Footer',
		'priority' => 105,
		'capability' => 'edit_pages',
	) );
 
	$wp_customize->add_setting( 'edu_footer_text', array(
		'default' => 'P.O. Box 1111, College Town, MD',
		'sanitize_callback' => 'edu_sanitize_footer_text',
		'transport' => 'postMessage',
	) );
 
	$wp_customize->add_control( 'edu_footer_text', array(
		'label' => 'Footer contact info',
		'section' => 'edu_footer',
		'type' => 'text',
	) );

}

function edu_sanitize_footer_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

add_action( 'customize_preview_init', 'edu_customizer_live_preview' );

function edu_customizer_live_preview() {
	wp_enqueue_script( 'edu-theme-customizer', get_template_directory_uri().'/js/theme-customizer.js', array( 'jquery','customize-preview' ), '', true );
}