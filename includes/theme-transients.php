<?php
global $use_transients_fields;
$use_transients_fields = get_field( 'use_transients_fields', 'option' );
function paperplane_multilang_setup() {
	// verifico che sia attivo Polylang e creo un array con gli slug delle lingue attive
	if ( function_exists( 'PLL' ) ) {
		$langs_parameters = array(
			'hide_if_empty' => 0,
			'fields' => 'slug'
		);
		$languages = pll_languages_list( $langs_parameters );
	}
	// oppure imposto il parametro per un sito monolingua
	else {
		$languages = array( 'any-lang' );
	}
	return $languages;
}

function paperplane_content_transients( $content_id ) {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		$content_fields_transient = get_transient( 'paperplane_transient_content_fields_' . $content_id );
		if ( empty( $content_fields_transient ) ) {
			$content_fields = get_fields( $content_id );
			set_transient( 'paperplane_transient_content_fields_' . $content_id, $content_fields, DAY_IN_SECONDS * 4 );
		} else {
			$content_fields = $content_fields_transient;
		}
	} else {
		$content_fields = get_fields( $content_id );
	}
	return $content_fields;
}

function paperplane_content_transients_generation( $content_id ) {
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		// Controlla se il post è stato appena salvato
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		//delete_transient( 'paperplane_transient_content_fields_' . $content_id );
		$content_fields_transient = get_transient( 'paperplane_transient_content_fields_' . $content_id );
		if ( empty( $content_fields_transient ) ) {
			$content_fields = get_fields( $content_id );
			set_transient( 'paperplane_transient_content_fields_' . $content_id, $content_fields, DAY_IN_SECONDS * 4 );
		}
	}
}

add_action( 'save_post', 'paperplane_content_transients_generation', 20, 3 );
//add_action( 'wp_trash_post', 'paperplane_content_transients_generation', 10 );
//add_action( 'delete_post', 'paperplane_content_transients_generation', 10 );

function paperplane_options_transients() {
	global $options_fields, $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		$paperplane_transient_options_fields_ = get_transient( 'paperplane_transient_options_fields_' );
		if ( empty( $paperplane_transient_options_fields_ ) ) {
			$options_fields = get_fields( 'options' );
			set_transient( 'paperplane_transient_options_fields_', $options_fields, DAY_IN_SECONDS * 4 );
		} else {
			$options_fields = $paperplane_transient_options_fields_;
		}
	} else {
		$options_fields = get_fields( 'options' );
	}
}




function paperplane_options_transients_multilanguage() {
	global $options_fields_multilang, $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		$options_fields_multilang = '';
		$languages = paperplane_multilang_setup();
		foreach ( $languages as $language ) {
			global ${$options_fields_multilang . $language};
			$options_fields_multilang_transient = get_transient( 'paperplane_transient_options_fields_multilang_' . $language );
			if ( empty( $options_fields_multilang_transient ) ) {
				${$options_fields_multilang . $language} = get_fields( $language );
				set_transient( 'paperplane_transient_options_fields_multilang_' . $language, ${$options_fields_multilang . $language}, DAY_IN_SECONDS * 4 );
			} else {
				${$options_fields_multilang . $language} = $options_fields_multilang_transient;
			}
			return ${$options_fields_multilang . $language};
		}
	} else {
		$options_fields_multilang = '';
		$languages = paperplane_multilang_setup();
		foreach ( $languages as $language ) {
			global ${$options_fields_multilang . $language};
			${$options_fields_multilang . $language} = get_fields( $language );
			return ${$options_fields_multilang . $language};
		}

	}
}

function paperplane_delete_content_transients( $post_id, $post, $update ) {
	delete_transients_with_prefix( 'paperplane_transient_content_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_query_modals_' );
	delete_transients_with_prefix( 'paperplane_transient_query_mega_menus' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_multilang_' );
}
add_action( 'save_post', 'paperplane_delete_content_transients', 10, 3 );
add_action( 'wp_trash_post', 'paperplane_delete_content_transients_on_post_delete', 10 );
add_action( 'delete_post', 'paperplane_delete_content_transients_on_post_delete', 10 );
function paperplane_delete_content_transients_on_post_delete() {
	delete_transients_with_prefix( 'paperplane_transient_content_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_query_modals_' );
	delete_transients_with_prefix( 'paperplane_transient_query_mega_menus' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_' );
	delete_transients_with_prefix( 'paperplane_transient_options_fields_multilang_' );
}

function paperplane_delete_option_pages_transients() {
	delete_transient( 'paperplane_transient_options_fields_' );
	$languages = paperplane_multilang_setup();
	foreach ( $languages as $language ) {
		delete_transient( 'paperplane_transient_options_fields_multilang_' . $language );
	}
}
add_action( 'acf/save_post', 'paperplane_delete_option_pages_transients', 20 );

function delete_transients_with_prefix( $prefix ) {
	foreach ( get_transient_keys_with_prefix( $prefix ) as $key ) {
		delete_transient( $key );
	}
}

function get_transient_keys_with_prefix( $prefix ) {
	global $wpdb;
	$prefix = $wpdb->esc_like( '_transient_' . $prefix );
	$sql = "SELECT `option_name` FROM $wpdb->options WHERE `option_name` LIKE '%s'";
	$keys = $wpdb->get_results( $wpdb->prepare( $sql, $prefix . '%' ), ARRAY_A );

	if ( is_wp_error( $keys ) ) {
		return [];
	}

	return array_map( function ($key) {
		// Remove '_transient_' from the option name.
		return ltrim( $key['option_name'], '_transient_' );
	}, $keys );
}