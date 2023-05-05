<?php

$block = 'banner_home';
$block_title = "Banner Home";


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
    array (
        'param' => 'page_type', // post_type | post | page | page_template | post_category | taxonomy | options_page
        'operator' => '==',
        'value' => 'front_page',      // if options_page then use: acf-options  | if page_template then use:  template-example.php
        'order_no' => 0,
        'group_no' => 1,
    ),
    array (
        'key' => 'field_'.$block.'_description',
        'label' => 'Description',
        'name' => $block.'_description',
        'type' => 'wysiwyg',
        'default_value' => '',
        'tabs' => 'all',  // all | visual | text
        'toolbar' => 'basic',  // full | basic
        'media_upload' => 0,
    ),
);

$oembed = array (
    array (
        'key' => 'field_'.$block.'_video',
        'label' => 'Video',
        'name' => $block.'_video',
        'type' => 'oembed',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,  //  acf_condtional
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
    ),
);

$fields = array_merge($fields, $repeater_buttons, $oembed);
$location = array (
    array(
        array(
            'param' => 'page_type',
            'operator' => '==',
            'value' => 'front_page',
        ),
    ),
);