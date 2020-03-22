<!-- module-columns -->
<?php
$module_additional_elements_cta_target = get_sub_field( 'module_additional_elements_cta_target' );
switch ( $module_additional_elements_cta_target ) {
  case 'cta-target-internal' :
  $module_additional_elements_cta_url = get_sub_field( 'module_additional_elements_cta_target_internal' );
  $module_additional_elements_cta_url_target = '_self';
  break;
  case 'cta-target-external' :
  $module_additional_elements_cta_url = get_sub_field( 'module_additional_elements_cta_target_external' );
  $module_additional_elements_cta_url_target = '_blank';
  break;
  case 'cta-target-file' :
  $module_additional_elements_cta_url = get_sub_field( 'module_additional_elements_cta_target_file' );
  $module_additional_elements_cta_url_target = '_blank';
  break;
}
 ?>
<div class="wrapper module-columns <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <?php include( locate_template( 'template-parts/modules/module-intro.php' ) ); ?>
        <div class="flex-hold flex-hold-<?php the_sub_field( 'module_columns_columns_number' ); ?> margins-wide">
          <?php
          if ( have_rows( 'module_columns_columns_repeater' ) ) : while ( have_rows( 'module_columns_columns_repeater' ) ) : the_row();
          $module_columns_columns_repeater_background = get_sub_field( 'module_columns_columns_repeater_background' );
          switch ( $module_columns_columns_repeater_background ) {
            case 'no-bg' :
            $module_columns_columns_repeater_background_style = 'no-bg';
            $module_columns_columns_repeater_background_padding = '';
            break;
            case 'combo-1' :
            $module_columns_columns_repeater_background_style = 'combo-1';
            $module_columns_columns_repeater_background_padding = 'column-color';
            break;
            case 'combo-2' :
            $module_columns_columns_repeater_background_style = 'combo-2';
            $module_columns_columns_repeater_background_padding = 'column-color';
            break;
          }
          $module_columns_columns_repeater_box_shadow = get_sub_field( 'module_columns_columns_repeater_box_shadow' );
          switch ( $module_columns_columns_repeater_box_shadow ) {
            case 'default-box-shadow' :
            $module_columns_columns_repeater_background_padding = 'column-color';
            break;
          }
          $module_columns_columns_repeater_image = get_sub_field( 'module_columns_columns_repeater_image' );
          $module_columns_columns_repeater_image_format = get_sub_field( 'module_columns_columns_repeater_image_format' );
          $module_columns_columns_repeater_image_URL = $module_columns_columns_repeater_image['url'];
          $module_columns_columns_repeater_cta_target = get_sub_field( 'module_columns_columns_repeater_cta_target' );
          switch ( $module_columns_columns_repeater_cta_target ) {
            case 'cta-target-internal' :
            $module_columns_columns_repeater_cta_url = get_sub_field( 'module_columns_columns_repeater_cta_target_internal' );
            $module_columns_columns_repeater_cta_url_target = '_self';
            break;
            case 'cta-target-external' :
            $module_columns_columns_repeater_cta_url = get_sub_field( 'module_columns_columns_repeater_cta_target_external' );
            $module_columns_columns_repeater_cta_url_target = '_blank';
            break;
            case 'cta-target-file' :
            $module_columns_columns_repeater_cta_url = get_sub_field( 'module_columns_columns_repeater_cta_target_file' );
            $module_columns_columns_repeater_cta_url_target = '_blank';
            break;
          }
          ?>
          <div class="flex-hold-child <?php echo $module_columns_columns_repeater_background_style; ?> <?php the_sub_field( 'module_columns_columns_repeater_box_shadow' ); ?>" data-aos="<?php the_sub_field( 'module_columns_columns_repeater_animation' ); ?>">
            <div class="<?php echo $module_columns_columns_repeater_background_padding; ?>">
              <div class="<?php the_sub_field( 'module_columns_columns_repeater_align' ); ?>">
                <?php if ( $module_columns_columns_repeater_image != '' ) : ?>
                  <?php if ( $module_columns_columns_repeater_image_format === 'normal-image' ) : ?>
                    <?php
                    $image_data = array(
                        'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                        'image_value' => 'module_columns_columns_repeater_image', // se utilizzi un custom field indica qui il nome del campo
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
                  <?php elseif ( $module_columns_columns_repeater_image_format === 'round-image' ) : ?>
                    <div class="image-rounder">
                      <?php
                      $image_data = array(
                          'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                          'image_value' => 'module_columns_columns_repeater_image', // se utilizzi un custom field indica qui il nome del campo
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
                    <div class="image-icon lazy" data-bg="url(<?php echo $module_columns_columns_repeater_image_URL; ?>)"></div>
                  <?php endif; ?>
                <?php endif; ?>
                <?php if ( get_sub_field( 'module_columns_columns_repeater_counter_value' ) ) : ?>
                  <div class="column-counter-wrapper">
                    <?php if ( get_sub_field( 'module_columns_columns_repeater_counter_value_before' ) ) : ?>
                      <h3><?php the_sub_field( 'module_columns_columns_repeater_counter_value_before' ); ?></h3>
                    <?php endif; ?>
                    <h1 class="count just-number count-pre cta-2" data-bar-number="<?php the_sub_field( 'module_columns_columns_repeater_counter_value' ); ?>">0</h1>
                    <?php if ( get_sub_field( 'module_columns_columns_repeater_counter_value_after' ) ) : ?>
                      <h3><?php the_sub_field( 'module_columns_columns_repeater_counter_value_after' ); ?></h3>
                    <?php endif; ?>
                    <?php if ( get_sub_field( 'module_columns_columns_repeater_counter_description' ) ) : ?>
                      <div>
                        <h4><?php the_sub_field( 'module_columns_columns_repeater_counter_description' ); ?></h4>
                      </div>

                    <?php endif; ?>
                  </div>
                <?php endif; ?>
                <?php if ( get_sub_field( 'module_columns_columns_repeater_content' ) ) : ?>
                  <div class="content-styled last-child-no-margin">
                    <?php the_sub_field( 'module_columns_columns_repeater_content' ); ?>
                  </div>
                <?php endif; ?>
                <?php if ( get_sub_field( 'module_columns_columns_repeater_cta_text' ) ) : ?>
                  <div class="cta-holder">
                    <a href="<?php echo $module_columns_columns_repeater_cta_url; ?>" target="<?php echo $module_columns_columns_repeater_cta_url_target; ?>" class="<?php the_sub_field( 'module_columns_columns_repeater_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_columns_columns_repeater_cta_text' ); ?></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; endif; ?>
        </div>
        <?php if ( get_sub_field( 'module_additional_elements_cta_text' ) ) : ?>
          <div class="cta-holder <?php the_sub_field( 'module_additional_elements_cta_align' ); ?>">
            <a href="<?php echo $module_additional_elements_cta_url; ?>" target="<?php echo $module_additional_elements_cta_url_target; ?>" class="<?php the_sub_field( 'module_additional_elements_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_additional_elements_cta_text' ); ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- module-columns -->
