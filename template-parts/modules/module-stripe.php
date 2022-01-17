<!-- module-stripe -->
<?php
// allineamento verticale striscia
$module_stripe_vertical_aligment = get_sub_field( 'module_stripe_vertical_aligment' );
 ?>
<div class="wrapper module-stripe <?php the_sub_field( 'module_bg' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="<?php the_sub_field( 'module_stripe_width' ); ?>">
        <?php
        if ( have_rows( 'module_stripe_repeater' ) ) : while ( have_rows( 'module_stripe_repeater' ) ) : the_row();
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
