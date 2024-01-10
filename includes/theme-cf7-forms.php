<?php
function paperplane_theme_wpcf7_accessibility( $output, $tag, $atts, $m ) {
	if ( $tag === 'contact-form-7' ) {
		$msg = '<div class="form-hold">';
		$msg .= '<p class="as-label">';
		$msg .= __( 'Tutti i campi obbligatori sono contrassegnati da un *', 'paperPlane-blankTheme' );
		$msg .= '</p>';
		$output = $msg . $output;
		$check = '<a href="#" class="form-top-js form-top hidden">' . __( 'Sposta il focus al primo campo contenente errori.', 'paperPlane-blankTheme' ) . '</a>';
		$output .= $check;
		$output .= '</div>';
	}

	return $output;
}

add_filter( 'do_shortcode_tag', 'paperplane_theme_wpcf7_accessibility', 10, 4 );


function paperplane_theme_wpcf7_accessibility_scripts() {
	if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) ) {
		?>
		<script type="text/javascript">
			document.addEventListener('wpcf7invalid', function (event) {
				jQuery('.form-top-js').removeClass('hidden');
				jQuery(document).on('click', '.form-top-js:not(.initialized)', function (e) {
					setTimeout(function () { jQuery('#' + event.detail.unitTag + ' .wpcf7-not-valid').eq(0).focus() }, 50);
					e.preventDefault();
				});

			}, false);
		</script>
		<?php
	}
}

add_action( 'wp_footer', 'paperplane_theme_wpcf7_accessibility_scripts' );