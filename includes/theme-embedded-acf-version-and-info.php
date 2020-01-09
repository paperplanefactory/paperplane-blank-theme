<?php
if( function_exists('acf_add_local_field_group') ):
acf_add_local_field_group(array(
	'key' => 'group_5bd2e02601e93',
	'title' => 'Main options',
	'fields' => array(
		array(
			'key' => 'field_5bd2e034bd156',
			'label' => 'Theme version',
			'name' => 'theme_version',
			'type' => 'text',
			'instructions' => 'For quick cache problem solving change theme version here. Use something like 1.2.1',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5bd840676eba7',
			'label' => 'Credits and more',
			'name' => 'credits_and_more',
			'type' => 'wysiwyg',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'tabs' => 'all',
			'toolbar' => 'full',
			'media_upload' => 1,
			'delay' => 0,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'theme-general-settings',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

endif;
