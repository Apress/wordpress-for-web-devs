<?php

/************ Filter and Action Demos ****************/


//Listing 11-1. Adding a footer comment with wp_footer

add_action( 'wp_footer', 'say_hello' );

function say_hello() {
	echo '<!-- Hello, curious theme developer! -->';
}



//Listing 11-2. Using the the_excerpt_more filter

add_filter( 'the_excerpt_more', 'no_ellipses' );

function no_ellipses( $more ) {
	return ' (Continue reading) ';
}



// Listing 11-3. Removing a hooked function

// original plugin’s code:
add_action('wp_dashboard_setup', 'unwanted_dashboard_widget');

// your theme functions file or plugin:
remove_action('wp_dashboard_setup', 'unwanted_dashboard_widget');



// Listing 11-4. Creating an infinite loop when setting the post status according to category 
// THIS IS A BAD EXAMPLE. See 11-5 below for the correct way of doing this.

add_action( 'save_post', 'set_category_eight_to_private' );

function set_category_eight_to_private( $postid ) {
	if ( in_category( 8 ) {
		wp_update_post( array( 'ID' => $postid, 'post_status' => 'private' ) );
	}
}



// Listing 11-5. Creating the private category without an infinite loop

add_action( 'save_post', 'set_category_eight_to_private' );

function set_category_eight_to_private( $postid ) {
	if ( in_category( 8 ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post', 'set_category_eight_to_private' );
		
		//update the post
		wp_update_post( array( 'ID' => $postid, 'post_status' => 'private' ) );
		
		// re-hook this function
		add_action( 'save_post', 'set_category_eight_to_private' );
	}
}


/************ Option Page Demos ****************/


// Listing 11-6. An empty options page

function scl_simple_options_page() {
?>
<div class="wrap">
	<form method="post" id="scl_simple_options" action="options.php">

		<h2><?php _e('Sample Options' ); ?></h2>
		
		<p class="submit">
		<input type="submit" value="<?php esc_attr_e('Update Options'); ?>" class="button-primary" />
		</p>
		
	</form>
</div>
<?php
}

add_action('admin_menu', 'scl_simple_options_add_pages');

function scl_simple_options_add_pages() {
	add_options_page('Sample Options', 'Sample Options', 'manage_options', 'simple-options-example', 'scl_simple_options_page');
}



// Listing 11-7. Modifying the add_pages function to register a setting
// modification of 11-6

add_action('admin_menu', 'scl_simple_options_add_pages');

function scl_simple_options_add_pages() {
	add_options_page('Sample Options', 'Sample Options', 'manage_options', 'simple-options-example', 'scl_simple_options_page');
	register_setting( 'scl_simple_options', 'scl_simple_options' );
}



// Listing 11-8. Setting default options on activation
// To be used in conjunction with 11-9

function scl_simple_options_defaults() {	
	// set defaults
	$defaults = array(
			'shortlink'		=> 1,
			'google_meta_key'	=> '',
	);
	
	add_option( 'scl_simple_options', $defaults, '', 'yes' );
}

register_activation_hook(__FILE__, 'scl_simple_options_defaults');



// Listing 11-9. Setting up options for use in the form 
// Complete version of 11-6

function scl_simple_options_page() {
?>
<div class="wrap">
	<form method="post" id="scl_simple_options" action="options.php">
		<?php 
		settings_fields('scl_simple_options');
		$options = get_option( 'scl_simple_options' );
		?>
		<h2><?php _e('Sample Options' ); ?></h2>

		<table class="form-table">
			<tr>
				<th scope="row"><?php _e('Short Links' ); ?></th>
				<td colspan="3">
				<p>	<label>
						<input name="scl_simple_options[shortlink]" type="checkbox" value="1" <?php checked($options['shortlink'], 1); ?>/>
						<?php _e('Display a short URL on all posts and pages'); ?>
					</label></p>
				</td>
			</tr>
						
			<tr>
				<th scope="row"><?php _e('Google Verification' ); ?></th>
				<td colspan="3">
				<input type="text" id="google_meta_key" name="scl_simple_options[google_meta_key]" value="<?php echo esc_attr($options['google_meta_key']); ?>" />
				<br /><span class="description"><?php _e('Enter the verification key for the Google meta tag.' ); ?></span>
				</td>
			</tr>
		</table>
		
		<p class="submit">
		<input type="submit" value="<?php echo esc_attr_e('Update Options'); ?>" class="button-primary" />
		</p>		
	</form>
</div>
<?php
}



// Listing 11-10. Updating an option manually
// For demonstration only; not needed with 11-9

function change_options() {
	$options = get_option('my_option');
	// do something with $options here
	update_option('my_option', $options);
}



// Listing 11-11. Removing the sample plugin options on deletion
// To be used with 11-8 and 11-9

register_uninstall_hook( __FILE__, 'scl_delete_simple_options' );

function scl_delete_simple_options() {
	delete_option('scl_simple_options');
}


// Listing 11-12. Removing the sample plugin options on deactivation
// Alternative version of 11-11, to be used in test environments rather than production

// during testing, delete options on deactivation instead
register_deactivation_hook( __FILE__, 'scl_delete_simple_options' );
// register_uninstall_hook( __FILE__, 'scl_delete_simple_options' );



/************ Escaping and Validating Input ****************/


// Listing 11-13. Escaping an input tag’s value attribute
?>

<input type="text" id="google_meta_key" name="scl_simple_options[google_meta_key]" value="<?php echo esc_attr($options['google_meta_key']); ?>" />

<?php


// Listing 11-14. JavaScript breaks out of the improperly escaped value attribute and runs in the browser
// AN EXAMPLE OF WHAT NOT TO DO!
?>

<input type="text" id="google_meta_key" name="scl_simple_options[google_meta_key]" value="<?php echo 'foo" onchange="alert(\"Gotcha!\")"' ?>" />

<?php

// Listing 11-15. Sanitizing data from text input fields
$option = sanitize_text_field($_POST['google_meta_key']);


// Listing 11-16. Sanitizing HTML input with kses
$option = wp_kses_post($_POST['post_content']);


// Listing 11-17. Sanitizing email addresses
$option = is_email($_POST['user_email']);


// Listing 11-18. Sanitizing integers
$my_integer = intval($_POST['zip_code']);


// Listing 11-19. Unnecessarily escaping a WordPress template tag
// An example of what not to do

// this is redundant
esc_html( the_title() ); 



// Listing 11-20. Sanitized class and title attributes
// The post title is "She’s a <em>maniac</em>!"

$class = sanitize_html_class( get_the_title() );
?>
<h2 class="<?php echo esc_attr( $class ); ?>"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>

<?php
// Listing 11-21. The resulting class name, title attribute, and title contents
// from 11-20
?>
<h2 class="Shesaemmaniacem"><a title="She’s a maniac!" href="http://wp/?p=6">She’s a <em>maniac</em>!</a></h2>

<?php
// Listing 11-22. Escaping HTML
$html = "<h2>She’s a <em>maniac</em>!</h2>";
echo esc_html( $html );


// Listing 11-23. Escaping a textarea’s contents
?>
<textarea><?php echo esc_textarea( $option['text'] ); ?></textarea>



<?php
// Listing 11-24. Escaping a variable for use in inline JavaScript
?>
<input name="my_option" value="<?php echo esc_attr( $my_option ); ?>" onfocus="if ( this.value == '' ) { this.value = '<?php echo esc_js( $my_option ); ?>'; }" />


<?php
// Listing 11-25. Escaping the administrator’s profile URL field

$user = get_userdata(1); ?>
<a href="<?php echo esc_url( $user->user_url ); ?>">Administrator’s Home Page</a>


<?php
// Listing 11-26. Escaping MySQL queries with $wpdb->prepare()

// not safe!
$wpdb->query( 
	"INSERT INTO $wpdb->postmeta
		( post_id, meta_key, meta_value )
		VALUES ( 1, $metakey, $metavalue )"
	);

// safe!
$wpdb->query( $wpdb->prepare( 
	"INSERT INTO $wpdb->postmeta
		( post_id, meta_key, meta_value )
		VALUES ( %d, %s, %s )", 
    1, 
	$metakey, 
	$metavalue 
) );



/************ Capabilities and Nonces Demos ****************/


// Listing 11-27. Wrapping options form fields with current_user_can()
// A variation of 11-9

function scl_simple_options_page() {
?>
<div class="wrap">
	<form method="post" id="scl_simple_options" action="options.php">
		<?php 
		settings_fields('scl_simple_options');
		$options = scl_simple_get_options();
		
		if ( current_user_can( 'manage_options' ) ) {
		?>
 	<h2><?php _e('Sample Options' ); ?></h2>   
		
		<table class="form-table">
			<tr>
				<th scope="row"><?php _e('Short Links' ); ?></th>
				<td colspan="3">
				<p>	<label>
						<input name="scl_simple_options[shortlink]" type="checkbox" value="1" <?php checked($options['shortlink'], 1); ?>/>
						<?php _e('Display a short URL on all posts and pages'); ?>
					</label></p>
				</td>
			</tr>
						
			<tr>
				<th scope="row"><?php _e('Google Verification' ); ?></th>
				<td colspan="3">
				<input type="text" id="google_meta_key" name="scl_simple_options[google_meta_key]" value="<?php echo 'foo" onchange="alert(\"Gotcha!\")"' ?>" />
				<br /><span class="description"><?php _e('Enter the verification key for the Google meta tag.' ); ?></span>
				</td>
			</tr>
		</table>
	
		<p class="submit">
		<input type="submit" value="<?php esc_attr_e('Update Options'); ?>" class="button-primary" />
		</p>
		
		<?php } // if current_user_can() ?>	
	</form>
</div>
<?php
} 



// Listing 11-28. A simple form with a nonce and a validation function 
?>
<form method="post" id="scl_simple_options" action="/">
	<?php wp_nonce_field(); ?>
	<label><?php _e('Enter a number:'); ?>
		<input type="text" id="number" name="number" value="<?php echo esc_attr($number); ?>" />
	</label>
	<input type="submit" value="<?php esc_attr_e('Update Options'); ?>" class="button-primary" />
</form>

<?php 
function scl_simple_options_validate($input) {
	
	if ( empty($input) || !wp_verify_nonce() ) {
	   echo 'You are not allowed to save this form.';
	   exit;
	}
	
	$input['number'] = intval($input['number']);
	
	return $input;
}



/************ Translation Demos ****************/


// Listing 11-29. Text hard-coded and with translation wrappers
?>
<h2>Page Options</h2>
<h2><?php _e( 'Page Options'); ?></h2>


<?php
// Listing 11-30. A translation function with the text domain argument
// a variation of 11-29
_e('Page Options', 'my-plugin');


// Listing 11-31. Debugging with wp-config.php (partial)
define( 'WP_DEBUG', true );
define( 'SCRIPT_DEBUG', true );
define( 'SAVEQUERIES', true ); 
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

?>