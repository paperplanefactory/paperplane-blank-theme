<!-- module-slideshow -->
<section class="wrapper module-slideshow bg-4">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-924">
					<!--
						Riferimenti per bottoni di navigazione separati rispetto a quelli nativi, da configurare in JS
					<button title="<?php _e( 'Vai alla slide precedente', 'paperPlane-blankTheme' ); ?>"
						aria-label="<?php _e( 'Vai alla slide precedente', 'paperPlane-blankTheme' ); ?>"
						class="slide-prev-custom slide-prev-slider-single-js">prev</button>
					<button title="<?php _e( 'Vai alla slide successiva', 'paperPlane-blankTheme' ); ?>"
						aria-label="<?php _e( 'Vai alla slide successiva', 'paperPlane-blankTheme' ); ?>"
						class="slide-next-custom slide-next-slider-single-js">next</button>
						-->
					<div class="slider-wrapper">
						<div class="paperplane-slider slider-single hidden-dots slider-single-js">
							<?php if ( $module['module_slideshow_repeater'] ) :
								foreach ( $module['module_slideshow_repeater'] as $slide ) : ?>
									<div class="slide">
										<?php $image_data = array(
											'image_type' => 'acf',
											// options: post_thumbnail, acf
											'image_value' => $slide['module_slideshow_repeater_image']
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
											'desktop_hd' => 'column_cut_hd',
											'mobile_hd' => 'column_cut'
										);
										print_theme_image( $image_data, $image_appearance, $image_sizes ); ?>
										<?php if ( $slide['module_slideshow_repeater_caption'] ) : ?>
											<div class="slide-caption">
												<figcaption>
													<?php echo $slide['module_slideshow_repeater_caption']; ?>
												</figcaption>
											</div>
										<?php endif; ?>
									</div>
								<?php endforeach; endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-slideshow -->