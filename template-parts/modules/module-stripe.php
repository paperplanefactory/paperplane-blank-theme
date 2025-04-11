<!-- module-stripe -->
<?php
// allineamento verticale striscia
$module_stripe_vertical_aligment = $module['module_stripe_vertical_aligment'];
?>
<div class="wrapper module-stripe">
	<a name="<?php echo $custom_anchor_point; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="<?php echo $module['module_stripe_width']; ?>">
				<?php
				if ( $module['module_stripe_repeater'] ) :
					foreach ( $module['module_stripe_repeater'] as $stripe ) :
						?>
						<!-- blocco -->
						<section
							class="flex-hold flex-hold-stripe-module stripe-listed <?php echo $module_stripe_vertical_aligment . ' ' . $stripe['module_stripe_repeater_order']; ?>">
							<!-- colonna -->
							<div class="module-stripe-image" data-aos="fade-up">
								<div class="spacer">
									<?php if ( $stripe['module_stripe_repeater_content_media'] === 'image' ) : ?>
										<?php
										$image_data = array(
											'image_type' => 'acf',
											// options: post_thumbnail, acf
											'image_value' => $stripe['module_stripe_repeater_image']
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
											'desktop_hd' => 'column_hd',
											'mobile_hd' => 'column'
										);
										print_theme_image( $image_data, $image_appearance, $image_sizes );
										?>
									<?php elseif ( $stripe['module_stripe_repeater_content_media'] === 'video' ) : ?>
										<?php paperplane_theme_videos( $stripe['module_stripe_repeater_video'] ); ?>
									<?php endif; ?>
								</div>
							</div>
							<!-- colonna -->
							<!-- colonna -->
							<div class="module-stripe-text fluid-typo" data-aos="fade-up" data-aos-delay="250">
								<div class="spacer">
									<?php if ( $stripe['stripe_pre_title'] ?? null ) : ?>
										<p>
											<?php echo $stripe['stripe_pre_title']; ?>
										</p>
									<?php endif; ?>
									<?php if ( $stripe['stripe_title'] ?? null ) : ?>
										<h2 class="txt-2">
											<?php echo $stripe['stripe_title']; ?>
										</h2>
									<?php endif; ?>
									<div class="content-styled last-child-no-margin">
										<?php echo $stripe['module_stripe_repeater_content']; ?>
									</div>
									<?php paperplane_theme_cta_advanced( $stripe['paperplane_theme_cta_stripe'] ); ?>
								</div>
							</div>
							<!-- colonna -->
						</section>
						<!-- blocco -->
					<?php endforeach; endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- module-stripe -->