<!-- module-slideshow -->
<div class="wrapper module-slideshow <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_space' ); ?>">
    <div class="wrapper-padded">
      <div class="<?php the_sub_field( 'module_slideshow_width' ); ?>">
        <div class="<?php the_sub_field( 'module_slideshow_type' ); ?> <?php the_sub_field( 'module_slideshow_type' ); ?>-js">
          <?php
          if ( have_rows( 'module_slideshow_repeater' ) ) : while ( have_rows( 'module_slideshow_repeater' ) ) : the_row();
          ?>
          <div class="slide-inner">
            <div class="container">
              <?php
              $image_data = array(
                  'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                  'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                  'size_fallback' => 'slide'
              );
              $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                  'desktop_default' => 'slide',
                  'desktop_hd' => 'slide_hd',
                  'mobile_default' => 'slide',
                  'mobile_hd' => 'slide_hd',
                  'lazy_placheholder' => 'micro'
              );
              print_theme_image_lazyslick( $image_data, $image_sizes );
              ?>
              <div class="slide-caption">
                <?php if ( get_sub_field( 'module_slideshow_repeater_caption' ) ) : ?>
                  <h6><?php the_sub_field( 'module_slideshow_repeater_caption' ); ?></h6>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-slideshow -->
