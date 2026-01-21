<li class="flex-hold-child" data-aos="fade-up">
	<article class="inner card bg-4">
		<?php if ( isset( $card['module_cards_repeater_image'] ) ) : ?>
			<div class="card-image" aria-hidden="true">
				<?php
				$image_data = array(
					'image_type' => 'acf',
					'image_value' => $card['module_cards_repeater_image']
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
				print_theme_image( $image_data, $image_appearance, $image_sizes );
				?>
			</div>
		<?php endif; ?>
		<div class="card-texts last-child-no-margin">
			<h2 class="as-h4 element-hover">
				<?php echo $card['module_cards_repeater_title']; ?>
			</h2>
			<a href="#test" class="card-link"><span class="screen-reader-text">Link con titolo contenuto solo per
					screen
					reader</span></a>

			<?php if ( isset( $card['module_cards_repeater_description'] ) ) : ?>
				<div class="preserve-text remove-underline-js">
					<p>
						<?php echo $card['module_cards_repeater_description']; ?>
					</p>
				</div>
			<?php endif; ?>
			<div class="preserve-text remove-underline-js">
				<a href="https://paperplaneblanktheme.local/sample-page/" target="_self" class="default-button-b"
					data-modal-id="" data-modal-title="" data-modal-back-to="">Interno<span
						class="screen-reader-text">Sample Page!</span></a>
			</div>

		</div>
		<div class="cta-holder fake-cta" aria-hidden="true">
			<span class="default-button">CTA finta (link uguale a .card-link)</span>
		</div>
	</article>
</li>