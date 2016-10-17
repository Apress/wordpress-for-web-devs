<?php
// Display the options page
function us2011_options_page() {
?>
<div class="wrap">
	<form method="post" id="us2011_theme" action="options.php">
		<?php 
		settings_fields('us2011_theme');
		$options = us2011_get_options();
		?>
		<h2><?php _e('Theme Options' ); ?></h2>
		<?php
		if (isset($_GET['settings-updated'])) {
		?>
			<div class="updated"><p>Settings updated.</p></div>
		<?php } ?>
		<table class="form-table ui-tabs-panel">
			<tr>
				<th scope="row"><?php _e('Layout' ); ?></th>
				<td>
					<label>
						<input name="us2011_theme[layout]" type="radio" value="left" <?php checked($options['layout'], 'left'); ?>/>
						<?php _e('Main Content on the Left'); ?>
						<img src="<?php bloginfo('template_url'); ?>/images/layout-left.png" class="layout" />
					</label>
				</td><td>	
					<label>
						<input name="us2011_theme[layout]" type="radio" value="right" <?php checked($options['layout'], 'right'); ?> />
						<?php _e('Main Content on the Right'); ?>
						<img src="<?php bloginfo('template_url'); ?>/images/layout-right.png" class="layout" />
					</label>	
				</td>
				<td></td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Color Scheme'); ?></th>
				<td>
					<label>
						<input name="us2011_theme[colors]" type="radio" value="blue" <?php checked($options['colors'], 'blue'); ?>/>
						<?php _e('Blue'); ?> 
						<div class="gradient" id="blue">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>	
					</label>
					<br />
					<label>
						<input name="us2011_theme[colors]" type="radio" value="green" <?php checked($options['colors'], 'green'); ?> />
						<?php _e('Green'); ?>
						<div class="gradient" id="green">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>
					</label>
				</td><td>
					<label>
						<input name="us2011_theme[colors]" type="radio" value="teal" <?php checked($options['colors'], 'teal'); ?>/>
						<?php _e('Teal'); ?>
						<div class="gradient" id="teal">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>
					</label>
					<br />
					<label>
						<input name="us2011_theme[colors]" type="radio" value="gold" <?php checked($options['colors'], 'gold'); ?>/>
						<?php _e('Gold'); ?>
						<div class="gradient" id="gold">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>
					</label>
				</td><td>
					<label>
						<input name="us2011_theme[colors]" type="radio" value="purple" <?php checked($options['colors'], 'purple'); ?>/>
						<?php _e('Purple'); ?>
						<div class="gradient" id="purple">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>
					</label>
					<br />
					<label>
						<input name="us2011_theme[colors]" type="radio" value="maroon" <?php checked($options['colors'], 'maroon'); ?>/>
						<?php _e('Maroon'); ?>
						<div class="gradient" id="maroon">
							<div class="first"></div>
							<div class="second"></div>
							<div class="third"></div>
							<div class="fourth"></div>
							<div class="fifth"></div>
						</div>
					</label>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Problem Report' ); ?></th>
				<td colspan="3">
				<?php wp_dropdown_pages( array( 'name' => 'us2011_theme[problem_report]', 'selected' => $options['problem_report'], ) );  ?><br />
				<span  class="description"><?php
				_e('If you have created a form where people can report problems with the site, choose its page here.<br />
					If not, a general contact page will do.' );
				?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Home Page Category' ); ?></th>
				<td colspan="3">
				<?php wp_dropdown_categories( array(
				    'show_option_all'    => 'None (latest news from all categories)',
				    'hide_empty'         => 0, 
				    'selected'           => $options['home_cat'],
				    'hierarchical'       => 1, 
				    'name'               => 'us2011_theme[home_cat]', ) ); ?> <br />
				<span class="description"><?php
				_e("Choose a category for the posts shown in the main column of the home page." );
				?></span>
				</td>
			</tr>
			<tr>
				<th scope="row"><?php _e('Short Links' ); ?></th>
				<td colspan="3">
				<p>	<label>
						<input name="us2011_theme[shortlink]" type="checkbox" value="1" <?php checked($options['shortlink'], 1); ?>/>
						<?php _e('Display a short URL on all posts and pages'); ?>
					</label></p>
				<?php
				if (function_exists('dm_domains_admin')) : // Domain Mapping is activated
					global $wpdb, $blog_id;
					$wpdb->dmtable = $wpdb->base_prefix . 'domain_mapping';
					$rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->dmtable} WHERE blog_id = %d", $blog_id ) );
				?>
				<p>Use domain:<br />
				<?php foreach ($rows as $domain) : ?>
				<label>
					<input name="us2011_theme[shortlink_url]" type="radio" value="<?php echo $domain->domain; ?>" <?php checked($options['shortlink_url'], $domain->domain); ?>/>
					<?php echo $domain->domain; ?>
				</label> <br />
				<?php endforeach; ?>
				<span class="description"><?php
				_e("The shortest available domain is usually best." );
				?></span>
				</p>
				<?php endif; ?>
				</td>
			</tr>			
			<tr>
				<th scope="row"><?php _e('Google Verification' ); ?></th>
				<td colspan="3">
				<input type="text" size="60" id="google_meta_key" name="us2011_theme[google_meta_key]" value="<?php esc_attr_e($options['google_meta_key']); ?>" /><br />
				<span class="description"><?php
				_e('Enter the verification key for the Google meta tag.' );
				?></span>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input type="submit" value="<?php esc_attr_e('Update Options'); ?>" class="button-primary" />
		</p>
		<!-- <h2>Debug Report</h2>
			<pre><?php //print_r($options); ?></pre>   -->
		
	</form>
</div>
<?php
}

