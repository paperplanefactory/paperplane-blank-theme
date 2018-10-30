<?php
// query con paginazione
$page = get_query_var('paged');
$args_posts_paginati_infiniti = array(
  'post_type' => 'post',
  'posts_per_page' => 12,
  'paged' => $page
);
query_posts( $args_posts_paginati_infiniti );
if ( have_posts() ) :
while ( have_posts() ) : the_post();
// fai qualcosa tipo stampare il titolo
endwhile; endif;


// query con tassonomia
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
  endforeach; wp_reset_postdata(); endif;




// query per i post con tag correlati auto

// tag id array
$all_tags = array();
$tags_related = get_the_terms( $post->ID , 'post_tag' );
if ( $tags_related != null ){
  foreach( $tags_related as $tag_related ) {
    $all_tags[] = $tag_related->term_id;
  }
}
$all_tags_values = join( ", ", $all_tags );

$args_post_related = array(
  'post_type' => 'post',
  'tag' => $all_tags_values,
  'post__not_in' => array ($post->ID),
  'showposts' => 6
);
$my_post_related = get_posts( $args_post_related );
if ( !empty ( $my_post_related ) ) :
foreach ( $my_post_related as $post ) : setup_postdata ($post );
// fai qualcosa tipo stampare il titolo
endforeach; wp_reset_postdata();





// query per i post con categoria correlati auto

// categories id array
$all_categories = array();
$categories_related = get_the_terms( $post->ID , 'category' );
if ( $categories_related != null ){
  foreach( $categories_related as $category_related ) {
    $all_categories[] = $category_related->term_id;
  }
}
$all_categories_values = join( ", ", $all_categories );

$args_post_related = array(
  'post_type' => 'post',
  'cat' => $all_categories_values,
  'post__not_in' => array ($post->ID),
  'showposts' => 6
);
$my_post_related = get_posts( $args_post_related );
if ( !empty ( $my_post_related ) ) :
foreach ( $my_post_related as $post ) : setup_postdata ($post );
// fai qualcosa tipo stampare il titolo
endforeach; wp_reset_postdata();

 ?>
