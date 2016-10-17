<?php
/*
Plugin Name: Sample User Directory
Plugin URI: http://stephanieleary.com/wordpress/plugins/sample-user-directory/
Description: Sample plugin that creates a directory of the site's users. Not intended to be used as-is; download and modify as needed.
Version: 1.0
License: GPLv2
Author: Stephanie Leary
Author URI: http://stephanieleary.com/
*/

/*
add_action('admin_menu', 'next_page_add_pages');

function next_page_add_pages() {
add_menu_page( 'Top Level Section', 'Top Level Section', 'manage_options', 'edu_settings', 'edu_settings_screen' );
}
/**/

/*
function add_extra_media_options() {
    add_settings_field('extra_media', __('Extra Media Option', 'sample-user-directory' ), 'extra_media_options_fields', 'media', $section = 'default', $args = array());
    register_setting('media','extra_media');
}

add_action('admin_init', 'add_extra_media_options');

// displays the options page content
function extra_media_options_fields() { ?>	
	<p> the form fields will go here </p>
<?php 
}

/**/

// change user contact fields
function edu_contact_methods( $contactmethods ) {
	// Add some fields
	$contactmethods['title'] = __('Title', 'sample-user-directory' );
	$contactmethods['phone'] = __('Phone Number', 'sample-user-directory' );
	$contactmethods['twitter'] = __('Twitter Name (no @)', 'sample-user-directory' );
	// Remove AIM, Yahoo IM, Google Talk/Jabber if they're present
	unset($contactmethods['aim']);
	unset($contactmethods['yim']);
	unset($contactmethods['jabber']);
	// make it go!
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'edu_contact_methods', 10, 1 );

// Retrieve list of users
function edu_get_users() {
	$blogusers = get_users(array(
					'fields' => 'all_with_meta',
				));

	usort($blogusers, 'edu_user_sort');

	return $blogusers;
}

// Sort list of users
function edu_user_sort($a, $b) {
    return strcmp($a->last_name, $b->last_name);
}

// Table displaying user contact information. Echo or return.
function edu_users_table( $echo = true ) {
	$users = edu_get_users();
	
	$output = '<table cellspacing="1" id="user-directory">
				<thead>
				<tr>
        		<th>'.__('Name', 'sample-user-directory' ).'</th>';
	$output .= '<th>'.__('Title', 'sample-user-directory' ).'</th>';
    $output .= '<th>'.__('Phone', 'sample-user-directory' ).'</th>';
    $output .= '<th>'.__('Email', 'sample-user-directory' ).'</th>';
	$output .= '<th>'.__('Twitter', 'sample-user-directory' ).'</th>';
    $output .= '</tr>
				</thead>
				<tbody>';
	
	foreach ($users as $user) { 
		
			$name = join( ', ', array( $user->last_name, $user->first_name ) );
			if ( !empty( $user->user_url ) )
				$name = '<a href="'.esc_url( $user->user_url ).'">' . esc_html( $name ) .'</a>';
			
			$output .= '<tr class="vcard" id="' . esc_attr( $user->user_nicename ) .'">';
            $output .= '<td class="fn uid">'.$name.'</td>';
            $output .= '<td class="title">' . esc_html( $user->title ) .'</td>';
            $output .= '<td class="tell">' . esc_html( $user->phone ) .'</td>';
            $output .= '<td class="email"><a href="mailto:' . esc_attr( $user->user_email ) .'">'. esc_html($user->user_email) .'</td>';
			$output .= '<td class="twitter">';
			if ( !empty( $user->twitter ) )
			 	$output .= '<a href="http://twitter.com/' . esc_attr( $user->twitter ) .'">@' . esc_html( $user->twitter ) . '</a>';
			$output .= '</td>';
			$output .= '</tr>';
	}
	$output .= '</tbody>
	</table>';
	
	if ($echo) {
		echo $output;
		return;
	}
	
	return $output;
}

// Create shortlink to display user info table
function edu_users_table_shortlink($atts = null, $content = null) {
	$content .= edu_users_table(false);
	return $content;
}
add_shortcode('users', 'edu_users_table_shortlink');

// Widget to display individual user profile
class EduUserProfile extends WP_Widget {

	// constructor
	function EduUserProfile() {
			$widget_ops = array('classname' => 'edu_user_profile', 'description' => __( 'A random user profile', 'sample-user-directory' ) );
			$this->WP_Widget('EduUserProfile', __('Random User', 'sample-user-directory' ), $widget_ops);
	}
	
