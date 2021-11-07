<!-- module-module-columns-fix-column -->
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
// recupero le informazioni per la CTA della colonna fissa
$cta_fix_column_text_data = get_sub_field( 'module_columns_fix_fix_column_cta_text' );
if ( $cta_fix_column_text_data != '' ) {
  $cta_fix_column_type_data = get_sub_field( 'module_columns_fix_fix_column_cta_target' );
  switch ( $cta_fix_column_type_data ) {
    case 'cta-target-internal' :
    $cta_fix_column_url_data = get_sub_field( 'module_columns_fix_fix_column_cta_target_internal' );
    $cta_fix_column_url_target = '_self';
    $cta_fix_column_url_parameter_data = get_sub_field( 'module_columns_fix_fix_column_cta_target_internal_parameter' );
    if ( $cta_fix_column_url_parameter_data != '' ) {
      $cta_fix_column_url_data = $cta_fix_column_url_data . $cta_fix_column_url_parameter_data;
    }
    break;
    case 'cta-target-external' :
    $cta_fix_column_url_data = get_sub_field( 'module_columns_fix_fix_column_cta_target_external' );
    $cta_fix_column_url_target = '_blank';
    break;
    case 'cta-target-file' :
    $cta_fix_column_url_data = get_sub_field( 'module_columns_fix_fix_column_cta_target_file' );
    $cta_fix_column_url_target = '_blank';
    break;
  }
  $cta_fix_column_appearence = get_sub_field( 'module_columns_fix_fix_column_cta_appearence' );
}
// recupero la colonna che deve restare fissa
$module_columns_fix_side = get_sub_field( 'module_columns_fix_side' );
$module_columns_fix_fix_column_image = get_sub_field( 'module_columns_fix_fix_column_image' );
$module_columns_fix_fix_column_image_format = get_sub_field( 'module_columns_fix_fix_column_image_format' );
 ?>
