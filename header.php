<?php
use ClientNamespace\Constants;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<?php
	do_action('global_head_top_content');

	if (!defined('IGNORE_USER_SCRIPTS') || !constant('IGNORE_USER_SCRIPTS')) {
		the_field(Constants\ACF::THEME_OPTIONS_SCRIPTS_BASE . '_global_head_top_content', 'option', false);
	}

	?>
	<title><?php bloginfo('name'); ?> <?php wp_title('&bull;'); ?></title>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="application-name" content="<?php bloginfo('name'); ?>">

	<?php /* TODO: generate a favicon at https://realfavicongenerator.net */ ?>
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

	<?php
	wp_head();

	if (!defined('IGNORE_USER_SCRIPTS') || !constant('IGNORE_USER_SCRIPTS')) {
		the_field(Constants\ACF::THEME_OPTIONS_SCRIPTS_BASE . '_global_head_bottom_content', 'option', false);
	}
	?>
</head>
<body id="body" <?php body_class(); ?>>
	<?php
	if (!defined('IGNORE_USER_SCRIPTS') || !constant('IGNORE_USER_SCRIPTS')) {
		the_field(Constants\ACF::THEME_OPTIONS_SCRIPTS_BASE . '_global_body_top_content', 'option', false);
	}

	WPUtil\Component::render('components/header');
