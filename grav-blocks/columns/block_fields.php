<?php
/*
*
* Gravitate Content Block
*
* Available Variables:
* $block 					= Name of Block Folder
* $block_backgrounds 		= Array for Background Options
* $block_background_image = Array for Background Image Option
*
* This file must return an array();
*
*/

$block_fields = array(
    array (
        'key' => 'field_'.$block.'_format',
        'label' => 'Format',
        'name' => 'format',
        'type' => 'radio',
        'instructions' => 'Note: This option is only available when using 2 columns',
        'required' => 0,
        'conditional_logic' => array (
            array (
                array (
                    'field' => 'field_'.$block.'_num_columns',
                    'operator' => '==',
                    'value' => 2,
                ),
            ),
        ),
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => array (
            '' => 'Default',
            'sidebar-left' => 'Sidebar Left',
            'sidebar-right' => 'Sidebar Right'
        ),
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => '',
        'layout' => 'horizontal'
    ),
    array (
        'key' => 'field_'.$block.'_columns',
        'label' => 'Columns',
        'name' => 'columns',
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array (
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'collapsed' => '',
        'min' => 1,
        'max' => 4,
        'layout' => 'block',         // table | block | row
        'button_label' => 'Add Column',
        'sub_fields' => array (
            array (
                'key' => 'field_'.$block.'_type',
                'label' => 'Column Type',
                'name' => 'type',
                'type' => 'select',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'choices' => array (
                    'wysiwyg' => 'WYSIWYG editor'
                ),
                'default_value' => 'wysiwyg',
                'allow_null' => 0,
                'multiple' => 0,         // allows for multi-select
                'ui' => 0,               // creates a more stylized UI
                'ajax' => 0,
                'placeholder' => '',
                'disabled' => 0,
                'readonly' => 0,
            ),

            /**
             * WYSIWYG fields
             */
            array (
                'key' => 'field_'.$block.'_wysiwyg',
                'label' => 'WYSIWYG editor',
                'name' => 'wysiwyg',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => array (
                    array (
                        array (
                            'field' => 'field_'.$block.'_type',
                            'operator' => '==',
                            'value' => 'wysiwyg',
                        ),
                    ),
                ),
                'wrapper' => array (
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',         // all | visual | text
                'toolbar' => 'full',     // full | basic
                'media_upload' => 1,
            ),
        ),
    ),
);

return array (
	'label' => 'Columns',
	'name' => $block,
	'display' => 'block',
	'min' => '',
	'max' => '',
	'sub_fields' => $block_fields,
	'grav_blocks_settings' => array(
		'version' => '2.0',
		'icon' => 'gravicon-content-2col',
		'description' => ''
	),
);
