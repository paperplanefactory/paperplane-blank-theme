<!-- module-fullscreen-image -->
<section
	class="wrapper module-fullscreen-image bg-4 <?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="module-box-fullscreen coverize <?php echo $module['module_fullscreen_text_align_horizontal']; ?>"
		data-aos="fade">
		<?php if ( $module['module_fullscreen_image_image_video'] == 1 ) : ?>
			<button class="play-pause-animation animation-play-pause-js pause"
				data-video-stop="module-fullscreen-video-<?php echo $module_count; ?>"
				title="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"
				aria-label="<?php _e( 'Ferma il video', 'paperPlane-blankTheme' ); ?>"></button>
			<video id="module-fullscreen-video-<?php echo $module_count; ?>" aria-hidden="true" class="stoppable-js"
				data-autoplay autoplay loop muted playsinline>
				<source type="video/mp4" src="<?php echo $module['module_fullscreen_image_image_video_file']; ?>">
			</video>
		<?php else : ?>
			<?php if ( isset( $module['module_fullscreen_image_image_desktop'] ) ) : ?>
				<div class="desktop-only">
					<?php
					$image_data = array(
						'image_type' => 'acf',
						// options: post_thumbnail, acf
						'image_value' => $module['module_fullscreen_image_image_desktop']
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
						'mobile_hd' => 'full_desk'
					);
					print_theme_image( $image_data, $image_appearance, $image_sizes );
					?>
				</div>
			<?php endif; ?>
			<?php if ( isset( $module['module_fullscreen_image_image_mobile'] ) ) : ?>
				<div class="mobile-only">
					<?php
					$image_data = array(
						'image_type' => 'acf',
						// options: post_thumbnail, acf
						'image_value' => $module['module_fullscreen_image_image_mobile']
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
						'mobile_hd' => 'full_desk'
					);
					print_theme_image( $image_data, $image_appearance, $image_sizes );
					?>
				</div>
			<?php endif; ?>
		<?php endif; ?>
		<div class="above-image-opacity"></div>
		<div class="wrapper-padded">
			<div class="module-fullscreen-texts fluid-typo" data-aos="fade-right">
				<?php if ( $module['module_fullscreen_image_main_text'] ) : ?>
					<h1>
						<?php echo $module['module_fullscreen_image_main_text']; ?>
					</h1>
				<?php endif; ?>
				<?php if ( $module['module_fullscreen_image_secondary_text'] ) : ?>
					<h2>
						<?php echo $module['module_fullscreen_image_secondary_text']; ?>
					</h2>
				<?php endif; ?>
				<div class="clearer"></div>
				<?php paperplane_theme_cta_advanced( $module['module_fullscreen_image_cta'] ); ?>
			</div>
		</div>
	</div>
</section>
<!-- module-fullscreen-image -->