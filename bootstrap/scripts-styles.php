<?php
// ********************
// JavaScript enqueue
// ********************
WPUtil\Scripts::enqueue_scripts([
	'master_js' => [
		'url' => get_template_directory_uri() . '/dist/js/master.min.js',
		'deps' => [],
		'defer' => true,
		'preload_hook' => 'global_head_top_content',
		'localize' => [
			'name' => 'siteConfig',
			'data' => [
				'apiSettings' => [
					'base' => esc_url_raw(rest_url()),
					'nonce' => is_user_logged_in() ? wp_create_nonce('wp_rest') : ''
				]
			]
		]
	]
]);


// ********************
// CSS enqueue
// ********************
WPUtil\Styles::enqueue_styles([
	'master_css' => [
		'url' => get_template_directory_uri() . '/dist/css/master.min.css',
		'preload_hook' => 'global_head_top_content'
	]
]);

/**
 * Dequeue the "wp-block-library" styles on all page requests other than singular
 * post types that need it
 */
add_action('wp_enqueue_scripts', function () {
	if (is_singular(ClientNamespace\Constants\CPT::BLOG)) {
		return;
	}

	wp_dequeue_style('wp-block-library');
}, 20);
