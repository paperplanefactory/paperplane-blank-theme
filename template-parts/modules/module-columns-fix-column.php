<!-- module-module-columns-fix-column -->
<?php
// recupero la colonna che deve restare fissa
$module_columns_fix_side = $module['module_columns_fix_side'];
$module_columns_fix_fix_column_image_format = $module['module_columns_fix_fix_column_image_format'];
?>
<section class="wrapper module-columns-fix-column">
	<a name="<?php echo $custom_anchor_point; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<div
					class="flex-hold flex-fix-column <?php echo $module['module_columns_fix_side']; ?> module-column-box">
					<div class="fix">
						<div class="sticky-element">
							<div class="<?php echo $module['module_columns_fix_fix_column_align']; ?>">
								<?php if ( $module['module_columns_fix_fix_column_image'] ?? null ) : ?>
									<div class="column-image">
										<?php if ( $module_columns_fix_fix_column_image_format === 'normal-image' ) : ?>
											<?php
											$image_data = array(
												'image_type' => 'acf',
												// options: post_thumbnail, acf
												'image_value' => $module['module_columns_fix_fix_column_image']
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
												'mobile_hd' => 'column_hd'
											);
											print_theme_image( $image_data, $image_appearance, $image_sizes );
											?>
										<?php elseif ( $module_columns_fix_fix_column_image_format === 'round-image' ) : ?>
											<div class="image-rounder">
												<?php
												$image_data = array(
													'image_type' => 'acf',
													// options: post_thumbnail, acf
													'image_value' => $module['module_columns_fix_fix_column_image']
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
													'desktop_hd' => 'round_image_hd',
													'mobile_hd' => 'round_image'
												);
												print_theme_image( $image_data, $image_appearance, $image_sizes );
												?>
											</div>
										<?php else : ?>
											<div class="image-icon">
												<?php
												$image_data = array(
													'image_type' => 'acf',
													// options: post_thumbnail, acf
													'image_value' => $module['module_columns_fix_fix_column_image']
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
													'desktop_hd' => 'round_image_hd',
													'mobile_hd' => 'round_image'
												);
												print_theme_image( $image_data, $image_appearance, $image_sizes );
												?>
											</div>
										<?php endif; ?>
									</div>
								<?php endif; ?>
								<?php if ( $module['module_columns_fix_fix_column_content'] ?? null ) : ?>
									<div class="content-styled last-child-no-margin">
										<?php echo $module['module_columns_fix_fix_column_content']; ?>
									</div>
								<?php endif; ?>
								<?php paperplane_theme_cta_advanced( $module['paperplane_theme_cta_fix_column'] ); ?>
							</div>
						</div>
					</div>
					<div class="nofix">
						<div class="flex-hold flex-hold-2 margins-thin">
							<?php
							if ( $module['module_columns_fix_repeater'] ?? null ) :
								foreach ( $module['module_columns_fix_repeater'] as $column_fix ) :
									$module_columns_fix_repeater_image_format = $column_fix['module_columns_fix_repeater_image_format'];
									?>
									<div class="flex-hold-child module-column-box">
										<div class="<?php echo $column_fix['module_columns_fix_repeater_align']; ?>">
											<?php if ( $column_fix['module_columns_fix_repeater_image'] ?? null ) : ?>
												<div class="column-image">
													<?php if ( $module_columns_fix_repeater_image_format === 'normal-image' ) : ?>
														<?php
														$image_data = array(
															'image_type' => 'acf',
															// options: post_thumbnail, acf
															'image_value' => $column_fix['module_columns_fix_repeater_image']
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
															'mobile_hd' => 'column_hd'
														);
														print_theme_image( $image_data, $image_appearance, $image_sizes );
														?>
													<?php elseif ( $module_columns_fix_repeater_image_format === 'round-image' ) : ?>
														<div class="image-rounder">
															<?php
															$image_data = array(
																'image_type' => 'acf',
																// options: post_thumbnail, acf
																'image_value' => $column_fix['module_columns_fix_repeater_image']
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
																'desktop_hd' => 'round_image_hd',
																'mobile_hd' => 'round_image'
															);
															print_theme_image( $image_data, $image_appearance, $image_sizes );
															?>
														</div>
													<?php else : ?>
														<div class="image-icon">
															<?php
															$image_data = array(
																'image_type' => 'acf',
																// options: post_thumbnail, acf
																'image_value' => $column_fix['module_columns_fix_repeater_image']
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
																'desktop_hd' => 'round_image_hd',
																'mobile_hd' => 'round_image'
															);
															print_theme_image( $image_data, $image_appearance, $image_sizes );
															?>
														</div>
													<?php endif; ?>
												</div>
											<?php endif; ?>
											<?php if ( $column_fix['module_columns_fix_repeater_content'] ?? null ) : ?>
												<div class="content-styled last-child-no-margin">
													<?php echo $column_fix['module_columns_fix_repeater_content']; ?>
												</div>
											<?php endif; ?>
											<?php paperplane_theme_cta_advanced( $column_fix['paperplane_theme_cta_fix_column_columns'] ); ?>
										</div>
									</div>
								<?php endforeach; endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- module-module-columns-fix-column -->