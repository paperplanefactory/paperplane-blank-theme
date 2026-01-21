<?php
/*
Rimosse da ACF le opzioni per gestire:

"page_opening_text_align_horizontal" -  allineamento orizzontale contenuti fullscreen - classi opzioni disponibili:
- alignleft
- alignright
- aligncenter
*/

$page_opening_text_align_horizontal_class = 'alignleft';
?>

<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<section class="page-opening-simple-spacer <?php echo $page_opening_text_align_horizontal_class; ?>">
				<div class="last-child-no-margin">
					<?php if ( $content_fields['page_breadcrumbs'] === 'yes' && function_exists( 'bcn_display' ) ) : ?>
						<nav class="breadcrumbs-holder underlined-links" typeof="BreadcrumbList" vocab="http://schema.org/"
							aria-label="<?php esc_html_e( 'Briciole di pane', 'paperPlane-blankTheme' ); ?>">
							<?php bcn_display(); ?>
						</nav>
					<?php endif; ?>
					<?php if ( $content_fields['page_opening_pre_title'] ?? null ) : ?>
						<p>
							<?php echo $content_fields['page_opening_pre_title']; ?>
						</p>
					<?php endif; ?>
					<?php if ( $content_fields['page_opening_title'] ) : ?>
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
			</section>
		</div>
	</div>
</div>