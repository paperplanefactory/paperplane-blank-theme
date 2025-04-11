<?php
/*
Rimosse da ACF le opzioni per gestire:

"page_opening_layout" - altezza box di apertura. Usare la classe opening-fullscreen o definirne una nuova se necessario
"on-header" - classe che posiziona il page opening sotto l'header. Rimuovere se i due elementi non devono essere sovrapposti.
"page_opening_text_align" - allineamento verticale contenuti fullscreen - classi opzioni disponibili:
- fullscreen-cta-center
- fullscreen-cta-top
- fullscreen-cta-bottom

"page_opening_text_align_horizontal" -  allineamento orizzontale contenuti fullscreen - classi opzioni disponibili:
- alignleft
- alignright
- aligncenter
*/

$page_opening_layout_and_vertical_text_align_class = 'opening-fullscreen fullscreen-cta-center';
$page_opening_text_align_horizontal_class = 'alignleft';
?>
<div class="wrapper page-opening on-header">
	<div class="fullscreen-cta coverize fluid-typo <?php echo $page_opening_layout_and_vertical_text_align_class; ?>">
		<?php
		if ( $content_fields['page_opening_media'] ?? null ) {
			$page_opening_media = $content_fields['page_opening_media'];
		} else {
			$page_opening_media = 'no-media';
		}
		if ( $page_opening_media === 'video' ) :
			?>
			<button id="opening-video-control" class="play-pause-animation animation-play-pause-js pause"
				data-video-stop="opening-video-js"
				aria-label="<?php _e( 'Avvia / pausa video', 'paperPlane-blankTheme' ); ?>" aria-pressed="true"
				aria-controls="opening-video-js"></button>
			<video poster="<?php echo $content_fields['page_opening_image_video_poster']['sizes']['full_desk']; ?>"
				id="opening-video-js" aria-hidden="true" class="stoppable-js" data-aos="fade-in"
				aria-labelledby="opening-video-control" data-autoplay autoplay loop muted playsinline>
				<source type="video/mp4" src="<?php echo $content_fields['page_opening_video_mp4']['url']; ?>">
				<meta itemprop="name"
					content="<?php echo __( 'Questo è un video senza audio, in autoplay e in loop.', 'paperPlane-blankTheme' ) . ' ' . $content_fields['page_opening_video_mp4']['title']; ?>">
				<meta itemprop="description" content="<?php echo $content_fields['page_opening_video_mp4']['caption']; ?>">
			</video>
			<?php
		elseif ( $page_opening_media === 'image' ) :
			if ( $content_fields['page_opening_image_mobile'] ?? null ) {
				$page_opening_image_mobile = $content_fields['page_opening_image_mobile'];
			} else {
				$page_opening_image_mobile = $content_fields['page_opening_image_desktop'];
			}
			?>
			<div class="desktop-only">
				<?php
				$image_data = array(
					'image_type' => 'acf',
					// options: post_thumbnail, acf
					'image_value' => $content_fields['page_opening_image_desktop']
					// se utilizzi un custom field indica qui il nome del campo
				);
				$image_appearance = array(
					// options: true, false
					'lazyload' => false,
					// options: sync, async
					'decoding' => 'async',
					// options: true, false - se false non mette contenitore intorno all'immagine
					'image-wrap' => false
				);
				$image_sizes = array(
					// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
					'desktop_hd' => 'full_desk_hd',
					'mobile_hd' => 'full_desk_hd'
				);
				print_theme_image( $image_data, $image_appearance, $image_sizes );
				?>
			</div>
			<div class="mobile-only">
				<?php
				$image_data = array(
					'image_type' => 'acf',
					// options: post_thumbnail, acf
					'image_value' => $page_opening_image_mobile
					// se utilizzi un custom field indica qui il nome del campo
				);
				$image_appearance = array(
					// options: true, false
					'lazyload' => false,
					// options: sync, async
					'decoding' => 'async',
					// options: true, false - se false non mette contenitore intorno all'immagine
					'image-wrap' => false
				);
				$image_sizes = array(
					// qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
					'desktop_hd' => 'full_desk',
					'mobile_hd' => 'full_desk'
				);
				print_theme_image( $image_data, $image_appearance, $image_sizes );
				?>
			</div>
		<?php endif; ?>
		<div class="above-image-opacity"></div>
		<div class="fullscreen-cta-aligner">
			<section class="fullscreen-cta-safe-padding <?php echo $page_opening_text_align_horizontal_class; ?>">
				<div class="wrapper-padded" data-aos="fade-up" data-aos-delay="300">
					<div class="last-child-no-margin">
						<?php if ( $content_fields['page_breadcrumbs'] === 'yes' && function_exists( 'bcn_display' ) ) : ?>
							<div class="breadcrumbs-holder underlined-links" typeof="BreadcrumbList"
								vocab="http://schema.org/">
								<?php bcn_display(); ?>
							</div>
						<?php endif; ?>
						<?php if ( $content_fields['page_opening_pre_title'] ?? null ) : ?>
							<p>
								<?php echo $content_fields['page_opening_pre_title']; ?>
							</p>
						<?php endif; ?>
						<?php if ( $content_fields['page_opening_title'] ?? null ) : ?>
							<h1>
								<?php echo $content_fields['page_opening_title']; ?>
							</h1>
						<?php else : ?>
							<h1>
								<?php the_title(); ?>
							</h1>
						<?php endif; ?>
						<?php if ( $content_fields['page_opening_subtitle'] ?? null ) : ?>
							<h2 class="as-p">
								<?php echo $content_fields['page_opening_subtitle']; ?>
							</h2>
						<?php endif; ?>
					</div>
					<div class="clearer"></div>
					<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_page_opening'] ); ?>
				</div>
			</section>
		</div>
	</div>
</div>