<div class="wrapper page-opening">
  <?php if ( $thumb_id != '' ) : ?>
    <div class="<?php echo $page_opening_layout_size; ?> fullscreen-cta <?php the_field( 'page_opening_text_align' ); ?> lazy coverize <?php the_field( 'page_opening_color_scheme' ); ?>" data-bg="<?php echo $thumb_url_desktop[0]; ?>" data-bg-hidpi="<?php echo $thumb_url_desktop_hd[0]; ?>" data-aos="fade">
  <?php else : ?>
    <div class="<?php echo $page_opening_layout_size; ?> fullscreen-cta <?php the_field( 'page_opening_text_align' ); ?> <?php the_field( 'page_opening_color_scheme' ); ?>">
  <?php endif; ?>
    <?php if ( $page_opening_video === 'si' ) : ?>
      <div class="fullscreen-video">
        <video preload="metadata" class="lazy" data-autoplay autoplay loop muted playsinline>
         <source type="video/mp4" data-src="<?php the_field( 'page_opening_video_mp4' ); ?>">
       </video>
     </div>
     <?php endif; ?>
     <div class="above-image-opacity"></div>
      <div class="fullscreen-cta-aligner">
        <div class="wrapper">
          <div class="wrapper-padded">
            <div class="wrapper-padded-container">
              <div class="fullscreen-cta-safe-padding <?php the_field( 'page_opening_text_align_horizontal' ); ?>" data-aos="fade-in">
                <div class="last-child-no-margin">
                  <?php if ( $page_breadcrumbs === 'yes' && function_exists( 'bcn_display' ) ) : ?>
                    <div class="breadcrumbs-holder undelinked-links" typeof="BreadcrumbList" vocab="http://schema.org/">
                      <?php bcn_display(); ?>
                    </div>
                  <?php endif; ?>
                  <?php if ( get_field( 'page_opening_title' ) ) : ?>
                    <h1><?php the_field( 'page_opening_title' ); ?></h1>
                  <?php else : ?>
                    <h1><?php the_title(); ?></h1>
                  <?php endif; ?>
                  <?php if ( get_field( 'page_opening_subtitle' ) ) : ?>
                    <p><?php the_field( 'page_opening_subtitle' ); ?></p>
                  <?php endif; ?>
                </div>
                <?php if ( $page_taxonomy_show === 'yes' ) : ?>
                  <div class="categories-holder">
                    <?php
                    $page_taxonomy_slug = get_field( 'page_taxonomy_slug' );
                    all_categories( $page_taxonomy_slug );
                     ?>
                  </div>
                <?php endif; ?>

                <div class="clearer"></div>
                <?php paperplane_theme_cta('paperplane_theme_cta_page_opening'); ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if ( $page_opening_layout === 'opening-fullscreen' && $page_scroll_button == 1 ) : ?>
        <div class="scroll-down">
          <a href="#below-the-fold" title="scroll below the fold"></a>
        </div>
      <?php endif; ?>
  </div>
</div>
<div class="wrapper">
  <a name="below-the-fold" class="header-offset-anchor"></a>
</div>
