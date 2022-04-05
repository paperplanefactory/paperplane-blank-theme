<!-- module-expanding-text -->
<div class="wrapper module-expanding-text <?php the_sub_field( 'module_bg' ); ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div class="<?php the_sub_field( 'module_vertical_top_space' ); ?> <?php the_sub_field( 'module_vertical_bottom_space' ); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-700">
          <?php if ( have_rows( 'module_expanding_text_repeater' ) ) : while ( have_rows( 'module_expanding_text_repeater' ) ) : the_row(); ?>
            <details>
              <summary><?php the_sub_field( 'module_expanding_text_title' ); ?></summary>
              <div class="content-styled last-child-no-margin">
                <?php the_sub_field( 'module_expanding_text_content' );?>
              </div>
            </details>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-expanding-text -->
