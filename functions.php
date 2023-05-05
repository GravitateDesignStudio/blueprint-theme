<?php
if (!defined('ABSPATH')) {
	exit;
}

// Check if ACF plugin is active
// if ( ! is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
//     // ACF is not active, prevent theme installation
//     add_action( 'admin_init', 'my_theme_admin_notice' );
//     add_action( 'wp_ajax_my_theme_activate', 'my_theme_ajax_activate_callback' );
//     add_action( 'wp_ajax_nopriv_my_theme_activate', 'my_theme_ajax_activate_callback' );
//     switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );
//     exit;
// }


// Admin notice
function my_theme_admin_notice() {
    echo '<div class="error"><p>' . __( 'This theme requires the Advanced Custom Fields plugin to be active.', 'my-theme' ) . '</p></div>';
}

// AJAX activation callback
function my_theme_ajax_activate_callback() {
    wp_send_json_error( __( 'This theme requires the Advanced Custom Fields plugin to be active.', 'my-theme' ) );
    exit;
}



// check for/require composer autoloader
if (!file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
	die("The required composer dependencies must be installed for this theme. Please run 'composer install' from the theme root.");
}

require_once 'vendor/autoload.php';

// check for existence of dfrei/wp-util package
if (!class_exists('\WPUtil\Content')) {
	die("The 'dfrei/wp-util' composer package is required for this theme. Please run 'composer install' from the theme root.");
}

// redirect image URLs for local development
if (defined('LOCAL_IMAGE_REDIRECT') && WP_HOME !== null && stripos(WP_HOME, '.local.com') !== -1) {
	WPUtil\Dev\Image::local_image_redirect(LOCAL_IMAGE_REDIRECT);
}

require_once 'bootstrap/theme-setup.php';
require_once 'bootstrap/performance.php';
require_once 'bootstrap/media.php';
require_once 'bootstrap/scripts-styles.php';
require_once 'bootstrap/custom-post-types.php';
require_once 'bootstrap/taxonomies.php';
require_once 'bootstrap/acf.php';
require_once 'bootstrap/menus.php';
require_once 'bootstrap/tinymce.php';
require_once 'bootstrap/plugins.php';
require_once 'bootstrap/blocks.php';
require_once 'bootstrap/theme-settings-pages.php';
require_once 'bootstrap/api.php';
require_once 'bootstrap/hello-bar.php';
require_once 'bootstrap/virtual-pages.php';
require_once 'bootstrap/pre-get-posts.php';
