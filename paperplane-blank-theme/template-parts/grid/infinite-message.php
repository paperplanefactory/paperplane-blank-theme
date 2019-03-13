<div id="infscr-loading">
  <div class="infinite-scroll-request">
    <p>
      <?php pll_e('morecontents_output'); ?>
    </p>
  </div>
  <div class="infinite-scroll-last">
    <p>
      <?php pll_e('nomorecontents_output'); ?>
    </p>
  </div>
  <div class="infinite-scroll-error">
    <p>
      <?php pll_e('ops_output'); ?>
    </p>
  </div>
</div>
<!-- qui aggiungo la paginazione classica di WP che verrà poi nascosta -->
<div class="navigation">
<div class="alignleft"><?php previous_posts_link(); ?></div>
<div class="alignright nav-next"><?php next_posts_link(); ?></div>
</div>
