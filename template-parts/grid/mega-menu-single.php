<?php
$args_mega_menus = array(
	'post_type' => 'cpt_mega_menu',
	'post__in' => array( $mega_menu_activator[0] )

);
global $use_transients_fields;
if ( $use_transients_fields == 1 ) {
	$paperplane_mega_menus_transient = get_transient( 'paperplane_transient_query_mega_menus' . $mega_menu_activator[0] );
	if ( empty( $paperplane_mega_menus_transient ) ) {
		$my_mega_menus = get_posts( $args_mega_menus );
		set_transient( 'paperplane_transient_query_mega_menus' . $mega_menu_activator[0], $my_mega_menus, DAY_IN_SECONDS * 4 );
	} else {
		$my_mega_menus = $paperplane_mega_menus_transient;
	}
} else {
	$my_mega_menus = get_posts( $args_mega_menus );
}



if ( ! empty( $my_mega_menus ) ) : ?>
	<?php foreach ( $my_mega_menus as $post ) :
		setup_postdata( $post );
		$content_fields = paperplane_content_transients( $post->ID );
		?>
		<nav id="mega-menu-control-<?php echo $post->ID; ?>" aria-labelledby="mega-menu-controller-<?php echo $post->ID; ?>"
			class="mega-menu mega-menu-js mega-menu-js-<?php echo $post->ID; ?>-target hidden" aria-hidden="true"
			data-mega-menu-id="<?php echo $post->ID; ?>">
			<div class="mega-menu-holder colors-black-bg">
				<div class="mega-menu-spacer mega-menu-js-hover">
					<div class="flex-hold flex-hold-mega-menu">
						<div class="mega-menu-column-1">
							<?php
							$image_data = array(
								'image_type' => 'acf',
								// options: post_thumbnail, acf
								'image_value' => $content_fields['mega_menu_repeater_image']
								// se utilizzi un custom field indica qui il nome del campo
							);
							$image_appearance = array(
								// options: true, false
								'lazyload' => true,
								// options: sync, async
								'decoding' => 'async',
								// options: true, false - se false non mette contenitore intorno all'immagine
								'image-wrap' => true
							);
							$image_sizes = array(
								// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
								'desktop_hd' => 'column',
								'mobile_hd' => 'column'
							);
							print_theme_image( $image_data, $image_appearance, $image_sizes );
							?>
						</div>
						<div class="mega-menu-column-2">
							<?php
							if ( has_nav_menu( 'mega-menu-' . $post->ID . '' ) ) {
								wp_nav_menu( array( 'theme_location' => 'mega-menu-' . $post->ID . '', 'container' => 'ul', 'menu_class' => 'mega-menu-page-list mega-menu-page-list-' . $post->ID . '' ) );
							}
							?>
						</div>
						<div class="mega-menu-column-3">
							<div class="last-child-no-margin">
								<?php if ( $content_fields['mega_menu_repeater_additional_info'] ) : ?>
									<p>
										<?php echo $content_fields['mega_menu_repeater_additional_info']; ?>
									</p>

								<?php endif; ?>

							</div>
							<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_mega_menu'] ); ?>
						</div>
					</div>
				</div>
			</div>
		</nav>
	<?php endforeach;
	wp_reset_postdata();
endif; ?>