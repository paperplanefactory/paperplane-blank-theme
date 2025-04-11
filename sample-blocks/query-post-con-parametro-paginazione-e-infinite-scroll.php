<?php
// alla classe del contenitore devo aggiungere il selettore ".grid-infinite"
$page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args_posts_paginati_infiniti = array(
  'post_type' => 'post',
  'posts_per_page' => 12,
  'paged' => $page
);
query_posts( $args_posts_paginati_infiniti );
if ( have_posts() ) : ?>
<div class="grid-infinite">
<?php while ( have_posts() ) : the_post();
// fai qualcosa tipo stampare il titolo - alla classe del box devo aggiungere il selettore ".grid-item-infinite"
endwhile; ?>
</div>
<?php endif; ?>
<?php include( locate_template( 'template-parts/grid/infinite-message.php' ) ); ?>
