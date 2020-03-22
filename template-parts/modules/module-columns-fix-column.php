<!-- module-module-columns-fix-column -->
<?php
$module_columns_fix_side = get_sub_field( 'module_columns_fix_side' );
$module_columns_fix_fix_column_background = get_sub_field( 'module_columns_fix_fix_column_background' );
switch ( $module_columns_fix_fix_column_background ) {
  case 'no-bg' :
  $module_columns_fix_fix_column_background_style = 'no-bg';
  $module_columns_fix_fix_column_background_padding = '';
  break;
  case 'combo-1' :
  $module_columns_fix_fix_column_background_style = 'combo-1';
  $module_columns_fix_fix_column_background_padding = 'column-color';
  break;
  case 'combo-2' :
  $module_columns_fix_fix_column_background_style = 'combo-2';
  $module_columns_fix_fix_column_background_padding = 'column-color';
  break;
}
$module_columns_fix_fix_column_box_shadow = get_sub_field( 'module_columns_fix_fix_column_box_shadow' );
switch ( $module_columns_fix_fix_column_box_shadow ) {
  case 'default-box-shadow' :
  $module_columns_fix_fix_column_background_padding = 'column-color';
  break;
}
$module_columns_fix_fix_column_image = get_sub_field( 'module_columns_fix_fix_column_image' );
$module_columns_fix_fix_column_image_format = get_sub_field( 'module_columns_fix_fix_column_image_format' );
$module_columns_fix_fix_column_image_URL = $module_columns_fix_fix_column_image['url'];
$module_columns_fix_fix_column_cta_target = get_sub_field( 'module_columns_fix_fix_column_cta_target' );
switch ( $module_columns_fix_fix_column_cta_target ) {
  case 'cta-target-internal' :
  $module_columns_fix_fix_column_cta_url = get_sub_field( 'module_columns_fix_fix_column_cta_target_internal' );
  $module_columns_fix_fix_column_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $module_columns_fix_fix_column_cta_url = get_sub_field( 'module_columns_fix_fix_column_cta_target_external' );
  $module_columns_fix_fix_column_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $module_columns_fix_fix_column_cta_url = get_sub_field( 'module_columns_fix_fix_column_cta_target_file' );
  $module_columns_fix_fix_column_cta_url_target = '_blank';
  break;
}
$module_columns_fix_content_type = get_sub_field( 'module_columns_fix_content_type' );
switch ( $module_columns_fix_content_type ) {
  case 'normal-col' :
  $element_separator = 'margins-wide';
  break;
  case 'download-col' :
  $element_separator = 'margins-thin';
  break;
}
 ?>
