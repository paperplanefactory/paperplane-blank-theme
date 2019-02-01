<!-- modulo slide -->
<div class="wrapper bg-6 modulo-space">
  <div class="in-box-space">
    <div class="box-fullscreen-home">
      <div class="wrapper">
        <div class="wrapper-padded">
          <div class="wrapper-padded-more">
            <div class="modulo-slideshow-post modulo-slideshow<?php echo $module_count; ?>">
              <input type="hidden" class="slideshow_number" value=".postslider<?php echo $module_count; ?>" />
              <div class="postslider_dress">
                <ul class="postslider postslider<?php echo $module_count; ?>">
                  <?php if( have_rows('slides') ) : while ( have_rows('slides') ) : the_row();
                  $modulo_image = get_sub_field( 'scegli_immagine' );
                  if ( $isMobile == 1 ) {
                    $modulo_image_URL = $modulo_image['sizes']['hor_slide'];
                  }
                  if ( $isTablet == 1 ) {
                    $modulo_image_URL = $modulo_image['sizes']['hor_slide'];
                  }
                  if ( $isDesktop == 1 ) {
                    $modulo_image_URL = $modulo_image['sizes']['hor_slide'];
                  }

                  ?>
                  <li>
                    <div class="image-block">
                      <img src="<?php echo $modulo_image_URL; ?> " title="<?php echo $modulo_image['title']; ?>" alt="<?php echo $modulo_image['alt']; ?>" class="<?php the_sub_field( 'immagine_verticale_orizzontale_slide' ); ?>" />
                    </div>
                    <div class="text-block">
                      <?php echo $modulo_image['description']; ?>
                    </div>
                  </li>
                  <?php endwhile; endif; ?>

                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
