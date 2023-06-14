<!-- module-slideshow -->
<div class="wrapper module-slideshow <?php echo $module['module_bg']; ?>">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div class="wrapper-padded-more-924">
					<div class="slider-single slider-single-js">
						<?php if ( $module['module_slideshow_repeater'] ) :
							foreach ( $module['module_slideshow_repeater'] as $slide ) : ?>
								<div class="slide">
									<?php $image_data = array(
										'image_type' => 'acf',
										// options: post_thumbnail, acf
										'image_value' => $slide['module_slideshow_repeater_image'],
										// se utilizzi un custom field indica qui il nome del campo
										'size_fallback' => 'column_cut'
									);
									$image_sizes = array(
										// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
										'desktop_default' => 'column_cut',
										'desktop_hd' => 'column_cut_hd',
										'mobile_default' => 'column_cut',
										'mobile_hd' => 'column_cut_hd',
										'lazy_placheholder' => 'micro'
									);
									print_theme_image( $image_data, $image_sizes ); ?>
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
<!-- module-slideshow -->