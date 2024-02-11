<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<section
				class="page-opening-simple-spacer <?php echo $content_fields['page_opening_text_align_horizontal']; ?>">
				<div class="last-child-no-margin">
					<?php if ( $content_fields['page_breadcrumbs'] === 'yes' && function_exists( 'bcn_display' ) ) : ?>
						<div class="breadcrumbs-holder underlined-links" typeof="BreadcrumbList" vocab="http://schema.org/">
							<?php bcn_display(); ?>
						</div>
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
					<?php if ( $content_fields['page_opening_subtitle'] ) : ?>
						<p>
							<?php echo $content_fields['page_opening_subtitle']; ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="clearer"></div>
				<?php paperplane_theme_cta_advanced( $content_fields['paperplane_theme_cta_page_opening'] ); ?>
			</section>
		</div>
	</div>
</div>