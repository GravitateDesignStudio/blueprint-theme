<?php

/**
 * Banner
 * 
 * @package Aliat
 * 
 * @description This file sets up the banner for different banner types.
 * 
 * To create a new banner, add the type to the array, and create a file in the partials folder called
 * 
 * fields-banner-{type}.php
 * 
 * With the following variables:
 * 
 * $block str (the name of the block)
 * $block_title str (the title of the block)
 * $fields arr (the fields for the banner)
 * $location arr (the location for the banner)
 * $background_fields arr (the background fields for the banner. This is optional and only needs to be overridden if the banner has different background fields than the default banner) 
 * 
 */


$banners = [
	'default',
	'home',
	'resources'
];


// If All goes as planned, we shouldn't need to mess with anything below this line.
// -------------------------------------------------------------------------------- // 

foreach ( $banners as $banner ) :

	try {
		require("partials/fields-banner-$banner.php");
	} catch (Exception $e) {
		echo 'Caught exception: ',  $e->getMessage(), "\n";
		continue;
	}

$tab_content = array_merge(
	array (
		array (
			'key' => 'field_' . $block . '_tab_content',
			'label' => 'Content',
			'name' => $block . '_tab_content',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array (
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'left',
			'endpoint' => 0,          // end tabs to start a new group
		),
	),
	$fields,
);

$tab_background = array_merge(
	array(
		array (
			'key' => 'field_' . $block . '_tab_background',
			'label' => 'Options',
			'name' => $block . '_tab_background',
			'type' => 'tab',
			'placement' => 'left',
			'endpoint' => 0,          // end tabs to start a new group
		)
	),
	Aliat\Banners::get_banner_background_fields()
);

acf_add_local_field_group(array (
	'key' => 'group_' . $block,
	'title' => $block_title,
	'fields' => array_merge(
		$tab_content,
		$tab_background
	),
	'location' => $location,
	'menu_order' => 0,
	'position' => 'acf_after_title',                // side | normal | acf_after_title
	'hide_on_screen' => array (
	  // 1 => 'the_content',
	),
	'active' => 1,
));

endforeach;
