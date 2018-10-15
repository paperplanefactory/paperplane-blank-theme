<?php
// recupero l'ID e la tag del post originale per stabilire la correlazione ed escludere l'originale dalla lista
$this_id = get_the_ID();
$tags = wp_get_post_tags($post->ID);
$first_tag = $tags[0]->term_id;


// query per i post correlati auto
$args_post_related = array(
  'post_type' => 'post',
  'tag__in' => array ($first_tag),
  'post__not_in' => array ($this_id),
  'showposts' => 4
);
$my_posts_related = new WP_Query($args_post_related);
if( $my_posts_related->have_posts() ) :
?>
<h2 class="allupper">Contenuti correlati</h2>
<?php while ( $my_posts_related->have_posts() ) : $my_posts_related->the_post();
// fai qualcosa tipo stampare il titolo
endwhile; ?>
<?php endif; ?>
