<?php
/**
*  Paperplane _blankTheme
 * Template Name: Listing blocks infinite scroll
*/
get_header();
include( locate_template( 'template-parts/grid/page-opening.php' ) );
?>

<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <div class="wrapper-padded-more-924">
          <?php
          // alla classe del contenitore devo aggiungere il selettore ".grid-infinite"
          $page = get_query_var('paged');
          $args_posts_paginati_infiniti = array(
            'post_type' => 'post',
            'posts_per_page' => 12,
            'paged' => $page
          );
          query_posts( $args_posts_paginati_infiniti );
          if ( have_posts() ) : ?>
          <div class="flex-hold flex-hold-3 margins-wide grid-infinite">
          <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/grid/block-infinite' ); ?>
          <?php endwhile; ?>
          </div>
          <?php endif; ?>
          <?php get_template_part( 'template-parts/grid/infinite-message' ); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
