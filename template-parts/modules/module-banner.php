<!-- module-banner -->
<?php
$banner = $module['module_banner_object'];
if ( $banner ) :
	$post = $banner;
	setup_postdata( $post );
	?>
	<section class="wrapper module-banner">
		<a name="<?php echo $custom_anchor_point; ?>" class="section-anchor"></a>
		<div class="<?php echo $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
			<?php
			include( locate_template( 'template-parts/grid/banner.php' ) );
			wp_reset_postdata();
			?>
		</div>
	</section>
<?php endif; ?>
<!-- module-banner -->