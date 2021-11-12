<div class="wrapper <?php the_field( 'theme_archive_page_color_scheme', 'option' ); ?>">
  <div class="wrapper-padded">
    <div class="wrapper-padded-container">
      <div class="page-opening-simple-spacer <?php the_field( 'page_opening_text_align_horizontal' ); ?>">
        <div class="last-child-no-margin">
          <h1><?php single_term_title(); ?></h1>
          <?php if ( term_description() ) : ?>
            <p><?php echo term_description(); ?></p>
          <?php endif; ?>
        </div>
        <div class="categories-holder">
          <?php
          $queried_object = get_queried_object();
          $page_taxonomy_slug = false;
          if($queried_object instanceof \WP_Term){
            $page_taxonomy_slug = $queried_object->taxonomy;
          }
          all_categories( $page_taxonomy_slug );
          ?>
        </div>
        <div class="clearer"></div>
      </div>
    </div>
  </div>
</div>
