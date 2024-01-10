<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<section class="page-opening-simple-spacer alignleft">
				<div class="last-child-no-margin">
					<?php if ( function_exists( 'bcn_display' ) ) : ?>
						<div class="breadcrumbs-holder undelinked-links" typeof="BreadcrumbList" vocab="http://schema.org/">
							<?php bcn_display(); ?>
						</div>
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