	// widget output
	function widget( $args, $instance ) {
		extract( $args );
	
		$title = apply_filters( 'widget_title', $instance['title'] );
	
		echo $before_widget;
		if ( !empty($title) )
			echo $before_title . $title . $after_title;
	
		//$output = get_transient( 'edu_random_user' );
		if ( !isset( $output ) ) {  
		
	        // get random ID
			global $wpdb;
		//	$id = $wpdb->get_var( "SELECT ID FROM $wpdb->users ORDER BY RAND() LIMIT 1" );
			$id = 2;

			// get user
			$user = get_user_by( 'id', $id );
		
			// get instance option for gravatar size
			$size = $instance['avatar_size'];

			// display gravatar, user name linked to URL, and bio
			$output = get_avatar( $id, $size, '', $user->display_name );
			$output .= '<h3>' . esc_html( $user->display_name ) . '</h3>';
			$output .= wp_kses_post( $user->user_description );

			// cache this for a day
			set_transient( 'edu_random_user', $output, 60 * 60 * 1 );

		} // end if  

		echo $output . $after_widget;
	}
	
	// save options from widget administration screen
	function update( $new_instance, $old_instance ) {
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['avatar_size'] = intval($new_instance['avatar_size']);
			delete_transient( 'edu_random_user' );
			return $instance;
	}

	// display form fields on widget administration screen
	function form( $instance ) {
			//Defaults
			$instance = wp_parse_args( (array) $instance, array( 
					'title' => __('Featured Person', 'sample-user-directory' ),
					'avatar_size' => 150,
					));	
	?>  
       
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'sample-user-directory' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" /></p>
        
        <p><label for="<?php echo $this->get_field_id('avatar_size'); ?>"><?php _e('Size of user picture (in square pixels):', 'sample-user-directory' ); ?></label> 
        <input class="widefat" id="<?php echo $this->get_field_id('avatar_size'); ?>" name="<?php echo $this->get_field_name('avatar_size'); ?>" type="text" value="<?php echo esc_attr($instance['avatar_size']); ?>" /></p>
        
		<?php	
	}
}

// register widget
function edu_profile_widget_init() {
	register_widget('EduUserProfile');
}

// hook registration function
add_action('widgets_init', 'edu_profile_widget_init');

// Dashboard widget to list incomplete profiles
function edu_dashboard_widget() {
	$options = get_option( 'edu_dashboard' );
	if (!isset($options['limit_profiles']))
		$options['limit_profiles'] = 10;
	/*	
	// This doesn't work. NOT EXISTS is buggy. http://core.trac.wordpress.org/ticket/23849
	$args = array(
		'number' => $options['limit_profiles'],
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'first_name',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key' => 'last_name',
				'compare' => 'NOT EXISTS',
			),
		)
	 );
	/**/
	
	/*
	// This doesn't work. NOT EXISTS is buggy. http://core.trac.wordpress.org/ticket/23849
	$args = array(
		'number' => $options['limit_profiles'],
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'phone',
				'compare' => 'NOT EXISTS',
			),
			array(
				'key' => 'twitter',
				'compare' => 'NOT EXISTS',
			),
		)
	 );
	/**/
	
	//*
	$args = array(
		'number' => $options['limit_profiles'],
		'meta_query' => array(
			'relation' => 'OR',
			array(
				'key' => 'first_name',
				'compare' => '=',
				'value' => '',
			),
			array(
				'key' => 'last_name',
				'compare' => '=',
				'value' => '',
			),
		)
	);
	/**/
	
	$users = new WP_User_Query( $args );
	
	//var_dump($users); exit;
	
	if ( $users->total_users ) {
		echo '<ol class="incomplete-profiles">';
	
		foreach ( $users->results as $user ) {
			echo '<li><a href="' . get_edit_user_link( $user->user_id ) .'">' . $user->display_name . '</a></li>';	
		}
		
		echo '</ol>';
	}
}

function edu_dashboard_widget_control() {
		if ( isset($_POST['edu_dashboard[limit_profiles]']) ) {
			update_option( 'edu_dashboard', absint($_POST['edu_dashboard[limit_profiles]']) );
		}
		$options = get_option( 'edu_dashboard' );
		if (!isset($options['limit_profiles']))
			$options['limit_profiles'] = 10;
	?>
	<p>
	<label for="limit_profiles"><?php _e( 'Limit to the first ', 'sample-user-directory' ); ?>
		<input type="text" id="limit_profiles" name="edu_dashboard[limit_profiles]" value="<?php esc_attr_e( $options['limit_profiles'] ); ?>" size="4" />	<?php _e( ' profiles', 'sample-user-directory' ); ?></label>
	</p>
<?php
}
 