<div class="wrapper module-columns-fix-column <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="flex-hold flex-fix-column <?php the_sub_field( 'module_columns_fix_side' ); ?> module-column-box">
          <div class="fix">
            <div class="sticky-element">
              <div class="<?php the_sub_field( 'module_columns_fix_fix_column_align' ); ?>">
                <?php if ( $module_columns_fix_fix_column_image != '' ) : ?>
                  <div class="column-image">
                    <?php if ( $module_columns_fix_fix_column_image_format === 'normal-image' ) : ?>
                      <?php
                      $image_data = array(
                          'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                          'image_value' => 'module_columns_fix_fix_column_image', // se utilizzi un custom field indica qui il nome del campo
                          'size_fallback' => 'micro'
                      );
                      $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                          'desktop_default' => 'column',
                          'desktop_hd' => 'column_hd',
                          'mobile_default' => 'column',
                          'mobile_hd' => 'column_hd',
                          'lazy_placheholder' => 'micro'
                      );
                      print_theme_image( $image_data, $image_sizes );
                      ?>
                    <?php elseif ( $module_columns_fix_fix_column_image_format === 'round-image' ) : ?>
                      <div class="image-rounder">
                        <?php
                        $image_data = array(
                            'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                            'image_value' => 'module_columns_fix_fix_column_image', // se utilizzi un custom field indica qui il nome del campo
                            'size_fallback' => 'micro'
                        );
                        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'round_image',
                            'desktop_hd' => 'round_image_hd',
                            'mobile_default' => 'round_image',
                            'mobile_hd' => 'round_image',
                            'lazy_placheholder' => 'micro'
                        );
                        print_theme_image( $image_data, $image_sizes );
                        ?>
                      </div>
                    <?php else : ?>
                      <div class="image-icon">
                        <?php
                        $image_data = array(
                            'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                            'image_value' => 'module_columns_fix_fix_column_image', // se utilizzi un custom field indica qui il nome del campo
                            'size_fallback' => 'micro'
                        );
                        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'column',
                            'desktop_hd' => 'column_hd',
                            'mobile_default' => 'column',
                            'mobile_hd' => 'column_hd',
                            'lazy_placheholder' => 'micro'
                        );
                        print_theme_image( $image_data, $image_sizes );
                        ?>
                      </div>
                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <?php if ( get_sub_field( 'module_columns_fix_fix_column_content' ) ) : ?>
                  <div class="content-styled last-child-no-margin">
                    <?php the_sub_field( 'module_columns_fix_fix_column_content' ); ?>
                  </div>
                <?php endif; ?>
                <?php
                // se è impostata la CTA della colonna fissa la inserisco
                if ( $cta_fix_column_text_data != '' ) :
                  ?>
                  <div class="cta-holder">
                    <a href="<?php echo $cta_fix_column_url_data; ?>" target="<?php echo $cta_fix_column_url_target; ?>" class="<?php echo $cta_fix_column_appearence; ?> allupper"><?php echo $cta_fix_column_text_data; ?></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <div class="nofix">
            <div class="flex-hold flex-hold-2 margins-thin">
              <?php
              if ( have_rows( 'module_columns_fix_repeater' ) ) : while ( have_rows( 'module_columns_fix_repeater' ) ) : the_row();
              // recupero le informazioni per la CTA della colonna
              $cta_fix_column_repeater_text_data = get_sub_field( 'module_columns_fix_repeater_cta_text' );
              if ( $cta_fix_column_repeater_text_data != '' ) {
                $cta_fix_column_repeater_type_data = get_sub_field( 'module_columns_fix_repeater_cta_target' );
                switch ( $cta_fix_column_repeater_type_data ) {
                  case 'cta-target-internal' :
                  $cta_fix_column_repeater_url_data = get_sub_field( 'module_columns_fix_repeater_cta_target_internal' );
                  $cta_fix_column_repeater_url_target = '_self';
                  $cta_fix_column_repeater_url_parameter_data = get_sub_field( 'module_columns_fix_repeater_cta_target_internal_parameter' );
                  if ( $cta_fix_column_repeater_url_parameter_data != '' ) {
                    $cta_fix_column_repeater_url_data = $cta_fix_column_repeater_url_data . $cta_fix_column_repeater_url_parameter_data;
                  }
                  break;
                  case 'cta-target-external' :
                  $cta_fix_column_repeater_url_data = get_sub_field( 'module_columns_fix_repeater_cta_target_external' );
                  $cta_fix_column_repeater_url_target = '_blank';
                  break;
                  case 'cta-target-file' :
                  $cta_fix_column_repeater_url_data = get_sub_field( 'module_columns_fix_repeater_cta_target_file' );
                  $cta_fix_column_repeater_url_target = '_blank';
                  break;
                }
                $cta_fix_column_repeater_appearence = get_sub_field( 'module_columns_fix_repeater_cta_appearence' );
              }
              $module_columns_fix_repeater_image = get_sub_field( 'module_columns_fix_repeater_image' );
              $module_columns_fix_repeater_image_format = get_sub_field( 'module_columns_fix_repeater_image_format' );

              ?>
              <div class="flex-hold-child module-column-box">
                <div class="<?php the_sub_field( 'module_columns_fix_repeater_align' ); ?>">
                  <?php if ( $module_columns_fix_repeater_image != '' ) : ?>
                    <div class="column-image">
                      <?php if ( $module_columns_fix_repeater_image_format === 'normal-image' ) : ?>
                        <?php
                        $image_data = array(
                            'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                            'image_value' => 'module_columns_fix_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                            'size_fallback' => 'micro',
                            'lazy_placheholder' => 'micro'
                        );
                        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'column',
                            'desktop_hd' => 'column_hd',
                            'mobile_default' => 'column',
                            'mobile_hd' => 'column_hd',
                            'lazy_placheholder' => 'micro'
                        );
                        print_theme_image( $image_data, $image_sizes );
                        ?>
                      <?php elseif ( $module_columns_fix_repeater_image_format === 'round-image' ) : ?>
                        <div class="image-rounder">
                          <?php
                          $image_data = array(
                              'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                              'image_value' => 'module_columns_fix_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                              'size_fallback' => 'micro'
                          );
                          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                              'desktop_default' => 'round_image',
                              'desktop_hd' => 'round_image_hd',
                              'mobile_default' => 'round_image',
                              'mobile_hd' => 'round_image',
                              'lazy_placheholder' => 'micro'
                          );
                          print_theme_image( $image_data, $image_sizes );
                          ?>
                        </div>
                      <?php else : ?>
                        <div class="image-icon">
                          <?php
                          $image_data = array(
                              'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                              'image_value' => 'module_columns_fix_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                              'size_fallback' => 'micro'
                          );
                          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                              'desktop_default' => 'column',
                              'desktop_hd' => 'column_hd',
                              'mobile_default' => 'column',
                              'mobile_hd' => 'column_hd',
                              'lazy_placheholder' => 'micro'
                          );
                          print_theme_image( $image_data, $image_sizes );
                          ?>
                        </div>
                      <?php endif; ?>
                    </div>
                  <?php endif; ?>
                  <?php if ( get_sub_field( 'module_columns_fix_repeater_content' ) ) : ?>
                    <div class="content-styled last-child-no-margin">
                      <?php the_sub_field( 'module_columns_fix_repeater_content' ); ?>
                    </div>
                  <?php endif; ?>
                  <?php
                  // se è impostata la CTA la inserisco
                  if ( $cta_fix_column_repeater_text_data != '' ) :
                    ?>
                    <div class="cta-holder">
                      <a href="<?php echo $cta_fix_column_repeater_url_data; ?>" target="<?php echo $cta_fix_column_repeater_url_target; ?>" class="<?php echo $cta_fix_column_repeater_appearence; ?> allupper"><?php echo $cta_fix_column_repeater_text_data; ?></a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endwhile; endif; ?>
            </div>

          </div>
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
<!-- module-module-columns-fix-column -->
