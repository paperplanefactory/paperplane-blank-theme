<?php
// genero un elenco di link che rimandano alla pagina di archivio della tassonomia
function call_all_cat_nome_tassonomia() {
  $terms_activity = get_the_terms( $post->ID , 'nome_tassonomia' );
  // Loop over each item since it's an array
  if ( $terms_activity != null ){
  foreach( $terms_activity as $term_activity ) {
  // Print the name method from $term which is an OBJECT
  $term_link = get_term_link( $term_activity );
  $activity_name = $term_activity->name;
  echo '<a href="' . $term_link . '">' . $activity_name . '</a>';
  unset($term_activity);
  } }
}

// la richiamo in pagina con "if (function_exists('call_all_cat_nome_tassonomia')) { call_all_cat_nome_tassonomia(); }

function paperplane_breadcrumbs() {
  global $post;
  $this_cpt = get_post_type( $post->ID );
  $this_cpt_name = $this_cpt->labels->singular_name;

  if ( $this_cpt === 'post' ) {
    $this_cpt_name = 'blog';
    $telling_permalink = 'https://www.sito.com/url-pagina-blog';
  }

  if ( $this_cpt === 'cpt_slug' ) {
    // se necessario imposto una URL di riferimento per l'archivio
    //$telling_permalink = get_field( 'events_archive_page', 'any-lang' );
  }
  if ( is_singular() || is_tax() || is_category() || is_tag() ) {
    $first_slash = " / ";
  }
  else {
    $first_slash = "";
  }

  $breadbrumbs_output = '';
  $breadbrumbs_output .= 'You are here: ';
  $breadbrumbs_output .= '<ol class="breadcrumbs" itemscope itemtype="https://schema.org/BreadcrumbList">';
  if ( isset( $this_cpt_name ) ) {
    $depth_counter = 1;
    $breadbrumbs_output .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . $telling_permalink . '"><span itemprop="name">' . $this_cpt_name . '</span></a><meta itemprop="position" content="'.$depth_counter.'" /> / </li>';
  }

  if( $post->post_parent ) {
    $anc = get_post_ancestors( $post->ID );
    $anc = array_reverse( $anc );
    if ( !isset( $parents ) ) $parents = null;
    $depth_counter = 1;
    foreach ( $anc as $ancestor ) {
      $depth_counter++;
      $breadbrumbs_output .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><a itemprop="item" href="' . get_permalink( $ancestor ) . '"><span itemprop="name">' . get_the_title( $ancestor ) . '</span></a><meta itemprop="position" content="'.$depth_counter.'" /> / </li>';
    }
  }
  if ( isset( $depth_counter ) ) {
    $depth_counter++;
  }
  else {
    $depth_counter = 1;
  }
  if ( is_singular() ) {
    $this_title = get_the_title( $post->ID );
    // se necessario accorcio il titolo
    //$this_title = mb_strimwidth( $this_title, 0, 30, '...' );
    $this_permalink = get_permalink( $post->ID );
    $breadbrumbs_output .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this_title . '</span><meta itemprop="position" content="'.$depth_counter.'" /></li>';
  }
  if ( is_tax() || is_category() || is_tag() ) {
    $queried_object = get_queried_object();
    $this_title = $queried_object->name;
    $breadbrumbs_output .= '<li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem"><span itemprop="name">' . $this_title . '</span><meta itemprop="position" content="'.$depth_counter.'" /></li>';
  }
  $breadbrumbs_output .= '</ol>';
  echo $breadbrumbs_output;
}
