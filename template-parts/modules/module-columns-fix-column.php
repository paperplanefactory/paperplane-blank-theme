<!-- module-module-columns-fix-column -->
<?php
// recupero la colonna che deve restare fissa
$module_columns_fix_side = get_sub_field( 'module_columns_fix_side' );
$module_columns_fix_fix_column_image = get_sub_field( 'module_columns_fix_fix_column_image' );
$module_columns_fix_fix_column_image_format = get_sub_field( 'module_columns_fix_fix_column_image_format' );
 ?>
<div class="wrapper module-columns-fix-column <?php the_sub_field( 'module_bg' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
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
                          'size_fallback' => 'column'
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
                            'size_fallback' => 'round_image'
                        );
                        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'round_image',
                            'desktop_hd' => 'round_image_hd',
                            'mobile_default' => 'round_image',
                            'mobile_hd' => 'round_image',
                            'lazy_placheholder' => 'micro_cut'
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
                            'size_fallback' => 'column'
                        );
                        $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                          'desktop_default' => 'column_icon',
                          'desktop_hd' => 'column_icon_hd',
                          'mobile_default' => 'column_icon',
                          'mobile_hd' => 'column_icon_hd',
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
                $cta_data = get_sub_field('module_columns_fix_fix_column_cta_data');
                $cta_appearence = get_sub_field( 'module_columns_fix_fix_column_cta_appearence' );
                $cta_advanced_options = get_sub_field( 'module_columns_fix_fix_column_cta_altre_funzioni' );
                $cta_url_modal_id = get_sub_field( 'module_columns_fix_fix_column_cta_modal' );
                $cta_file = get_sub_field( 'module_columns_fix_fix_column_cta_file' );
                if ( $cta_data != '' ) {
                  print_theme_cta( $cta_data, $cta_appearence, $cta_advanced_options, $cta_url_modal_id, $cta_file );
                }
                ?>
              </div>
            </div>
          </div>
          <div class="nofix">
            <div class="flex-hold flex-hold-2 margins-thin">
              <?php
              if ( have_rows( 'module_columns_fix_repeater' ) ) : while ( have_rows( 'module_columns_fix_repeater' ) ) : the_row();
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
                            'size_fallback' => 'round_image',
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
                              'size_fallback' => 'round_image'
                          );
                          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                              'desktop_default' => 'round_image',
                              'desktop_hd' => 'round_image_hd',
                              'mobile_default' => 'round_image',
                              'mobile_hd' => 'round_image',
                              'lazy_placheholder' => 'micro_cut'
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
                              'size_fallback' => 'round_image'
                          );
                          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                            'desktop_default' => 'column_icon',
                            'desktop_hd' => 'column_icon_hd',
                            'mobile_default' => 'column_icon',
                            'mobile_hd' => 'column_icon_hd',
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
                  <?php include( locate_template( 'template-parts/modules/module-cta-default.php' ) ); ?>
                </div>
              </div>
            <?php endwhile; endif; ?>
            </div>
          </div>
        </div>
        <?php include( locate_template( 'template-parts/modules/module-cta-default.php' ) ); ?>
      </div>
    </div>
  </div>
</div>
<!-- module-module-columns-fix-column -->
