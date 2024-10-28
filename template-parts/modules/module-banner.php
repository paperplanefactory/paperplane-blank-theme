<!-- module-banner -->
<?php
$banner = $module['module_banner_object'];
if ( $banner ) :
	$post = $banner;
	setup_postdata( $post );
	$content_fields = paperplane_content_transients( $post->ID );
	?>
	<section class="wrapper module-banner bg-4">
		<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
		<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
			<div class="wrapper-padded">
				<div class="wrapper-padded-container">
					<div class="banner-space">
						<?php if ( $content_fields['banner_background_image'] ?? null ) : ?>
							<div class="banner-mask-image coverize">
								<?php
								$image_data = array(
									'image_type' => 'acf',
									// options: post_thumbnail, acf
									'image_value' => $content_fields['banner_background_image']
									// se utilizzi un custom field indica qui il nome del campo
								);
								$image_appearance = array(
									// options: true, false
									'lazyload' => true,
									// options: sync, async
									'decoding' => 'async',
									// options: true, false - se false non mette contenitore intorno all'immagine
									'image-wrap' => false
								);
								$image_sizes = array(
									// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
									'desktop_hd' => 'column_hd',
									'mobile_hd' => 'column'
								);
								print_theme_image( $image_data, $image_appearance, $image_sizes );
								?>
								<div class="above-image-opacity"></div>
							</div>
						<?php endif; ?>
						<div class="banner-content">
							<?php if ( $content_fields['banner_foreground_image'] ?? null ) : ?>
								<div class="flex-hold flex-hold-banner">
									<div class="banner-image uncoverize image-as-link" data-aos="zoom-out">
										<?php paperplane_theme_cta_absl_advanced( $content_fields['paperplane_theme_cta_banner'] ); ?>
										<?php
										$image_data = array(
											'image_type' => 'acf',
											// options: post_thumbnail, acf
											'image_value' => $content_fields['banner_foreground_image']
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
											'desktop_hd' => 'banner_hd',
											'mobile_hd' => 'banner_hd'
										);
										print_theme_image( $image_data, $image_appearance, $image_sizes );
										?>
									</div>
									<div class="banner-texts">
										<div class="last-child-no-margin">
											<h2>
												<?php the_title(); ?>
											</h2>
											<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_banner'] ); ?>
										</div>
									</div>
								</div>
							<?php else : ?>
								<div class="last-child-no-margin">
									<h2>
										<?php the_title(); ?>
									</h2>
									<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_banner'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- module-banner -->
	<?php wp_reset_postdata(); endif; ?>