function us2011_options_css() { ?>
	<style type="text/css">
	table.form-table th { text-align: left; }
	table.form-table td, table.form-table th { vertical-align: top; padding-bottom: 1.6em; }
	
	img.layout { display: block; }
	
	div.gradient { height: 2em; width: 12em; overflow: auto; }
	div.gradient div { height: 2em; width: 2em; float: left; }
	
	#blue .first { background: #1d3362; }
	#blue .second { background: #4a5c81; }
	#blue .third { background: #7785a1; }
	#blue .fourth { background: #a5adc0; }
	#blue .fifth { background: #d2d6e0; }
	
	#green .first { background: #7e7a00; }
	#green .second { background: #989533; }
	#green .third { background: #b2af66; }
	#green .fourth { background: #cbca99; }
	#green .fifth { background: #e5e4cc; }
	
	#gold .first { background: #998031; }
	#gold .second { background: #ad995a; }
	#gold .third { background: #c1b383; }
	#gold .fourth { background: #d6ccad; }
	#gold .fifth { background: #eae6d6; }
	
	#teal .first { background: #104554; }
	#teal .second { background: #406a76; }
	#teal .third { background: #708f98; }
	#teal .fourth { background: #9fb5bb; }
	#teal .fifth { background: #cfdadd; }
	
	#purple .first { background: #5b447a; }
	#purple .second { background: #7c6995; }
	#purple .third { background: #9d8faf; }
	#purple .fourth { background: #bdb4ca; }
	#purple .fifth { background: #dedae4; }
	
	#maroon .first { background: #500000; }
	#maroon .second { background: #555; }
	#maroon .third { background: #999; }
	#maroon .fourth { background: #ccc; }
	#maroon .fifth { background: #eee; }
	</style>
<?php
}

// Add menu page and register setting
add_action('admin_menu', 'us2011_add_pages');
function us2011_add_pages() {
	$pg = add_theme_page("Theme Options", "Theme Options", 'edit_pages', basename(__FILE__), 'us2011_options_page');
	add_action("admin_head-$pg", 'us2011_options_css');
	register_setting( 'us2011_theme', 'us2011_theme', 'us2011_validate_options');
}

// set defaults
function us2011_get_options() {
	$defaults = array(
			'colors'			=> 'maroon',
			'layout'			=> 'left',
			'problem_report'	=> 0,
			'sitemap'			=> 0,
			'home_cat'			=> 0,
			'shortlink'			=> 1,
			'shortlink_url'		=> home_url(),
			'google_meta_key'	=> '',
	);
	$options = get_option('us2011_theme');
	if (!is_array($options)) {
		add_option( 'us2011_theme', $defaults, '', 'yes' );
		$options = array();
	}
	return array_merge( $defaults, $options );
}

// Validation/sanitization
function us2011_validate_options($input) {
	$options = us2011_get_options();
	
	$input['problem_report'] = (int)$input['problem_report'];
	$input['home_cat'] = (int)$input['home_cat'];	
	if ( !in_array( $input['colors'], array( 'blue','green','gold','teal','purple','maroon') ) )
		$input['colors'] = 'maroon';
	if ( !in_array( $input['layout'], array( 'left','right') ) )
		$input['colors'] = 'left';
	
	if (!isset($input['shortlink']))
		$input['shortlink'] = '';
	if (!isset($input['shortlink_url']))
		$input['shortlink_url'] = $options['shortlink_url'];
	
	if (!isset($input['google_meta_key']))
		$input['google_meta_key'] = $options['google_meta_key'];
	
	// make sure there is a sitemap
	if (!post_exists('Sitemap') && !post_exists('Site Map')) {
		$post = array();		
		$post['post_title'] = 'Sitemap';	
		$post['post_content'] = '';
		$post['post_author'] = wp_get_current_user();
		$post['post_author'] = $post['post_author']->ID;
		$post['post_type'] = 'page';
		$post['post_status'] = 'publish';
		$id = wp_insert_post($post);
		if (!is_wp_error($id)) {
			// set page template
			add_post_meta($id, '_wp_page_template', 'sitemap.php', true);
			$input['sitemap'] = $id;
		}
	}
	else $input['sitemap'] = $options['sitemap']; // preserve it if it already exist
	
	return $input;
}
?>