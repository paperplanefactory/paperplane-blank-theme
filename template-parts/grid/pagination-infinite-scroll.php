<?php
$next_posts_link = get_next_posts_link();
global $options_fields, $options_fields_multilang;
?>
<?php if ($next_posts_link): ?>
  <div class="wrapper <?php echo $options_fields['theme_archive_page_color_scheme']; ?>">
    <div class="wrapper-padded">
      <div class="aligncenter infinite-button">
        <a href="#" class="default-button allupper view-more-button-js">Carica altri contenuti</a>
      </div>
    </div>
  </div>

  <div id="infscr-loading" class="last-child-no-margin">
    <div class="infinite-scroll-request">
      <div class="spinner">
        <div class="bounce1 bg-2"></div>
        <div class="bounce2 bg-2"></div>
        <div class="bounce3 bg-2"></div>
      </div>
      <p>
        loading more contents
        <?php //pll_e('morecontents_output'); ?>
      </p>
    </div>
    <div class="infinite-scroll-last">
      <p>
        no more contents
        <?php //pll_e('nomorecontents_output'); ?>
      </p>
    </div>
    <div class="infinite-scroll-error">
      <p>
        ops, an error has occurred
        <?php //pll_e('ops_output'); ?>
      </p>
    </div>
  </div>
  <!-- qui aggiungo la paginazione classica di WP che verrà poi nascosta -->
  <div class="navigation">
    <div class="alignleft">
      <?php previous_posts_link(); ?>
    </div>
    <div class="alignright nav-next">
      <?php next_posts_link(); ?>
    </div>
  </div>
<?php endif; ?>