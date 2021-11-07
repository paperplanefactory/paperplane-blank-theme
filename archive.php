<?php
get_header();
include( locate_template( 'template-parts/grid/page-opening.php' ) );
?>

<div class="wrapper">
  <div class="module-spacer-flex">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <?php
        if ( have_posts() ) : ?>
        <div class="flex-hold flex-hold-3 margins-wide grid-infinite">
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'template-parts/grid/post-infinite' ); ?>
        <?php endwhile; ?>
        </div>
        <?php endif; ?>
        <?php get_template_part( 'template-parts/grid/infinite-message' ); ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
