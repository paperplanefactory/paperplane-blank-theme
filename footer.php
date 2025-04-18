</main><!-- id="page-content" aperto in header.php -->
<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
global $use_transients_fields,
$theme_version,
$acf_options_parameter,
$static_bloginfo_stylesheet_directory,
$options_fields,
$options_fields_multilang,
$cta_url_modal_array,
$theme_pagination,
$attivare_pwa;
$cta_url_modal_array = array_unique( $cta_url_modal_array );
?>

<footer id="footer" class="bg-4">
	<div class="wrapper">
		<div class="wrapper-padded">
			<div class="">
				<div class="flex-hold flex-hold-2 margins-wide verticalize">
					<div class="flex-hold-child">
						<div class="footer-logo">
							<a href="<?php echo home_url(); ?>" rel="bookmark"
								title="homepage - <?php echo get_bloginfo( 'name' ); ?>">
							</a>
						</div>
					</div>
					<div class="flex-hold-child desktop-align-right">
						<?php if ( $options_fields['global_socials'] ) : ?>
							<nav aria-label="<?php _e( 'Menu social', 'paperPlane-blankTheme' ); ?>">
								<ul class="site-socials inline-socials">
									<?php
									foreach ( $options_fields['global_socials'] as $global_social ) :
										$parse_social = parse_url( $global_social['global_socials_profile_url'] );
										?>
										<li>
											<a href="<?php echo $global_social['global_socials_profile_url']; ?>"
												class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
												aria-label="<?php echo __( 'Visita il nostro profilo su', 'paperPlane-blankTheme' ) . ' ' . $parse_social['host'] . ' ' . __( '- si apre in una nuova finestra', 'paperPlane-blankTheme' ); ?>"
												rel="noopener">
											</a>
										</li>
									<?php endforeach; ?>
								</ul>
							</nav>
						<?php endif; ?>
					</div>
				</div>
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'underlined-links footer-menu' ) );
				}
				?>
				<div class="flex-hold flex-hold-2 margins-wide">
					<div class="flex-hold-child">
						<div class="underlined-links">
							<p>
								<?php echo $options_fields_multilang['footer_legal_notes']; ?>
							</p>
						</div>
					</div>
					<div class="flex-hold-child desktop-align-right underlined-links">
						<p>
							<?php echo $options_fields_multilang['footer_credits']; ?>
						</p>
					</div>
					<div class="flex-hold-child-full">
						<?php include( locate_template( 'template-parts/grid/user-a11y-options.php' ) ); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php //include( locate_template( 'template-parts/grid/mega-menu.php' ) ); ?>
</div>
<?php
if ( ! empty( $cta_url_modal_array ) ) {
	$content_id = get_the_ID();
	$args_modals = array(
		'post_type' => 'cpt_modal',
		'posts_per_page' => -1,
		'include' => $cta_url_modal_array
	);
	global $use_transients_fields;
	if ( $use_transients_fields == 1 ) {
		$paperplane_query_modals_transient = get_transient( 'paperplane_transient_query_modals_' . $content_id );
		if ( empty( $paperplane_query_modals_transient ) ) {
			$my_modals = get_posts( $args_modals );
			set_transient( 'paperplane_transient_query_modals_' . $content_id, $my_modals, DAY_IN_SECONDS * 4 );
		} else {
			$my_modals = $paperplane_query_modals_transient;
		}
	} else {
		$my_modals = get_posts( $args_modals );
	}

	if ( ! empty( $my_modals ) ) {
		foreach ( $my_modals as $post ) :
			setup_postdata( $post );
			include( locate_template( 'template-parts/grid/modal.php' ) );
		endforeach;
		wp_reset_postdata();
	}
}
?>
<?php wp_footer(); ?>
</body>

</html>