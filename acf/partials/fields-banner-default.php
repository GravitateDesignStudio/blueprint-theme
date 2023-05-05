<?php

$block = 'banner_default';
$block_title = "Banner";

include('fields-patterns.php');

$fields = array (
    array (
        'key' => 'field_'.$block.'_eyebrow',
        'label' => 'Eyebrow',
        'name' => $block.'_eyebrow',
        'type' => 'text',
        'instructions' => 'Small text above the main page title (optional)',
    ),
    array (
        'key' => 'field_' . $block . '_title_override',
        'label' => 'Title (override)',
        'name' => $block . '_title_override',
        'type' => 'text',
        'instructions' => 'The default page title will be used if this field is empty',
    ),
);

$fields = array_merge($fields, $repeater_buttons);

$location = array(
    array(
        array(
            'param' => 'page_type',
            'operator' => '!=',
            'value' => 'front_page',
        ),
    ),
);