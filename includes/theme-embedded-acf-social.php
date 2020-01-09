<?php
if( function_exists('acf_add_local_field_group') ):
	acf_add_local_field_group(array(
		'key' => 'group_5bd8651bb9b42',
		'title' => 'Opzioni Social',
		'fields' => array(
			array(
				'key' => 'field_5bd8653d6305d',
				'label' => 'Gestione social',
				'name' => 'global_socials',
				'type' => 'repeater',
				'instructions' => 'Per aggiungere icone fare riferimento a Font Awesome - <a href="https://fontawesome.com/icons?d=gallery&s=brands" target="_blank">Brands</a>.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'collapsed' => '',
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => '',
				'sub_fields' => array(
					array(
						'key' => 'field_5bd865f2592d4',
						'label' => 'URL profilo social',
						'name' => 'global_socials_profile_url',
						'type' => 'url',
						'instructions' => '',
						'required' => 1,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
					),
					array(
						'key' => 'field_5bd8660b592d5',
						'label' => 'Icona',
						'name' => 'global_socials_icona',
						'type' => 'text',
						'instructions' => 'Incollare qui la classe dell\'icona da Font Awesome<br />
	es: fab fa-facebook',
						'required' => 1,
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
				),
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-options-gestione-social',
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
