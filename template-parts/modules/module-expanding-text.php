<!-- module-expanding-text -->
<div class="wrapper module-expanding-text <?php the_sub_field( 'module_bg' ); ?>">
  <div class="module-spacer">
    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <div class="wrapper-padded-more-700">
          <div class="expander-top">
          <button class="expander exp-open" aria-expanded="false"><span class="exp-plus"></span><?php the_sub_field( 'module_expanding_text_title' ); ?></button>
        </div>

        <div class="expandable-content">
          <div class="content-styled last-child-no-margin">
            <?php the_sub_field( 'module_expanding_text_content' ); ?>
          </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- module-expanding-text -->
