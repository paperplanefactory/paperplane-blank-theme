<div class="wrapper <?php the_field( 'page_opening_color_scheme' ); ?>">
  <div class="wrapper-padded">
    <div class="wrapper-padded-container">
      <div class="page-opening-simple-spacer <?php the_field( 'page_opening_text_align_horizontal' ); ?>">
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
        <?php get_template_part( 'template-parts/grid/page-opening/opening-cta-default' ); ?>
      </div>
    </div>
  </div>
</div>
