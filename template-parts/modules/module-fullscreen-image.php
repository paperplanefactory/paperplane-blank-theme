<!-- module-fullscreen-image -->
<?php
$module_fullscreen_image_image = get_sub_field( 'module_fullscreen_image_image' );
$module_fullscreen_image_image_URL = $module_fullscreen_image_image['sizes']['full_desk'];
$module_fullscreen_image_cta_target = get_sub_field( 'module_fullscreen_image_cta_target' );
switch ( $module_fullscreen_image_cta_target ) {
  case 'cta-target-internal' :
  $module_fullscreen_image_cta_url = get_sub_field( 'module_fullscreen_image_cta_target_internal' );
  $module_fullscreen_image_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $module_fullscreen_image_cta_url = get_sub_field( 'module_fullscreen_image_cta_target_external' );
  $module_fullscreen_image_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $module_fullscreen_image_cta_url = get_sub_field( 'module_fullscreen_image_cta_target_file' );
  $module_fullscreen_image_cta_url_target = '_blank';
  break;
}
if ( get_sub_field( 'module_fullscreen_image_main_text' ) || get_sub_field( 'module_fullscreen_image_secondary_text' ) || get_sub_field( 'module_fullscreen_image_cta_text' ) ) {
  $blended_class = 'blended';
}
?>
<div class="wrapper module-fullscreen-image">
  <?php if ( $module_fullscreen_image_image != '' ) : ?>
    <div class="module-box-fullscreen fullscreen-cta <?php the_sub_field( 'module_fullscreen_text_align' ); ?> lazy coverize <?php echo $blended_class; ?> <?php the_sub_field( 'module_fullscreen_image_color_scheme' ); ?>" data-bg="url('<?php echo $module_fullscreen_image_image_URL; ?>')" data-aos="fade">
  <?php else : ?>
    <div class="module-box-fullscreen fullscreen-cta <?php the_sub_field( 'module_fullscreen_text_align' ); ?> <?php the_sub_field( 'module_fullscreen_image_color_scheme' ); ?>">
  <?php endif; ?>
    <div class="fullscreen-cta-aligner">
      <div class="wrapper">
        <div class="wrapper-padded">
          <div class="wrapper-padded-more">
            <div class="fullscreen-cta-safe-padding <?php the_sub_field( 'module_fullscreen_text_align_horizontal' ); ?>" data-aos="fade-right">
              <div class="last-child-no-margin">
                <?php if ( get_sub_field( 'module_fullscreen_image_main_text' ) ) : ?>
                  <h1><?php the_sub_field( 'module_fullscreen_image_main_text' ); ?></h1>
                <?php endif; ?>
                <?php if ( get_sub_field( 'module_fullscreen_image_secondary_text' ) ) : ?>
                  <h2><?php the_sub_field( 'module_fullscreen_image_secondary_text' ); ?></h2>
                <?php endif; ?>
              </div>
              <div class="clearer"></div>
              <?php if ( get_sub_field( 'module_fullscreen_image_cta_text' ) ) : ?>
                <div class="cta-holder">
                  <a href="<?php echo $module_fullscreen_image_cta_url; ?>" target="<?php echo $module_fullscreen_image_cta_url_target; ?>" class="<?php the_sub_field( 'module_fullscreen_image_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_fullscreen_image_cta_text' ); ?></a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-fullscreen-image -->
