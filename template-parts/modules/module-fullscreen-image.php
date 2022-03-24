<!-- module-fullscreen-image -->
<?php
$module_fullscreen_image_image = get_sub_field( 'module_fullscreen_image_image' );
if ( $module_fullscreen_image_image != '' ) {
  $module_fullscreen_image_image_URL = $module_fullscreen_image_image['sizes']['full_desk'];
  $module_fullscreen_image_image_hd_URL = $module_fullscreen_image_image['sizes']['full_desk_hd'];
  $bg_lazy_class = 'lazy coverize';
}
?>
<div class="wrapper module-fullscreen-image <?php the_sub_field( 'module_bg' ); ?> <?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="module-box-fullscreen coverize <?php the_sub_field( 'module_fullscreen_text_align' ); ?>  <?php echo $bg_lazy_class; ?>" data-bg="<?php echo $module_fullscreen_image_image_URL; ?>" data-bg-hidpi="<?php echo $module_fullscreen_image_image_hd_URL; ?>" data-aos="fade">
    <div class="above-image-opacity"></div>
    <div class="wrapper-padded">
      <div class="module-fullscreen-texts <?php the_sub_field( 'module_fullscreen_text_align_horizontal' ); ?>" data-aos="fade-right">
        <?php if ( get_sub_field( 'module_fullscreen_image_main_text' ) ) : ?>
          <h1><?php the_sub_field( 'module_fullscreen_image_main_text' ); ?></h1>
        <?php endif; ?>
        <?php if ( get_sub_field( 'module_fullscreen_image_secondary_text' ) ) : ?>
          <h2><?php the_sub_field( 'module_fullscreen_image_secondary_text' ); ?></h2>
        <?php endif; ?>
        <div class="clearer"></div>
        <?php include( locate_template( 'template-parts/modules/module-cta-default.php' ) ); ?>
      </div>
    </div>
  </div>
</div>
<!-- module-fullscreen-image -->
