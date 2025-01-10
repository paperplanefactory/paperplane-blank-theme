<?php
//conto le parole del content - call in template: echo word_count();
function word_count() {
	$content = get_post_field( 'post_content', $post->ID );
	$word_count = str_word_count( strip_tags( $content ) );
	return $word_count;
}

function excerpt( $limit ) {
	$excerpt = explode( ' ', get_the_excerpt(), $limit );

	if ( count( $excerpt ) >= $limit ) {
		array_pop( $excerpt );
		$excerpt = implode( " ", $excerpt ) . '...';
	} else {
		$excerpt = implode( " ", $excerpt );
	}

	$excerpt = preg_replace( '`\[[^\]]*\]`', '', $excerpt );

	return $excerpt;
}

// page title generator
function twentytwelve_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentytwelve' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentytwelve_wp_title', 10, 2 );

/**
 * Replaces the login header logo URL
 *
 * @param $url
 */
function namespace_login_headerurl( $url ) {
	$url = home_url( '/' );
	return $url;
}

class Clean_Paste_Handler {
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'add_clean_paste_script' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'customize_tinymce' ) );
	}

	public function add_clean_paste_script( $hook ) {
		if ( ! in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
			return;
		}

		wp_enqueue_script( 'jquery' );
		wp_add_inline_script( 'jquery', $this->get_clean_paste_js(), 'after' );
	}

	private function get_clean_paste_js() {
		return "
        (function($) {
            'use strict';
            
            $(document).on('tinymce-editor-init', function(event, editor) {
                editor.on('PastePreProcess', function(e) {
                    let content = e.content;
                    
                    // Temporaneamente sostituisce i link con un placeholder
                    let links = [];
                    content = content.replace(/<a[^>]*href=['\"]([^'\"]*)['\"][^>]*>([\s\S]*?)<\/a>/gi, function(match) {
                        links.push(match);
                        return '###LINK' + (links.length - 1) + '###';
                    });
                    
                    // Rimuove formattazione indesiderata
                    content = content.replace(/<\\/?span[^>]*>/g, '');
                    content = content.replace(/style=\"[^\"]*\"/g, '');
                    content = content.replace(/<\\/?font[^>]*>/g, '');
                    content = content.replace(/class=\"[^\"]*\"/g, '');
                    content = content.replace(/color:[^;]+;/g, '');
                    content = content.replace(/<!--[\\s\\S]*?-->/g, '');
                    content = content.replace(/mso-[^:]+:[^;]+;/g, '');
                    
                    // Normalizza gli spazi
                    content = content.replace(/&nbsp;/g, ' ');
                    content = content.replace(/\\s+/g, ' ');
                    
                    // Ripristina i link originali
                    links.forEach(function(link, index) {
                        content = content.replace('###LINK' + index + '###', link);
                    });

                    // Pulisce gli attributi dei link mantenendo solo href e target
                    content = content.replace(/<a[^>]*href=(['\"])(.*?)\\1[^>]*>([\s\S]*?)<\/a>/gi, function(match, quote, url, text) {
                        // Mantiene target='_blank' se presente
                        let target = match.indexOf('target=\"_blank\"') !== -1 ? ' target=\"_blank\"' : '';
                        return '<a href=' + quote + url + quote + target + '>' + text + '</a>';
                    });
                    
                    e.content = content.trim();
                });
            });
            
        })(jQuery);";
	}

	public function customize_tinymce( $settings ) {
		// Configura TinyMCE mantenendo i link
		$settings['paste_as_text'] = false; // Cambiato a false per permettere HTML
		$settings['paste_text_sticky'] = false;
		$settings['paste_text_sticky_default'] = false;

		// Definisce i tag HTML permessi, inclusi i link
		$valid_elements = 'p[style],br,strong,em,ul,ol,li,h1,h2,h3,h4,h5,h6,a[href|target|title],img[src|alt|title]';
		$settings['valid_elements'] = $valid_elements;

		// Configura le opzioni di paste specifiche per i link
		$settings['paste_remove_styles'] = true;
		$settings['paste_remove_spans'] = true;
		$settings['paste_strip_class_attributes'] = true;
		$settings['paste_retain_style_properties'] = 'none';

		return $settings;
	}
}

// Inizializza la classe
new Clean_Paste_Handler();