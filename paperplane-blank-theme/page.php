<?php
/**
*  Paperplane _blankTheme - template predefinito per pagine.
*/
get_header();
?>





<div class="wrapper-padded-more">
  <?php
  // alla classe del contenitore devo aggiungere il selettore ".grid-infinite"
  $page = get_query_var('paged');
  $args_posts_paginati_infiniti = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'paged' => $page
  );
  query_posts( $args_posts_paginati_infiniti );
  if ( have_posts() ) : ?>
  <script>
  $(document).ready(function() {
    $('.grid-infinite').infiniteScroll({
    // options
    path: '.nav-next a',
    append: '.grid-item-infinite',
    status: '#infscr-loading',
    history: false,
  });

  $('.grid-infinite').on( 'append.infiniteScroll', function( event, response, path, items ) {
    (function() {
      new LazyLoad({
        elements_selector: ".lazy",
        class_loading: "lazy-loading",
        class_loaded: "lazy-loaded"
      });
    }());
  });
  });
  </script>
  <div class="flex-hold grid-infinite flex-hold-2 bg-3">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php get_template_part( 'template-parts/grid/post-infinite' ); ?>
  <?php endwhile; ?>

  <?php endif; ?>
  </div>
  <div id="infscr-loading">
    <div class="infinite-scroll-request">Loading...</div>
    <div class="infinite-scroll-last">End of content</div>
    <div class="infinite-scroll-error">No more pages to load</div>
  </div>


  <!-- qui aggiungo la paginazione classica di WP che verrà poi nascosta -->
  <div class="navigation">
  <div class="alignleft"><?php previous_posts_link( '&laquo; Previous Entries' ); ?></div>
  <div class="alignright nav-next"><?php next_posts_link( 'Next Entries &raquo;', '' ); ?></div>
  </div>
</div>

<?php get_footer(); ?>
