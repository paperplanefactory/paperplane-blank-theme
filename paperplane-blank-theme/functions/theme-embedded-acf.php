<?php
if( function_exists('acf_add_local_field_group') ):
// social, tracking codes and credits
acf_add_local_field_group(array(
	'key' => 'group_5bd2e02601e93',
	'title' => 'Main options',
	'fields' => array(
		array(
			'key' => 'field_5bd2e034bd156',
			'label' => 'Theme version',
			'name' => 'theme_version',
			'type' => 'text',
			'instructions' => 'Per risolvere i problemi di file con cache persistente, tipo CSS e JS. Per forzare la cache modificare la versione del tema qui.Usare una versione tipo 1.2.1',
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
			'key' => 'field_5bd83f6930cc8',
			'label' => 'Non GDPR Tracking codes',
			'name' => 'non_gdpr_tracking_codes',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che non richiedono accettazione.<br />
Per rendere Analytics GDPR compliant verificare che il codice abbia questa riga:<br />
gtag(\'config\', \'UA-XXXXXXX-X\', { \'anonymize_ip\': true });<br />
E verificare che nelle "Impostazioni di condivisione dati" di Analytics non sia marcato nessun checkbox.',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
		),
		array(
			'key' => 'field_5c94a9eb97e55',
			'label' => 'GDPR Tracking codes',
			'name' => 'gdpr_tracking_codes',
			'type' => 'textarea',
			'instructions' => 'Inserire qui i codici di tracciamento che richiedono accettazione.<br />
Se vengono impostati questi codici è necessario aggiornare le impostazioni di WP Fastest Cache come segue:<br />
exclude -> If cookie contains -> “cookie_notice_accepted”',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => '',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => '',
			'new_lines' => '',
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
// social
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
