<?php
/*
Plugin Name: Course Post Types
Description: Setting up course post types for a university department.
Version: 1.2
Author: Stephanie Leary
Author URI: http://stephanieleary.com
License: GPL2
*/

// Sort courses by code and disable paging (show all) on course archive pages

add_filter( 'pre_get_posts', 'alphabetize_courses' );

function alphabetize_courses( $query ) {
	if ( is_post_type_archive('course') ) {
		$query->set( 'orderby', 'title' );
		$query->set( 'order', 'ASC' );
		$query->set( 'nopaging', true );
	}
	return $query;
}

/* Content Types */

add_action('init', 'post_type_courses');
register_activation_hook( __FILE__, 'activate_course_type' );

function activate_course_type() {
	post_type_courses();
	flush_rewrite_rules();
}

function post_type_courses() {
	register_post_type(
		'course', 
			array(
			'labels' => array(
				'name' => __( 'Courses' ),
				'singular_name' => __( 'Course' ),
				'add_new' => __('Add New'),
				'add_new_item' => __('Add New Course'),
				'edit_item' => __('Edit Course'),
				'new_item' => __('New Course'),
				'view_item' => __('View Course'),
				'search_items' => __('Search Courses'),
				'not_found' => __('No courses found'),
				'not_found_in_trash' => __('No courses found in Trash'),
				'menu_name' => __('Courses'),
			),
			'capability_type' => 'post',
			'description' => __('Individual course data'),
			'register_meta_box_cb' => 'course_meta_boxes',
			'public' => true, 
			'show_ui' => true,
			'hierarchical' => false,
			'has_archive' => true,
			'supports' => array(
				'title',
				'editor',
				'author',
				'excerpt',
				'custom-fields',
				'revisions',
				'page-attributes',
			)
		) 
	);
}

/* Taxonomies */

add_action('init', 'create_course_tax');
register_activation_hook( __FILE__, 'activate_course_tax' );
 
function activate_course_tax() {
	create_course_tax();
	flush_rewrite_rules();
}

function create_course_tax() {
	register_taxonomy(
		'colleges',
		'course',
		array(
			'labels' => array(
			    'name'                => _x( 'Colleges', 'taxonomy general name' ),
			    'singular_name'       => _x( 'College', 'taxonomy singular name' ),
			    'search_items'        => __( 'Search Colleges' ),
			    'all_items'           => __( 'All Colleges' ),
			    'parent_item'         => __( 'Parent College' ),
			    'parent_item_colon'   => __( 'Parent College:' ),
			    'edit_item'           => __( 'Edit College' ), 
			    'update_item'         => __( 'Update College' ),
			    'add_new_item'        => __( 'Add New College' ),
			    'new_item_name'       => __( 'New College Name' ),
			    'menu_name'           => __( 'Colleges' ),
				'separate_items_with_commas' => __( 'Separate colleges with commas' ),
				'add_or_remove_items' => __( 'Add or remove colleges' ),
				'choose_from_most_used' => __( 'Choose from the most used colleges' ),
			  ),
		'hierarchical' => true,
		'show_admin_column' => true,
		)
	);
	
	register_taxonomy(
		'departments',
		'course',
		array(
			'labels' => array(
			    'name'                => _x( 'Departments', 'taxonomy general name' ),
			    'singular_name'       => _x( 'Department', 'taxonomy singular name' ),
			    'search_items'        => __( 'Search Departments' ),
			    'all_items'           => __( 'All Departments' ),
			    'parent_item'         => __( 'Parent Department' ),
			    'parent_item_colon'   => __( 'Parent Department:' ),
			    'edit_item'           => __( 'Edit Department' ), 
			    'update_item'         => __( 'Update Department' ),
			    'add_new_item'        => __( 'Add New Department' ),
			    'new_item_name'       => __( 'New Department Name' ),
			    'menu_name'           => __( 'Departments' ),
				'separate_items_with_commas' => __( 'Separate departments with commas' ),
				'add_or_remove_items' => __( 'Add or remove departments' ),
				'choose_from_most_used' => __( 'Choose from the most used departments' ),
			  ),
		'hierarchical' => false,
		'show_admin_column' => true,
		)
	);
	
	register_taxonomy(
		'people',
		'post',
		array(
			'labels' => array(
				'name'	=> _x( 'People', 'taxonomy general name' ),
				'singular_name'	=> _x( 'Person', 'taxonomy singular name' ),
				'search_items'	=> __( 'Search People' ),
				'all_items'	=> __( 'All People' ),
				'edit_item'           	=> __( 'Edit Person' ), 
				'update_item'         	=> __( 'Update Person' ),
				'add_new_item'        	=> __( 'Add New Person' ),
				'new_item_name'       	=> __( 'New Person Name' ),
				'menu_name'           	=> __( 'People' ),
				'separate_items_with_commas' => __( 'Separate people with commas' ),
				'add_or_remove_items'	=> __( 'Add or remove people' ),
				'choose_from_most_used' => __( 'Choose from the most used people' ),
				),
			'hierarchical' => false,
			'show_admin_column' => true, 
			)
	);	
}

/* Custom Fields */

add_action( 'save_post', 'save_course_meta_data' );

