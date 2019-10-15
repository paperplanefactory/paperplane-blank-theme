<?php
/**
*  Paperplane _blankTheme
 * Template Name: Listing infinite scroll
*/
get_header();
?>
<?php paperplane_breadcrumbs(); ?>
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
<div class="flex-hold flex-hold-4 margins-thin grid-infinite modulo-space">
<?php while ( have_posts() ) : the_post(); ?>
  <?php get_template_part( 'template-parts/grid/post-infinite' ); ?>
<?php endwhile; ?>
</div>
<?php endif; ?>
<?php get_template_part( 'template-parts/grid/infinite-message' ); ?>
<?php get_footer(); ?>
