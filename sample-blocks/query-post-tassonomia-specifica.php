<?php
$args_filter_posts = array(
  'post_type' => 'post',
  'tax_query' => array(
    array(
      'taxonomy' => 'nome_della_tassonomia',
      'field' => 'slug',
      'terms' => 'slug_del_termine'
    )
  ),
  'posts_per_page' => 3
);
$my_filter_posts = get_posts( $args_filter_posts );
?>
<?php if ( !empty ( $my_filter_posts ) ) : ?>
  <h2 class="allupper">Abbiamo dei contenuti!!</h2>
  <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post );
  // fai qualcosa tipo stampare il titolo
  endforeach; wp_reset_postdata();
endif;
?>
