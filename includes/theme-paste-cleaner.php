<?php
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
		$js = <<<'EOD'
(function($) {
    'use strict';
    
    $(document).on('tinymce-editor-init', function(event, editor) {
        let isPasting = false;

        // Monitora l'inizio dell'operazione di incolla
        editor.on('paste', function(e) {
            isPasting = true;
        });

        editor.on('PastePreProcess', function(e) {
            // Applica la pulizia solo se è un'operazione di incolla reale
            if (isPasting) {
                let content = e.content;
                
                // Temporaneamente sostituisce i link con un placeholder
                let links = [];
                content = content.replace(/<a[^>]*href=['\"](.*?)['\"][^>]*>([\s\S]*?)<\/a>/gi, function(match) {
                    links.push(match);
                    return '###LINK' + (links.length - 1) + '###';
                });
                
                // Rimuove formattazione indesiderata
                content = content.replace(/<\/?font[^>]*>/g, '');
                content = content.replace(/<(p|span|ul|li|h[1-6])[^>]*?class=['\"][^'\"]*['\"][^>]*?>/g, '<$1>');
                content = content.replace(/style=['\"][^'\"]*['\"]?/g, '');
                content = content.replace(/color:[^;]+;/g, '');
                content = content.replace(/<!--[\s\S]*?-->/g, '');
                content = content.replace(/mso-[^:]+:[^;]+;/g, '');
                content = content.replace(/<(p|span|ul|li|h[1-6])\s*>/g, '<$1>');
                
                // Normalizza gli spazi
                content = content.replace(/&nbsp;/g, ' ');
                content = content.replace(/\s+/g, ' ');
                
                // Ripristina i link
                links.forEach(function(link, index) {
                    content = content.replace('###LINK' + index + '###', link);
                });

                // Pulisce gli attributi dei link
                content = content.replace(/<a[^>]*href=(['"])(.*?)\1[^>]*>([\s\S]*?)<\/a>/gi, function(match, quote, url, text) {
                    let target = match.indexOf('target="_blank"') !== -1 ? ' target="_blank"' : '';
                    return '<a href=' + quote + url + quote + target + '>' + text + '</a>';
                });
                
                e.content = content.trim();

                // Resetta il flag dopo aver processato il contenuto
                isPasting = false;
            }
        });

        editor.on('init', function() {
            editor.getBody().style.lineHeight = 'inherit';
            editor.getBody().style.fontFamily = 'inherit';
        });
    });
    
})(jQuery);
EOD;
		return $js;
	}

	public function customize_tinymce( $settings ) {
		$settings['paste_as_text'] = false;
		$settings['paste_text_sticky'] = false;
		$settings['paste_text_sticky_default'] = false;

		// Permettiamo esplicitamente gli attributi di stile per la formattazione manuale
		$settings['valid_elements'] = 'a[href|target|title],strong,b,em,i,strike,u,p[style],br,' .
			'ol[type|style],ul[type|style],li[style],h1[style],h2[style],h3[style],h4[style],h5[style],h6[style],' .
			'img[src|alt|title|width|height],' .
			'table[border|cellspacing|cellpadding|width|style],' .
			'tr[rowspan|width|height|align|valign|style],' .
			'td[colspan|rowspan|width|height|align|valign|style],' .
			'th[colspan|rowspan|width|height|align|valign|style],' .
			'div[style],span[style],blockquote[style],sub,sup,code,pre';

		// Manteniamo gli stili per la formattazione manuale
		$settings['paste_remove_styles'] = false;
		$settings['paste_remove_spans'] = false;
		$settings['paste_strip_class_attributes'] = 'none';
		$settings['paste_retain_style_properties'] = '*';

		$settings['toolbar1'] = 'formatselect,bold,italic,underline,strikethrough,bullist,numlist,blockquote,link,unlink';

		return $settings;
	}
}

new Clean_Paste_Handler();