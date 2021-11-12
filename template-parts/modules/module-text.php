<!-- module-text -->
<?php
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
<section class="wrapper module-text <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-700">
          <div class="content-styled last-child-no-margin">
            <?php the_sub_field( 'module_text' ); ?>
          </div>
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
</section>
<!-- module-text -->
