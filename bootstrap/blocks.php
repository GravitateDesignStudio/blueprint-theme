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
 * Enforce background color choices
 */
WPUtil\Vendor\BlueprintBlocks::enforce_background_colors([
	'block-bg-none' => 'None',
	'block-bg-image' => 'Image',
	'bg-white' => 'White',
	'bg-black' => 'Black',
	'bg-blue' => 'Blue',
	'bg-red' => 'Red',
	'bg-gray' => 'Gray'
]);

/**
 * Enforce which blocks are allowed to use the animate functionality
 */
WPUtil\Vendor\BlueprintBlocks::allow_animate_option_for_blocks([]);

/**
 * Hide unused default blocks from the blocks admin panel
 */
WPUtil\Vendor\BlueprintBlocks::hide_unused_blocks([]);

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
