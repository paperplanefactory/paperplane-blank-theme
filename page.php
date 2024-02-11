<?php
/**
 *  Paperplane _blankTheme - template predefinito per pagine.
 */
get_header();
?>
<div class="wrapper page-opening">
	<div class="fullscreen-cta opening-almost-fullscreen fluid-typo alignleft">
		<div class="above-image-opacity"></div>
		<div class="fullscreen-cta-aligner">
			<div class="wrapper">
				<div class="wrapper-padded">
					<section class="fullscreen-cta-safe-padding alignleft">
						<div data-aos="fade-up" data-aos-delay="300">
							<div class="last-child-no-margin">
								<h1>
									<?php _e( 'Associare a questa pagina un template.', 'paperPlane-blankTheme' ); ?>
								</h1>
							</div>
							<div class="clearer"></div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>