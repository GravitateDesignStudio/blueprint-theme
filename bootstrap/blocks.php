<?php
/**
 * Remove default JavaScript output by the blocks plugin
 */
add_filter('grav_blocks_output_default_js', function () {
	return false;
});

/**
 * Remove default styles output by the blocks plugin
 */
add_filter('grav_blocks_output_default_styles', function () {
	return false;
});

/**
 * Override values for Blueprint Blocks plugin settings
 */
add_filter('grav_blocks_plugin_settings', function ($settings, $option_key) {
	// All default blocks should be disabled
	$settings['blocks_enabled_default'] = [];

	// All theme blocks should be enabled
	$settings['blocks_enabled_theme'] = WPUtil\Vendor\BlueprintBlocks::get_theme_blocks_list();

	// Specify which post types the blocks editor should be visible on
	$settings['post_types'] = [
		ClientNamespace\Constants\CPT::BLOG,
		'page',
		'global-block'
	];

	// Specify which page templates the blocks editor should be visible on
	$settings['templates'] = [
		// ex: 'templates/page-template-name.php'
	];

	// Specify which taxonomies the blocks editor should be visible on
	$settings['taxonomies'] = [];

	// Specify which advanced options are enabled. This array may contain the
	// following strings: filter_content, filter_excerpt, after_title, hide_content
	$settings['advanced_options'] = [];

	return $settings;
}, 10, 2);

/**
 * Remove unused Blueprint Blocks plugin settings fields
 */
add_filter('grav_blocks_settings_fields', function ($fields, $location) {
	// Remove the fields for enabling/disabling individual blocks
	unset($fields['blocks_enabled_default']);
	unset($fields['blocks_enabled_theme']);

	// Remove the fields for enabling/disabling blocks on post types
	unset($fields['post_types']);

	// Remove the fields for enabling/disabling blocks on page templates
	unset($fields['templates']);

	// Remove the fields for enabling/disabling blocks on taxonomies
	unset($fields['taxonomies']);

	// The Google Maps fields used within this theme are located under "Theme Settings / Integrations / Google Maps".
	unset($fields['google_maps_api_key']);
	unset($fields['google_maps_styles']);
	unset($fields['google_maps_default_lat_lng']);
	unset($fields['google_maps_default_zoom']);

	// Remove the "Advanced / Advanced Options" fields
	unset($fields['advanced_options']);

	return $fields;
}, 10, 2);

/**
 * Enforce background color choices
 */
WPUtil\Vendor\BlueprintBlocks::enforce_background_colors([
	'block-bg-none' => 'None',
	// 'block-bg-image' => 'Image',
	'bg-white' => 'White',
	'bg-black' => 'Black',
	'bg-blue' => 'Blue',
	'bg-red' => 'Red',
	'bg-gray' => 'Gray'
]);

/**
 * Only allow specific background colors for the specified blocks
 */
WPUtil\Vendor\BlueprintBlocks::restrict_backgrounds_for_blocks([
	// ex: 'block_name' => ['block-bg-none', 'bg-gray']
]);

/**
 * Enforce which blocks are allowed to use the animate functionality
 */
WPUtil\Vendor\BlueprintBlocks::allow_animate_option_for_blocks([]);

/**
 * Make sure blocks appear in alphabetical order by label in the flexible content field
 */
WPUtil\Vendor\BlueprintBlocks::sort_block_names_alphabetically();

/**
 * Ensure Grav Blocks are viewable on the pages that require them
 */
add_filter('grav_is_viewable', function ($is_viewable) {
	if (is_home() || is_singular() || is_404() || is_search()) {
		$is_viewable = true;
	}

	return $is_viewable;
});

/**
 * Add 'wysiwyg' class to content (v2) block columns
 */
add_filter('grav_get_css', function ($css, $block_name) {
	if (in_array($block_name, ['content', 'contentv2'], true) && in_array('columns', $css, true)) {
		$css[] = 'wysiwyg';
	}

	return $css;
}, 10, 2);

/**
 * Add 'grav_blocks' field to default post and page WP REST API responses
 */
add_action('rest_api_init', function () {
	register_rest_field(['post', 'page'], 'grav_blocks', [
		'get_callback' => function ($post) {
			return get_field('grav_blocks');
		}
	]);
});

/**
 * Prevent the video URL from being processed/formatted by the blocks plugin
 */
add_filter('grav_blocks_process_video_url', function ($process_video, $url) {
	return false;
}, 10, 2);
