<div class="wrapper page-opening">
    <div class="page-opening-fullscreen-less fullscreen-cta fullscreen-cta-center combo-1">
      <div class="fullscreen-cta-aligner">
        <div class="wrapper">
          <div class="wrapper-padded">
            <div class="wrapper-padded-container">
              <div class="fullscreen-cta-safe-padding aligncenter" data-aos="fade-right">
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
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
</div>
