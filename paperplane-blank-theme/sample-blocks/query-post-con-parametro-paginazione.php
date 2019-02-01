<?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args_posts_paginati = array(
  'post_type' => 'post',
  'posts_per_page' => 12,
  'paged' => $page
);
query_posts( $args_posts_paginati );
if (have_posts()) : while (have_posts()) : the_post();
// fai qualcosa tipo stampare il titolo
endwhile; endif; wp_reset_postdata(); ?>
<?php
// se mi serve stampo la paginazione con pagenavi
// wp_pagenavi();
?>
