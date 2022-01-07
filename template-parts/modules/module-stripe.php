<!-- module-stripe -->
<?php
// allineamento verticale striscia
$module_stripe_vertical_aligment = get_sub_field( 'module_stripe_vertical_aligment' );
 ?>
<div class="wrapper module-stripe <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="<?php the_sub_field( 'module_stripe_width' ); ?>">
        <?php
        if ( have_rows( 'module_stripe_repeater' ) ) : while ( have_rows( 'module_stripe_repeater' ) ) : the_row();
        // recupero le informazioni per la CTA della striscia
        $cta_stripe_text_data = get_sub_field( 'module_stripe_repeater_cta_text' );
        if ( $cta_stripe_text_data != '' ) {
          global $cta_url_modal_array;
          $cta_stripe_type_data = get_sub_field( 'module_stripe_repeater_cta_target' );
          switch ( $cta_stripe_type_data ) {
            case 'cta-target-internal' :
            $cta_stripe_url_data = get_sub_field( 'module_stripe_repeater_cta_target_internal' );
            $cta_stripe_url_data = get_permalink( $cta_stripe_url_data[0] );
            $cta_stripe_url_target = '_self';
            $cta_url_modal_class = '';
            $cta_stripe_url_parameter_data = get_sub_field( 'module_stripe_repeater_cta_target_internal_parameter' );
            if ( $cta_stripe_url_parameter_data != '' ) {
              $cta_stripe_url_data = $cta_stripe_url_data . $cta_stripe_url_parameter_data;
            }
            break;
            case 'cta-target-external' :
            $cta_stripe_url_data = get_sub_field( 'module_stripe_repeater_cta_target_external' );
            $cta_stripe_url_target = '_blank';
            $cta_url_modal_class = '';
            break;
            case 'cta-target-file' :
            $cta_stripe_url_data = get_sub_field( 'module_stripe_repeater_cta_target_file' );
            $cta_stripe_url_target = '_blank';
            $cta_url_modal_class = '';
            break;
            case 'cta-target-modal' :
            $cta_url_data = '#';
            $cta_url_target = '_self';
            $cta_url_modal_class = 'modal-open-js';
            $cta_url_modal_id = get_sub_field( 'module_additional_elements_cta_modal' );
            $cta_url_modal_array[] = get_sub_field( 'module_additional_elements_cta_modal' );
            break;
          }
          $cta_stripe_appearence = get_sub_field( 'module_stripe_repeater_cta_appearence' );
        }
        ?>
        <!-- blocco -->
          <div class="flex-hold flex-hold-stripe-module stripe-listed <?php echo $module_stripe_vertical_aligment; ?> <?php the_sub_field( 'module_stripe_repeater_order' ); ?>">
            <!-- colonna -->
            <div class="module-stripe-image" data-aos="fade-up">
              <div class="spacer">
                <?php
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_stripe_repeater_image', // se utilizzi un custom field indica qui il nome del campo
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
              </div>

            </div>
            <!-- colonna -->
            <!-- colonna -->
            <div class="module-stripe-text" data-aos="fade-in" data-aos-delay="250">
              <div class="spacer">
                <div class="content-styled last-child-no-margin">
                  <?php the_sub_field( 'module_stripe_repeater_content' ); ?>
                </div>
                <?php get_template_part( 'template-parts/modules/module-cta-default' ); ?>
              </div>
            </div>
            <!-- colonna -->
          </div>
          <!-- blocco -->
        <?php endwhile; endif; ?>
      </div>
      <?php get_template_part( 'template-parts/modules/module-cta-default' ); ?>
    </div>
  </div>
</div>
<!-- module-stripe -->
