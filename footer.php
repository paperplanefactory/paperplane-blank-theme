</div><!-- id="page-content" aperto in header.php -->
<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
global $acf_options_parameter, $options_fields, $options_fields_multilang, ${$options_fields_multilang . $acf_options_parameter}, $static_bloginfo_stylesheet_directory, $cta_url_modal_array;
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
								<div class="no-the-100">
									<img src="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/site-logo-header.svg"
										width="200" height="64" loading="lazy"
										alt="<?php echo get_bloginfo( 'name' ); ?> - homepage" />
								</div>
							</a>
						</div>
					</div>
					<div class="flex-hold-child desktop-align-right">
						<?php if ( $options_fields['global_socials'] ) : ?>
							<ul class="inline-socials">
								<?php foreach ( $options_fields['global_socials'] as $global_social ) : ?>
									<li>
										<a href="<?php echo $global_social['global_socials_profile_url']; ?>"
											class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
											aria-label="Visit <?php echo $global_social['global_socials_profile_url']; ?>"
											rel="noopener">
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
				<?php
				if ( has_nav_menu( 'footer-menu' ) ) {
					wp_nav_menu( array( 'theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'footer-menu' ) );
				}
				?>
				<div class="flex-hold flex-hold-2 margins-wide">
					<div class="flex-hold-child">
						<?php echo ${$options_fields_multilang . $acf_options_parameter}['footer_legal_notes']; ?>
						<?php if ( $options_fields['animations_option'] == 1 ) : ?>
							<p>
								<i class="paperplane-blank-theme-icons-reduce-motion"></i>
								<a href="#" class="accessible-navi-activate-js"
									title="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
									aria-label="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
									data-original-label="<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>"
									data-active-label="<?php _e( 'Attiva animazioni', 'paperPlane-blankTheme' ); ?>">
									<?php _e( 'Riduci animazioni', 'paperPlane-blankTheme' ); ?>
								</a>
							</p>
						<?php endif; ?>
					</div>
					<div class="flex-hold-child desktop-align-right">
						<?php echo ${$options_fields_multilang . $acf_options_parameter}['footer_credits']; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<?php include( locate_template( 'template-parts/grid/mega-menu.php' ) ); ?>
<?php
if ( ! empty( $cta_url_modal_array ) ) {
	$args_modals = array(
		'post_type' => 'cpt_modal',
		'posts_per_page' => -1,
		'include' => $cta_url_modal_array
	);
	$paperplane_query_modals_transient = get_transient( 'paperplane_query_modals_transient' );
	if ( empty( $paperplane_query_modals_transient ) ) {
		$my_modals = get_posts( $args_modals );
		set_transient( 'paperplane_query_modals_transient', $my_modals, DAY_IN_SECONDS * 4 );
	} else {
		$my_modals = $paperplane_query_modals_transient;
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
</div>
<?php wp_footer(); ?>
</body>

</html>