<!-- module-cards -->
<?php
global $cta_align_class;
$analize_content = $module['module_text'];
if ( strpos( $analize_content, 'text-align: center;' ) ) {
	$cta_align_class = 'aligncenter';
} elseif ( strpos( $analize_content, 'text-align: right;' ) ) {
	$cta_align_class = 'alignright';
} else {
	$cta_align_class = '';
}
?>
<section class="wrapper module-cards bg-4">
	<a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
	<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
		<div class="wrapper-padded">
			<?php if ( $module['module_cards_repeater'] ) : ?>
				<div class="flex-hold flex-hold-3">
					<?php foreach ( $module['module_cards_repeater'] as $card ) : ?>
						<?php include( locate_template( 'template-parts/grid/card.php' ) ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<!-- module-cards -->