function edu_dashboard_widget_setup() {
	wp_add_dashboard_widget( 'edu_dashboard_widget', __('Incomplete User Profiles', 'sample-user-directory' ), 'edu_dashboard_widget', 'edu_dashboard_widget_control');
}

add_action('wp_dashboard_setup', 'edu_dashboard_widget_setup');
			 

// Register settings and add CSS to settings screen only
add_action('admin_menu', 'edu_add_pages');
function edu_add_pages() {
	$page = add_options_page( __('User Profile Visibility', 'sample-user-directory' ), __('User Profile Visibility', 'sample-user-directory' ), 'manage_options', 'edu_settings', 'edu_settings_screen' );
	register_setting( 'edu_settings', 'edu_settings_group', 'edu_settings_validate');
	// These lines are not used in this plugin, but have been left here for reference
	// add_action( 'admin_print_scripts-'.$page, 'edu_settings_js');
	// add_action( 'admin_print_styles-'.$page, 'edu_settings_css' ); 
}

// add JS and CSS to settings page only
// These functions are never called, unless you un-comment the add_action lines inside edu_add_pages()
function edu_settings_js() {
	wp_enqueue_script( 'my-plugin-script', plugins_url( '/my-plugin-script.js' ) );
}

function edu_settings_css() {
	wp_enqueue_style( 'my-plugin-stylesheet', plugins_url( '/my-plugin-style.css' ) );
}

// Settings screen
function edu_settings_screen() {
?>
<div class="wrap">
	<form method="post" id="sample_user_directory" action="options.php">
		<?php 
		settings_fields('edu_settings_group');
		$options = get_option('edu_settings');
		if (empty($options))
			$options = array(
				'user_email' => '1',
				'user_url' => '1',
				'title' => '1',
				'phone' => '1',
				'twitter' => '1',
			);
		if ( current_user_can( 'manage_options' ) ) {
		?>
 	<h2><?php _e('User Profile Visibility', 'sample-user-directory' ); ?></h2>  

	<p><?php _e('Please choose which profile fields should be visible in the user directory.', 'sample-user-directory' ); ?></p>
	
	<table class="form-table">
		<tr>
			<th scope="row"><label for="edu_settings[user_firstname]"> <?php _e( 'First Name', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[user_firstname]" type="checkbox" value="1" checked="checked" disabled="disabled" /> </td>
		</tr>
		<tr>
			<th scope="row"><label for="edu_settings[user_lastname]"> <?php _e( 'Last Name', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[user_lastname]" type="checkbox" value="1" checked="checked" disabled="disabled" /> </td>
		</tr>
		<tr>
			<th scope="row"><label for="edu_settings[user_email]"> <?php _e( 'Email Address', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[user_email]" type="checkbox" value="1" <?php checked($options['user_email'], '1'); ?> /> </td>
		</tr>
		
		<tr>
			<th scope="row"><label for="edu_settings[user_url]"> <?php _e( 'Website Address', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[user_url]" type="checkbox" value="1" <?php checked($options['user_url'], '1'); ?> /> </td>
		</tr>
		
		<tr>
			<th scope="row"><label for="edu_settings[title]"> <?php _e( 'Title', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[title]" type="checkbox" value="1" <?php checked($options['title'], '1'); ?> /> </td>
		</tr>
		
		<tr>
			<th scope="row"><label for="edu_settings[phone]"> <?php _e( 'Phone Number', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[phone]" type="checkbox" value="1" <?php checked($options['phone'], '1'); ?> /> </td>
		</tr>
		
		<tr>
			<th scope="row"><label for="edu_settings[twitter]"> <?php _e( 'Twitter Username', 'sample-user-directory' ); ?> </label></th>
			<td> <input name="edu_settings[twitter]" type="checkbox" value="1" <?php checked($options['twitter'], '1'); ?> /> </td>
		</tr>
	</table>

	<p class="submit">
	<input type="submit" value="<?php esc_attr_e( 'Update Options', 'sample-user-directory' ); ?>" class="button-primary" />
	</p>
		
	<?php } // if current_user_can() ?>	
	</form>
</div>
<?php
}

// Validation callback
function edu_settings_validate($input) {
	// first and last name are required and disabled
	unset( $input['user_firstname'] );
	unset( $input['user_lastname'] );
	// all others should be positive integers
	$input = array_walk( $input, 'absint' );
	return $input;
}

// when uninstalled, remove option
register_uninstall_hook( __FILE__, 'edu_delete_options' );

function edu_delete_options() {
	delete_option( 'edu_settings' );
}

// i18n
load_plugin_textdomain( 'sample-user-directory', '', plugin_dir_path(__FILE__) . '/languages' );