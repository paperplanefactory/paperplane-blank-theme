<!-- module-stripe -->
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
<div class="wrapper module-stripe <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <?php include( locate_template( 'template-parts/modules/module-intro.php' ) ); ?>
        <?php
        if ( have_rows( 'module_stripe_repeater' ) ) : while ( have_rows( 'module_stripe_repeater' ) ) : the_row();
        $module_stripe_repeater_cta_target = get_sub_field( 'module_stripe_repeater_cta_target' );
        switch ( $module_stripe_repeater_cta_target ) {
          case 'cta-target-internal' :
          $module_stripe_repeater_cta_url = get_sub_field( 'module_stripe_repeater_cta_target_internal' );
          $module_stripe_repeater_cta_url_target = '_self';
          break;
          case 'cta-target-external' :
          $module_stripe_repeater_cta_url = get_sub_field( 'module_stripe_repeater_cta_target_external' );
          $module_stripe_repeater_cta_url_target = '_blank';
          break;
          case 'cta-target-file' :
          $module_stripe_repeater_cta_url = get_sub_field( 'module_stripe_repeater_cta_target_file' );
          $module_stripe_repeater_cta_url_target = '_blank';
          break;
        }
        ?>
        <!-- blocco -->
          <div class="flex-hold flex-hold-2 margins-fit verticalize stripe-listed <?php the_sub_field( 'module_stripe_repeater_order' ); ?>">
            <!-- colonna -->
            <div class="flex-hold-child module-stripe_image" data-aos="fade-left">
              <div class="spacer">
                <?php
                $image_data = array(
                    'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                    'image_value' => 'module_stripe_repeater_image', // se utilizzi un custom field indica qui il nome del campo
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
              </div>

            </div>
            <!-- colonna -->
            <!-- colonna -->
            <div class="flex-hold-child module-stripe_txt" data-aos="fade-right">
              <div class="spacer">
                <div class="content-styled last-child-no-margin">
                  <?php the_sub_field( 'module_stripe_repeater_content' ); ?>
                </div>
                <?php if ( get_sub_field( 'module_stripe_repeater_cta_text' ) ) : ?>
                  <div class="cta-holder">
                    <a href="<?php echo $module_stripe_repeater_cta_url; ?>" target="<?php echo $module_stripe_repeater_cta_url_target; ?>" class="<?php the_sub_field( 'module_stripe_repeater_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_stripe_repeater_cta_text' ); ?></a>
                  </div>
                <?php endif; ?>
              </div>
            </div>
            <!-- colonna -->
          </div>
          <!-- blocco -->
        <?php endwhile; endif; ?>
        <?php if ( get_sub_field( 'module_additional_elements_cta_text' ) ) : ?>
          <div class="cta-holder <?php the_sub_field( 'module_additional_elements_cta_align' ); ?>">
            <a href="<?php echo $module_additional_elements_cta_url; ?>" target="<?php echo $module_additional_elements_cta_url_target; ?>" class="<?php the_sub_field( 'module_additional_elements_cta_appearence' ); ?> allupper"><?php the_sub_field( 'module_additional_elements_cta_text' ); ?></a>
          </div>
        <?php endif; ?>


      </div>
    </div>
  </div>
</div>
<!-- module-stripe -->
