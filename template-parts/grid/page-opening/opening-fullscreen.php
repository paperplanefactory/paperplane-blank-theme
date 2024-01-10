<div class="wrapper page-opening">
	<div
		class="fullscreen-cta coverize fluid-typo <?php echo $content_fields['page_opening_layout'] . ' ' . $content_fields['page_opening_text_align']; ?>">
		<?php if ( $content_fields['page_opening_video'] === 'si' ) : ?>
			<button class="video-stop video-stop-js pause" data-video-stop="opening-video-js"
				title="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"
				aria-label="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"></button>
			<video id="opening-video-js" aria-hidden="true" class="stoppable-js" data-aos="fade-in" data-autoplay autoplay
				loop muted playsinline>
				<source type="video/mp4" src="<?php echo $content_fields['page_opening_video_mp4']; ?>">
			</video>
		<?php else : ?>
			<?php if ( isset( $content_fields['page_opening_image_desktop'] ) ) : ?>
				<div class="desktop-only">
					<?php
					$image_data = array(
						'image_type' => 'acf',
						// options: post_thumbnail, acf
						'image_value' => $content_fields['page_opening_image_desktop']
						// se utilizzi un custom field indica qui il nome del campo
					);
					$image_appearance = array(
						// options: true, false
						'lazyload' => false,
						// options: sync, async
						'decoding' => 'async',
						// options: true, false - se false non mette contenitore intorno all'immagine
						'image-wrap' => false
					);
					$image_sizes = array(
						// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
						'desktop_hd' => 'full_desk_hd',
						'mobile_hd' => 'full_desk_hd'
					);
					print_theme_image( $image_data, $image_appearance, $image_sizes );
					?>
				</div>
			<?php endif; ?>
			<?php if ( isset( $content_fields['page_opening_image_mobile'] ) ) : ?>
				<div class="mobile-only">
					<?php
					$image_data = array(
						'image_type' => 'acf',
						// options: post_thumbnail, acf
						'image_value' => $content_fields['page_opening_image_mobile']
						// se utilizzi un custom field indica qui il nome del campo
					);
					$image_appearance = array(
						// options: true, false
						'lazyload' => false,
						// options: sync, async
						'decoding' => 'async',
						// options: true, false - se false non mette contenitore intorno all'immagine
						'image-wrap' => false
					);
					$image_sizes = array(
						// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
						'desktop_hd' => 'full_desk',
						'mobile_hd' => 'full_desk'
					);
					print_theme_image( $image_data, $image_appearance, $image_sizes );
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="above-image-opacity"></div>
		<div class="fullscreen-cta-aligner">
			<div class="wrapper">
				<div class="wrapper-padded">
					<section
						class="fullscreen-cta-safe-padding <?php echo $content_fields['page_opening_text_align_horizontal']; ?>">
						<div data-aos="fade-up" data-aos-delay="300">
							<div class="last-child-no-margin">
								<?php if ( $content_fields['page_breadcrumbs'] === 'yes' && function_exists( 'bcn_display' ) ) : ?>
									<div class="breadcrumbs-holder undelinked-links" typeof="BreadcrumbList"
										vocab="http://schema.org/">
										<?php bcn_display(); ?>
									</div>
								<?php endif; ?>
								<?php if ( $content_fields['page_opening_title'] ) : ?>
									<h1>
										<?php echo $content_fields['page_opening_title']; ?>
									</h1>
								<?php else : ?>
									<h1>
										<?php the_title(); ?>
									</h1>
								<?php endif; ?>
								<?php if ( $content_fields['page_opening_subtitle'] ) : ?>
									<p>
										<?php echo $content_fields['page_opening_subtitle']; ?>
									</p>
								<?php endif; ?>
							</div>
							<div class="clearer"></div>
							<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_page_opening'] ); ?>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
</div>