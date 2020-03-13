<!-- module-slideshow -->
<div class="wrapper module-slideshow">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="slide-double">
        <?php
        if ( have_rows( 'module_slideshow_repeater' ) ) : while ( have_rows( 'module_slideshow_repeater' ) ) : the_row();
        ?>
        <div class="single-slide">
          <div class="container">
            <?php
            $image_data = array(
                'image_type' => 'acf_sub_field', // options: post_thumbnail, acf_field, acf_sub_field
                'image_value' => 'module_slideshow_repeater_image', // se utilizzi un custom field indica qui il nome del campo
                'size_fallback' => 'slide'
            );
            $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
                'retina' => 'slide',
                'desktop' => 'slide',
                'mobile' => 'slide',
                'micro' => 'micro'
            );
            print_theme_image_lazyslick( $image_data, $image_sizes );
            ?>
            <?php if ( get_sub_field( 'module_slideshow_repeater_caption' ) ) : ?>
              <div class="slide-caption">
                <h6><?php the_sub_field( 'module_slideshow_repeater_caption' ); ?></h6>
              </div>
            <?php endif; ?>

          </div>
        </div>
        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>
</div>
<!-- module-slideshow -->