<div class="wrapper module-columns-fix-column <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer-flex">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <div class="flex-hold flex-fix-column <?php the_sub_field( 'module_columns_fix_side' ); ?>">
          <div class="fix">
            <div class="sticky-element <?php echo $module_columns_fix_fix_column_background_style; ?> <?php the_sub_field( 'module_columns_fix_fix_column_box_shadow' ); ?>" data-aos="<?php the_sub_field( 'module_columns_fix_animation' ); ?>">
              <div class="<?php echo $module_columns_fix_fix_column_background_padding; ?>">
                <div class="<?php the_sub_field( 'module_columns_fix_fix_column_align' ); ?>">
                  <?php if ( $module_columns_fix_fix_column_image != '' ) : ?>
                    <?php if ( $module_columns_fix_fix_column_image_format === 'normal-image' ) : ?>
                      <?php
                      $image_data = array(
                          'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                          'image_value' => 'module_columns_fix_fix_column_image', // se utilizzi un custom field indica qui il nome del campo
                          'size_fallback' => 'column'
                      );
                      $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                          'retina' => 'column',
                          'desktop' => 'column',
                          'mobile' => 'column',
                          'micro' => 'micro'
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
                            'retina' => 'round_image',
                            'desktop' => 'round_image',
                            'mobile' => 'round_image',
                            'micro' => 'micro'
                        );
                        print_theme_image( $image_data, $image_sizes );
                        ?>
                      </div>
                    <?php else : ?>
                      <div class="image-icon lazy" data-bg="url(<?php echo $module_columns_fix_fix_column_image_URL; ?>)"></div>
                    <?php endif; ?>
                  <?php endif; ?>
                  <?php if ( get_sub_field( 'module_columns_fix_fix_column_content' ) ) : ?>
                    <div class="content-styled last-child-no-margin">
                      <?php the_sub_field( 'module_columns_fix_fix_column_content' ); ?>
                    </div>
                  <?php endif; ?>
                  <?php if ( get_sub_field( 'module_columns_fix_fix_column_cta_text' ) ) : ?>
                    <div class="cta-holder">
                      <a href="<?php echo $module_columns_fix_fix_column_cta_url; ?>" target="<?php echo $module_columns_fix_fix_column_cta_url_target; ?>" class="<?php the_sub_field( 'module_columns_fix_fix_column_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_columns_fix_fix_column_cta_text' ); ?></a>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
          <div class="nofix">
            <div class="flex-hold flex-hold-2 <?php echo $element_separator; ?>">
              <?php if ( $module_columns_fix_content_type === 'normal-col' ) : ?>
                <?php
                if ( have_rows( 'module_columns_fix_repeater' ) ) : while ( have_rows( 'module_columns_fix_repeater' ) ) : the_row();
                $module_columns_fix_repeater_background = get_sub_field( 'module_columns_fix_repeater_background' );
                switch ( $module_columns_fix_repeater_background ) {
                  case 'no-bg' :
                  $module_columns_fix_repeater_background_style = 'no-bg';
                  $module_columns_fix_repeater_background_padding = '';
                  break;
                  case 'combo-1' :
                  $module_columns_fix_repeater_background_style = 'combo-1';
                  $module_columns_fix_repeater_background_padding = 'column-color';
                  break;
                  case 'combo-2' :
                  $module_columns_fix_repeater_background_style = 'combo-2';
                  $module_columns_fix_repeater_background_padding = 'column-color';
                  break;
                }
                $module_columns_fix_repeater_box_shadow = get_sub_field( 'module_columns_fix_repeater_box_shadow' );
                switch ( $module_columns_fix_repeater_box_shadow ) {
                  case 'default-box-shadow' :
                  $module_columns_fix_repeater_background_padding = 'column-color';
                  break;
                }
                $module_columns_fix_repeater_image = get_sub_field( 'module_columns_fix_repeater_image' );
                $module_columns_fix_repeater_image_format = get_sub_field( 'module_columns_fix_repeater_image_format' );
                $module_columns_fix_repeater_image_URL = $module_columns_fix_repeater_image['url'];
                $module_columns_fix_repeater_cta_target = get_sub_field( 'module_columns_fix_repeater_cta_target' );
                switch ( $module_columns_fix_repeater_cta_target ) {
                  case 'cta-target-internal' :
                  $module_columns_fix_repeater_cta_url = get_sub_field( 'module_columns_fix_repeater_cta_target_internal' );
                  $module_columns_fix_repeater_cta_url_target = '_self';
                  break;
                  case 'cta-target-external' :
                  $module_columns_fix_repeater_cta_url = get_sub_field( 'module_columns_fix_repeater_cta_target_external' );
                  $module_columns_fix_repeater_cta_url_target = '_blank';
                  break;
                  case 'cta-target-file' :
                  $module_columns_fix_repeater_cta_url = get_sub_field( 'module_columns_fix_repeater_cta_target_file' );
                  $module_columns_fix_repeater_cta_url_target = '_blank';
                  break;
                }
                ?>
                <div class="flex-hold-child <?php echo $module_columns_fix_repeater_background_style; ?> <?php the_sub_field( 'module_columns_fix_repeater_box_shadow' ); ?>">
                  <div class="<?php echo $module_columns_fix_repeater_background_padding; ?>">
                    <div class="<?php the_sub_field( 'module_columns_fix_repeater_align' ); ?> --">
                      <?php if ( $module_columns_fix_repeater_image != '' ) : ?>
                        <?php if ( $module_columns_fix_repeater_image_format === 'normal-image' ) : ?>
                          <?php
                          $image_data = array(
                              'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                              'image_value' => 'module_columns_fix_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                              'size_fallback' => 'column'
                          );
                          $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                              'retina' => 'column',
                              'desktop' => 'column',
                              'mobile' => 'column',
                              'micro' => 'micro'
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
                                'retina' => 'round_image',
                                'desktop' => 'round_image',
                                'mobile' => 'round_image',
                                'micro' => 'micro'
                            );
                            print_theme_image( $image_data, $image_sizes );
                            ?>
                          </div>
                        <?php else : ?>
                          <div class="image-icon lazy" data-bg="url(<?php echo $module_columns_fix_repeater_image_URL; ?>)"></div>
                        <?php endif; ?>
                      <?php endif; ?>
                      <?php if ( get_sub_field( 'module_columns_fix_repeater_content' ) ) : ?>
                        <div class="content-styled last-child-no-margin">
                          <?php the_sub_field( 'module_columns_fix_repeater_content' ); ?>
                        </div>
                      <?php endif; ?>
                      <?php if ( get_sub_field( 'module_columns_fix_repeater_cta_text' ) ) : ?>
                        <div class="cta-holder">
                          <a href="<?php echo $module_columns_fix_repeater_cta_url; ?>" target="<?php echo $module_columns_fix_repeater_cta_url_target; ?>" class="<?php the_sub_field( 'module_columns_fix_repeater_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_columns_fix_repeater_cta_text' ); ?></a>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              <?php endwhile; endif; ?>
              <?php else : ?>
                <?php
                if ( have_rows( 'module_columns_fix_repeater_downloads' ) ) : while ( have_rows( 'module_columns_fix_repeater_downloads' ) ) : the_row();
                $module_columns_fix_repeater_downloads_link_type = get_sub_field( 'module_columns_fix_repeater_downloads_link_type' );
                switch ( $module_columns_fix_repeater_downloads_link_type ) {
                  case 'link-download' :
                  $module_columns_fix_repeater_downloads_link_url = get_sub_field( 'module_columns_fix_repeater_downloads_file' );
                  $$module_columns_fix_repeater_downloads_link_icon = 'fas fa-file-download';
                  break;
                  case 'link-url' :
                  $module_columns_fix_repeater_downloads_link_url = get_sub_field( 'module_columns_fix_repeater_downloads_url' );
                  $$module_columns_fix_repeater_downloads_link_icon = 'fas fa-link';
                  break;
                }
                ?>
                <div class="flex-hold-child">
                  <div class="download-block">
                    <h5 class="download-icon">
                      <a href="<?php echo $module_columns_fix_repeater_downloads_link_url; ?>" target="_blank">
                        <i class="<?php echo $$module_columns_fix_repeater_downloads_link_icon; ?>"></i>
                        <?php the_sub_field( 'module_columns_fix_repeater_downloads_title' ); ?>
                      </a>
                    </h5>
                  </div>
                </div>
                <?php endwhile; endif; ?>
              <?php endif; ?>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-module-columns-fix-column -->
