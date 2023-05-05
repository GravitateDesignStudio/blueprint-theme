<?php

$repeater_buttons = array (
    array (
        'key' => 'field_'.$block.'_buttons',
        'label' => 'Buttons',
        'name' => $block.'_buttons',
        'type' => 'repeater',
        'instructions' => 'Add up to 2 buttons to the banner (optional)',
        'max' => '2',
        'layout' => 'block',  // table | block | row
        'button_label' => '&#x271A; Button',
        'sub_fields' => array (
            array (
                'key' => 'field_'.$block.'_link',
                'label' => 'Link',
                'name' => $block.'_link',
                'type' => 'link',
                'wrapper' => array (
                    'width' => '50',
                ),
                'return_format' => 'array', // array | url
            ),
            array (
                'key' => 'field_'.$block.'_button_style',
                'label' => 'Button Style',
                'name' => $block.'_button_style',
                'type' => 'select',
                'wrapper' => array (
                    'width' => '50',
                ),
                'choices' => array (
                    'primary' => 'Primary',
                    'secondary' => 'Secondary',
                    'link' => 'Link',
                ),
            )
        ),
    ),
);
