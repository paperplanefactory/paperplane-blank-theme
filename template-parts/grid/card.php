<article class="flex-hold-child card" data-aos="fade-up">
	<div class="inner bg-4">
		<?php if ( isset( $card['module_cards_repeater_image'] ) ) : ?>
			<div class="card-image" aria-hidden="true">
				<?php
				$image_data = array(
					'image_type' => 'acf',
					// options: post_thumbnail, acf
					'image_value' => $card['module_cards_repeater_image']
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
			</div>
		<?php endif; ?>
		<div class="card-texts last-child-no-margin">
			<h2 class="as-h3">
				<?php echo $card['module_cards_repeater_title']; ?>
			</h2>
			<?php if ( isset( $card['module_cards_repeater_description'] ) ) : ?>
				<p>
					<?php echo $card['module_cards_repeater_description']; ?>
				</p>
			<?php endif; ?>
			<a href="#" class="card-link" aria-label="Titolo contenuto"></a>
			<?php
			paperplane_theme_cta_advanced( $card['module_cards_repeater_cta'] );
			?>
		</div>
	</div>
</article>