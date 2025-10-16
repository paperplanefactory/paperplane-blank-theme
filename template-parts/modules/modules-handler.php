<div class="modules-handler">
	<?php
	global $module_count, $last_rep_color, $custom_anchor_point;
	$module_count = 0;
	if ( $content_fields['new_module'] ) {
		foreach ( $content_fields['new_module'] as $module ) {
			$module_count++;
			$choose_module = $module['choose_module'];
			$show_hide_module = $module['show_hide_module'];
			if ( $module['custom_anchor_point'] ?? null ) {
				$custom_anchor_point = $module['custom_anchor_point'];
			} else {
				$custom_anchor_point = 'section-' . $module_count;
			}

			if ( $show_hide_module == 1 ) {
				$bar = get_user_option( 'show_admin_bar_front', get_current_user_id() );
				if ( $bar == 'true' ) {
					echo '<div class="editor-info editor-info-js"><div class="admin-index"><span class="click-hide">+</span><span class="hide-me hidden-label" data-url-copy="' . get_permalink() . '#' . $custom_anchor_point . '"> Modulo: ' . $choose_module . ' - ' . $module_count . ' Clicca per copiare la URL</span></div></div>';

				}
				switch ( $choose_module ) {
					// module-text
					case 'module-text':
						include( locate_template( 'template-parts/modules/module-text.php' ) );
						break;
					// module-highlighted-sentence
					case 'module-highlighted-sentence':
						include( locate_template( 'template-parts/modules/module-highlighted-sentence.php' ) );
						break;
					// module-columns
					case 'module-columns':
						include( locate_template( 'template-parts/modules/module-columns.php' ) );
						break;
					// module-module-columns-fix-column
					case 'module-columns-fix-column':
						include( locate_template( 'template-parts/modules/module-columns-fix-column.php' ) );
						break;
					// module-stripe
					case 'module-stripe':
						include( locate_template( 'template-parts/modules/module-stripe.php' ) );
						break;
					// module-slideshow
					case 'module-slideshow':
						include( locate_template( 'template-parts/modules/module-slideshow.php' ) );
						break;
					// module-fullscreen-image
					case 'module-fullscreen-image':
						include( locate_template( 'template-parts/modules/module-fullscreen-image.php' ) );
						break;
					// module-expanding-text
					case 'module-expanding-text':
						include( locate_template( 'template-parts/modules/module-expanding-text-js.php' ) );
						break;
					// module-banner
					case 'module-banner':
						include( locate_template( 'template-parts/modules/module-banner.php' ) );
						break;
					// module-video
					case 'module-video':
						include( locate_template( 'template-parts/modules/module-video.php' ) );
						break;
					// module-cards
					case 'module-cards':
						include( locate_template( 'template-parts/modules/module-cards.php' ) );
						break;
					// module-scroll-text
					case 'module-scroll-text':
						include( locate_template( 'template-parts/modules/module-scroll-text.php' ) );
						break;
				}
			}
		}
	}
	?>
</div>