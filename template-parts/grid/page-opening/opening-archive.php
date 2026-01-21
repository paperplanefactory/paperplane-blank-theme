<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<section class="page-opening-simple-spacer alignleft">
				<div class="last-child-no-margin">
					<?php if ( function_exists( 'bcn_display' ) ) : ?>
						<nav class="breadcrumbs-holder underlined-links" typeof="BreadcrumbList" vocab="http://schema.org/"
							aria-label="<?php esc_html_e( 'Briciole di pane', 'paperPlane-blankTheme' ); ?>">
							<?php bcn_display(); ?>
						</nav>
					<?php endif; ?>
					<h1>
						<?php single_term_title(); ?>
					</h1>
					<?php if ( term_description() ) : ?>
						<p>
							<?php echo term_description(); ?>
						</p>
					<?php endif; ?>
				</div>
				<div class="clearer"></div>
			</section>
		</div>
	</div>
</div>