function course_meta_boxes() {
	add_meta_box( 'course_code_meta', __('Course Code'), 'course_code_meta_box', 'course', 'normal', 'high' );
	add_meta_box( 'instructor_meta', __('Instructors'), 'instructor_meta_box', 'course', 'normal', 'high' );
}

function course_code_meta_box() {
	if ( function_exists('wp_nonce_field') ) 
		wp_nonce_field('course_code_nonce', '_course_code_nonce'); 
?>
	<p><label for="_course_code">Course Code (e.g. ENGL 101)</label> 
	<input type="text" name="_course_code" 
		value="<?php echo esc_html( get_post_meta( get_the_ID(), '_course_code', true ), 1 ); ?>" /></p>
		
<?php
}

function instructor_meta_box() { 
	global $post; 
	if ( function_exists('wp_nonce_field') ) wp_nonce_field('instructor_nonce', '_instructor_nonce'); 
?> 
	<p><label for="_instructor_name">Name</label> 
	<input type="text" name="_instructor_name" 
		value="<?php echo esc_html( get_post_meta( get_the_ID(), '_instructor_name', true ), 1 ); ?>" /></p>
	<p><label for="_instructor_email">Email</label> 
	<input type="text" name="_instructor_email" 
		value="<?php echo esc_html( get_post_meta( get_the_ID(), '_instructor_email', true ), 1 ); ?>" /></p>
	<p><label for="_instructor_phone">Phone</label> 
	<input type="text" name="_instructor_phone" 
		value="<?php echo esc_html( get_post_meta( get_the_ID(), '_instructor_phone', true ), 1 ); ?>" /></p>

<?php
}

function save_course_meta_data( $post_id ) {
	// ignore autosaves
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
		return $post_id;
		
	// check post type
	if ( 'course' != $_POST['post_type'] )
		return $post_id;
		
	// check capabilites
	if ( 'course' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
		return $post_id;
		
	// check nonces
	check_admin_referer( 'course_code_nonce', '_course_code_nonce' );
	check_admin_referer( 'instructor_nonce', '_instructor_nonce' );
	
	// Still here? Then save the fields
	if ( empty( $_POST['_course_code'] ) ) {
		$storedcode = get_post_meta( $post_id, '_course_code', true );
		delete_post_meta( $post_id, '_course_code', $storedcode );
	}
	else 
		update_post_meta( $post_id, '_course_code', $_POST['_course_code'] );

	if ( empty( $_POST['_instructor_name'] ) ) {
		$storedname = get_post_meta( $post_id, '_instructor_name', true );
		delete_post_meta( $post_id, '_instructor_name', $storedname );
	}
	else 
		update_post_meta( $post_id, '_instructor_name', $_POST['_instructor_name'] );

	if ( empty( $_POST['_instructor_email'] ) ) {
		$storedemail = get_post_meta( $post_id, '_instructor_email', true );
		delete_post_meta( $post_id, '_instructor_email', $storedemail );
	}
	else 
		update_post_meta( $post_id, '_instructor_email', $_POST['_instructor_email'] );

	if ( empty( $_POST['_instructor_phone'] ) ) {
		$storedphone = get_post_meta( $post_id, '_instructor_phone', true );
		delete_post_meta( $post_id, '_instructor_phone', $storedphone );
	}
	else 
		update_post_meta( $post_id, '_instructor_phone', $_POST['_instructor_phone'] );

}

/* Custom Edit Columns */

add_filter('manage_edit-course_columns', 'course_taxonomy_columns');

// rearrange the columns on the Edit screens
function course_taxonomy_columns( $defaults ) {
	// preserve the first column containing the bulk edit checkboxes
	if ( isset( $defaults['cb'] ) ) 
		$cb = $defaults['cb'];

	// remove some default columns
	unset( $defaults['cb'] );
	unset( $defaults['comments'] );
	unset( $defaults['date'] );
	unset( $defaults['author'] );  

	// insert checkbox and course code columns
	$newcolumns = array( 'cb' => $cb, 'course_code' => __('Code') ); 
	
	// followed by remaining defaults
	$newcolumns += $defaults;
	
	// then append custom field columns
	$newcolumns += array( 'instructor' => __('Instructor') );
	
	return $newcolumns;
}

// add_action("manage_pages_custom_column", "course_custom_column");
// for non-hierarchical content types, use the following instead:
add_action('manage_posts_custom_column', 'course_custom_column', 10, 2);

// print the contents of the custom columns
function course_custom_column( $column, $id ) {
	switch ( $column ) {
		case 'course_code':
		 	$code = get_post_meta( $id, '_course_code', true );
			if ( !empty( $code))
				echo esc_html( $code );
			break;
		case 'instructor':
		 	$name = get_post_meta( $id, '_instructor_name', true );
			if ( !empty( $name ) )
				echo esc_html( $name );
			break;
		default:
			break;
	}
}

// make the Code column sortable
add_filter( 'manage_edit-course_sortable_columns', 'course_column_sortable' );

function course_column_sortable( $columns ) {
    $columns['course_code'] = 'course_code';
    return $columns;
}

add_filter( 'request', 'course_column_orderby' );

function course_column_orderby( $queryvars ) {
    if ( isset( $queryvars['orderby'] ) && $queryvars['orderby'] == 'course_code' ) {
        $queryvars = array_merge( $queryvars, array(
            'meta_key' => '_course_code',
            'orderby' => 'meta_value'
        ) );
    }
    return $queryvars;
}
?>