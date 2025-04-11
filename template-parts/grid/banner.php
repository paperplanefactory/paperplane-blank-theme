<?php
$content_fields_banner = paperplane_content_transients( $post->ID );
?>
<div class="wrapper-padded">
	<div class="banner-space">
		<article class="banner-content">
			<div class="last-child-no-margin">
				<h2 class="as-h3">
					<?php the_title(); ?>
				</h2>
				<?php if ( $content_fields_banner['banner_txts'] ?? null ) : ?>
					<?php echo $content_fields_banner['banner_txts']; ?>
				<?php endif; ?>
			</div>
			<?php paperplane_theme_cta_advanced( $content_fields_banner['paperplane_theme_cta_banner'] ); ?>
		</article>
	</div>
</div>