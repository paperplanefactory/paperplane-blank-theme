<!-- module-slideshow -->
<section class="wrapper module-slideshow">
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-924">
					<div id="<?php echo $custom_anchor_point; ?>" class="section-anchor">
						<!--
						Riferimenti per bottoni di navigazione separati rispetto a quelli nativi, da configurare in JS
					<button title="<?php esc_html_e( 'Vai alla slide precedente', 'paperPlane-blankTheme' ); ?>"
						aria-label="<?php esc_html_e( 'Vai alla slide precedente', 'paperPlane-blankTheme' ); ?>"
						class="slide-prev-custom slide-prev-slider-single-js">prev</button>
					<button title="<?php esc_html_e( 'Vai alla slide successiva', 'paperPlane-blankTheme' ); ?>"
						aria-label="<?php esc_html_e( 'Vai alla slide successiva', 'paperPlane-blankTheme' ); ?>"
						class="slide-next-custom slide-next-slider-single-js">next</button>
						-->
						<div class="slider-wrapper">
							<div class="paperplane-slider slider-images hidden-dots slider-images-js">
								<?php if ( $module['module_slideshow_repeater'] ) :
									foreach ( $module['module_slideshow_repeater'] as $slide ) :
										?>
										<div class="slide">
											<?php $image_data = array(
												'image_type' => 'acf',
												'image_value' => $slide['module_slideshow_repeater_image']
											);
											$image_appearance = array(
												'lazyload' => true,
												'decoding' => 'async',
												'image-wrap' => true,
												'image-wrap-custom-class' => ''
											);
											$image_sizes = array(
												'desktop_hd' => 'column_hd',
												'mobile_hd' => 'column'
											);
											print_theme_image( $image_data, $image_appearance, $image_sizes ); ?>
											<?php if ( $slide['module_slideshow_repeater_image']['caption'] ) : ?>
												<div class="slide-caption">
													<figcaption>
														<?php echo $slide['module_slideshow_repeater_image']['caption']; ?>
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
	</div>
</section>
<!-- module-slideshow -->