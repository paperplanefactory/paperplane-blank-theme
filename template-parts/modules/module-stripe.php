<!-- module-stripe -->
<?php
// allineamento verticale striscia
$module_stripe_vertical_aligment = $module['module_stripe_vertical_aligment'];
?>
<div class="wrapper module-stripe <?php echo $module['module_bg']; ?>">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="<?php echo $module['module_stripe_width']; ?>">
				<?php
				if ( $module['module_stripe_repeater'] ) :
					foreach ( $module['module_stripe_repeater'] as $stripe ) :
						$module_stripe_repeater_content_media = $stripe['module_stripe_repeater_content_media'];
						?>
						<!-- blocco -->
						<div
							class="flex-hold flex-hold-stripe-module stripe-listed <?php echo $module_stripe_vertical_aligment . ' ' . $stripe['module_stripe_repeater_order']; ?>">
							<!-- colonna -->
							<div class="module-stripe-image" data-aos="fade-up">
								<div class="spacer">
									<?php if ( $module_stripe_repeater_content_media === 'image' ) : ?>
										<?php paperplane_theme_cta_absl_advanced( $stripe['paperplane_theme_cta_stripe'] ); ?>
										<?php
										$image_data = array(
											'image_type' => 'acf',
											// options: post_thumbnail, acf
											'image_value' => $stripe['module_stripe_repeater_image'],
											// se utilizzi un custom field indica qui il nome del campo
											'size_fallback' => 'column'
										);
										$image_sizes = array(
											// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
											'desktop_default' => 'column',
											'desktop_hd' => 'column_hd',
											'mobile_default' => 'column',
											'mobile_hd' => 'column_hd',
											'lazy_placheholder' => 'micro'
										);
										print_theme_image( $image_data, $image_sizes );
										?>
									<?php elseif ( $module_stripe_repeater_content_media === 'video' ) : ?>
										<?php paperplane_theme_videos( $stripe['module_stripe_repeater_video'] ); ?>
									<?php endif; ?>
								</div>
							</div>
							<!-- colonna -->
							<!-- colonna -->
							<div class="module-stripe-text fluid-typo" data-aos="fade-in" data-aos-delay="250">
								<div class="spacer">
									<div class="content-styled last-child-no-margin">
										<?php echo $stripe['module_stripe_repeater_content']; ?>
									</div>
									<?php paperplane_theme_cta_advanced( $stripe['paperplane_theme_cta_stripe'] ); ?>
								</div>
							</div>
							<!-- colonna -->
						</div>
						<!-- blocco -->
					<?php endforeach; endif; ?>
			</div>
			<?php paperplane_theme_cta_advanced( $module['paperplane_theme_cta'] ); ?>
		</div>
	</div>
</div>
<!-- module-stripe -->