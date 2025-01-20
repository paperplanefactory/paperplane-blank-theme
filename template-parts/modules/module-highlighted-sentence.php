<!-- module-highlighted-sentence -->
<section class="wrapper module-highlighted-sentence">
	<a name="<?php echo $custom_anchor_point; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<div class="wrapper-padded-container">
				<?php
				// se esiste l'immagine associata alla frase in evidenza imposto il layout imagine + testo
				if ( $module['module_highlighted_sentence_image'] ?? null ) :
					?>
					<div class="flex-hold flex-hold-rich-highlighted-sentence">
						<div class="flex-hold-rich-highlighted-sentence-image">
							<div class="sticky-element">
								<div class="image-rounder" data-aos="fade-up">
									<?php
									$image_data = array(
										'image_type' => 'acf',
										// options: post_thumbnail, acf
										'image_value' => $module['module_highlighted_sentence_image']
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
										'mobile_hd' => 'round_image_hd'
									);
									print_theme_image( $image_data, $image_appearance, $image_sizes );
									?>
								</div>
							</div>
						</div>
						<div class="flex-hold-rich-highlighted-sentence-text fluid-typo">
							<div class="last-child-no-margin">
								<h2>
									<?php echo $module['module_highlighted_sentence_text']; ?>
								</h2>
								<?php if ( $module['module_highlighted_sentence_author'] ?? null ) : ?>
									<h3 class="as-h6">
										<?php echo $module['module_highlighted_sentence_author']; ?>
									</h3>
								<?php endif; ?>
							</div>
							<?php paperplane_theme_cta_advanced( $module['module_highlighted_sentence_cta'] ); ?>
						</div>
					</div>
					<?php
					// se non esiste l'immagine associata alla frase in evidenza imposto il layout semplice
				else :
					?>
					<div class="wrapper-padded-more-924">
						<div class="last-child-no-margin">
							<h2>
								<?php echo $module['module_highlighted_sentence_text']; ?>
							</h2>
							<?php if ( $module['module_highlighted_sentence_author'] ?? null ) : ?>
								<h3 class="as-h6">
									<?php echo $module['module_highlighted_sentence_author']; ?>
								</h3>
							<?php endif; ?>
						</div>
						<?php paperplane_theme_cta_advanced( $module['module_highlighted_sentence_cta'] ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<!-- module-highlighted-sentence -->