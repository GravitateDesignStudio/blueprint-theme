<?php
// Add menu shortcode that allows to add sitemap menu to wysiwyg
add_shortcode('menu', function ($atts, $content = null) {
	extract(shortcode_atts(['name' => null], $atts));

	return wp_nav_menu([
		'menu' => $name,
		'echo' => false
	]);
});

$default_menus = array(
	'main-menu' => 'Main Menu',                 // main nav in header
	'main-links' => 'Main Utility Links',       // main nav in header
	'footer-menu' => 'Footer Menu',             // secondary nav in footer
	'footer-links' => 'Footer Utility Links',   // secondary nav in footer
	'mobile-menu' => 'Mobile Menu',             // Mobile nav in header
	'mobile-links' => 'Mobile Utility Links',   // Mobile nav in header
	'sitemap-menu' => 'Sitemap Menu'            // Sitemap Links
);

WPUtil\ThemeSupport::register_menus($default_menus);
