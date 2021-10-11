<?php
// Add menu shortcode that allows for adding a sitemap menu to WYSIWYG editors
add_shortcode('menu', function ($atts, $content = null) {
	$params = shortcode_atts([
		'name' => ''
	], $atts);

	if (!$params['name']) {
		return '';
	}

	return wp_nav_menu([
		'menu' => $params['name'],
		'echo' => false
	]);
});
