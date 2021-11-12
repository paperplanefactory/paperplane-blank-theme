<!-- module-fullscreen-image -->
<?php
$module_fullscreen_image_image = get_sub_field( 'module_fullscreen_image_image' );
if ( $module_fullscreen_image_image != '' ) {
  $module_fullscreen_image_image_URL = $module_fullscreen_image_image['sizes']['full_desk'];
  $module_fullscreen_image_image_hd_URL = $module_fullscreen_image_image['sizes']['full_desk_hd'];
  $bg_lazy_class = 'lazy coverize';
}

// recupero le informazioni per la CTA del modulo
$cta_text_data = get_sub_field( 'module_additional_elements_cta_text' );
if ( $cta_text_data != '' ) {
  $cta_type_data = get_sub_field( 'module_additional_elements_cta_target' );
  switch ( $cta_type_data ) {
    case 'cta-target-internal' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_internal' );
    $cta_url_target = '_self';
    $cta_url_parameter_data = get_sub_field( 'module_additional_elements_cta_target_internal_parameter' );
    if ( $cta_url_parameter_data != '' ) {
      $cta_url_data = $cta_url_data . $cta_url_parameter_data;
    }
    break;
    case 'cta-target-external' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_external' );
    $cta_url_target = '_blank';
    break;
    case 'cta-target-file' :
    $cta_url_data = get_sub_field( 'module_additional_elements_cta_target_file' );
    $cta_url_target = '_blank';
    break;
  }
  $cta_appearence = get_sub_field( 'module_additional_elements_cta_appearence' );
}
?>
<div class="wrapper module-fullscreen-image <?php the_sub_field( 'module_bg' ); ?> <?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
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
        <?php
        // se è impostata la CTA la inserisco
        if ( $cta_text_data != '' ) :
          ?>
          <div class="cta-holder">
            <a href="<?php echo $cta_url_data; ?>" target="<?php echo $cta_url_target; ?>" class="<?php echo $cta_appearence; ?> allupper"><?php echo $cta_text_data; ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- module-fullscreen-image -->
