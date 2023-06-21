<?php
$args_mega_menus = array(
	'post_type' => 'cpt_mega_menu',
	'posts_per_page' => -1
);
$paperplane_mega_menus_transient = get_transient( 'paperplane_mega_menus_transient' );
if ( empty( $paperplane_mega_menus_transient ) ) {
	$my_mega_menus = get_posts( $args_mega_menus );
	set_transient( 'paperplane_mega_menus_transient', $my_mega_menus, DAY_IN_SECONDS * 4 );
} else {
	$my_mega_menus = $paperplane_mega_menus_transient;
}


if ( ! empty( $my_mega_menus ) ) : ?>
	<?php foreach ( $my_mega_menus as $post ) :
		setup_postdata( $post );
		$content_fields = paperplane_content_transients( $post->ID );
		?>
		<nav class="mega-menu mega-menu-js mega-menu-js-<?php echo $post->ID; ?>-target hidden" aria-hidden="true">
			<div class="mega-menu-holder <?php echo $mega_menu_wrapper; ?> colors-black-bg">
				<div class="mega-menu-spacer mega-menu-js-hover">
					<div class="flex-hold flex-hold-3 margins-thin">
						<div class="flex-hold-child">
							<?php
							if ( has_nav_menu( 'mega-menu-' . $post->ID . '' ) ) {
								wp_nav_menu( array( 'theme_location' => 'mega-menu-' . $post->ID . '', 'container' => 'ul', 'menu_class' => 'mega-menu-page-list mega-menu-page-list-' . $post->ID . '' ) );
							}
							?>
						</div>
						<div class="flex-hold-child">
							<?php
							$image_data = array(
								'image_type' => 'acf',
								// options: post_thumbnail, acf
								'image_value' => $content_fields['mega_menu_repeater_image'],
								// se utilizzi un custom field indica qui il nome del campo
								'size_fallback' => 'column'
							);
							$image_sizes = array(
								// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
								'desktop_default' => 'column',
								'desktop_hd' => 'column_',
								'mobile_default' => 'column',
								'mobile_hd' => 'column',
								'lazy_placheholder' => 'micro'
							);
							print_theme_image_nolazy( $image_data, $image_sizes );
							?>
						</div>
						<div class="flex-hold-child">
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
		<script type="text/javascript">
			jQuery('.mega-menu-js-<?php echo $post->ID; ?>-target a').last().on('keydown', function (event) {
				if (event.keyCode == 9) {
					jQuery('.mega-menu-js-trigger').removeClass('current-mega-menu');
					jQuery('.mega-menu-js').addClass('hidden').attr('aria-hidden', 'true');
					jQuery('.mega-menu-js-<?php echo $post->ID; ?>-trigger').parent().next('li').find('a:first').focus();
					event.preventDefault();
				}
			});
		</script>
	<?php endforeach;
	wp_reset_postdata();
endif; ?>