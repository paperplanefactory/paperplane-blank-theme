<div class="wrapper page-opening">
  <div
    class="fullscreen-cta coverize fluid-typo <?php echo $page_opening_layout_size . ' ' . $content_fields['page_opening_text_align'] . ' ' . $content_fields['page_opening_color_scheme']; ?>"
    data-aos="fade-in">
    <?php if ($page_opening_video === 'si'): ?>
      <video preload="metadata" data-autoplay autoplay loop muted playsinline>
        <source type="video/mp4" src="<?php echo $content_fields['page_opening_video_mp4']; ?>">
      </video>
    <?php else: ?>
      <?php if (isset($thumb_url_desktop)): ?>
        <div class="desktop-only">
          <img src="<?php echo $thumb_url_desktop; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"
            type="image/<?php echo $filetype_desktop['ext']; ?>" decoding="async" />
        </div>
      <?php endif; ?>
      <?php if (isset($thumb_url_mobile)): ?>
        <div class="mobile-only">
          <img src="<?php echo $thumb_url_mobile; ?>" title="<?php the_title(); ?>" alt="<?php the_title(); ?>"
            type="image/<?php echo $filetype_mobile['ext']; ?>" decoding="async" />
        </div>
      <?php endif; ?>
    <?php endif; ?>


    <div class="above-image-opacity"></div>
    <div class="fullscreen-cta-aligner">
      <div class="wrapper">
        <div class="wrapper-padded">
          <div class="fullscreen-cta-safe-padding <?php echo $content_fields['page_opening_text_align_horizontal']; ?>"
            data-aos="fade-up">
            <div class="last-child-no-margin">
              <?php if ($page_breadcrumbs === 'yes' && function_exists('bcn_display')): ?>
                <div class="breadcrumbs-holder undelinked-links" typeof="BreadcrumbList" vocab="http://schema.org/">
                  <?php bcn_display(); ?>
                </div>
              <?php endif; ?>
              <?php if ($content_fields['page_opening_title']): ?>
                <h1>
                  <?php echo $content_fields['page_opening_title']; ?>
                </h1>
              <?php else: ?>
                <h1>
                  <?php the_title(); ?>
                </h1>
              <?php endif; ?>
              <?php if ($content_fields['page_opening_subtitle']): ?>
                <p>
                  <?php echo $content_fields['page_opening_subtitle']; ?>
                </p>
              <?php endif; ?>
            </div>
            <?php if ($page_taxonomy_show === 'yes'): ?>
              <div class="categories-holder">
                <?php
                $page_taxonomy_slug = $content_fields['page_taxonomy_slug'];
                all_categories($page_taxonomy_slug);
                ?>
              </div>
            <?php endif; ?>

            <div class="clearer"></div>
            <?php paperplane_theme_cta_advanced($content_fields['paperplane_theme_cta_page_opening']); ?>
          </div>
        </div>
      </div>
    </div>
    <?php if ($page_opening_layout === 'opening-fullscreen' && $page_scroll_button == 1): ?>
      <div class="scroll-down">
        <a href="#below-the-fold" title="scroll below the fold"></a>
      </div>
    <?php endif; ?>
  </div>
</div>
<div class="wrapper">
  <a name="below-the-fold" class="header-offset-anchor"></a>
</div>