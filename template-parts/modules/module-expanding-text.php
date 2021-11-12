<!-- module-expanding-text -->
<div class="wrapper module-expanding-text <?php the_sub_field( 'module_bg' ); ?>">
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-700">
          <?php if ( have_rows( 'module_expanding_text_repeater' ) ) : while ( have_rows( 'module_expanding_text_repeater' ) ) : the_row(); ?>
            <div class="expanding-block">
              <div class="expander-top">
                <button class="expander exp-open" aria-expanded="false"><span class="exp-plus"></span><?php the_sub_field( 'module_expanding_text_title' ); ?></button>
              </div>
              <div class="expandable-content">
                <div class="inner">
                  <div class="content-styled last-child-no-margin">
                    <?php the_sub_field( 'module_expanding_text_content' ); ?>
                  </div>
                </div>
              </div>
            </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-expanding-text -->
