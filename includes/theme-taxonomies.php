<?php
function all_categories( $page_taxonomy_slug ) {
  $taxonomies = get_terms( array(
    'taxonomy' => $page_taxonomy_slug,
    'hide_empty' => true
  )
);
if ( !empty( $taxonomies ) ) {
  $output = '';
  foreach( $taxonomies as $category ) {
    $output .= '<a href="' . esc_url( get_term_link( $category ) ) . '" class="default-button allupper">'.$category->name.'</a>';
  }
  echo $output;
}
}


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




function product_categories_navigation() {
  // definisco lo slug della tassonomia
  $taxonomy_slug = 'category';
  // richiamo tutti i termini genitore
  $taxonomies = get_terms( array(
    'taxonomy' => $taxonomy_slug,
    // quando hai finito metti true in modo da non mostrare le categorie senza contenuti associati
    'hide_empty' => false,
    'parent' => 0
  )
);
// verifico se esistono termini
if ( !empty( $taxonomies ) ) {
  $output = '';
  // richiamo i termini
  foreach( $taxonomies as $category ) {
    // verifico se il termini ha figli
    $child_categories = get_term_children( $category->term_id, $taxonomy_slug );
    // se ha figli genero il box ad espansione
    if ( !empty( $child_categories ) ) {
      $output .= '<div class="expanding-block">';
      $output .= '<div class="expander-top">';
      $output .= '<button class="expander exp-open" aria-expanded="false"><span class="exp-plus"></span>'.$category->name.'</button>';
      $output .= '</div>';
      $output .= '<div class="expandable-content">';
      $output .= '<div class="inner">';
      $output .= '<div class="content-styled last-child-no-margin">';
      // stampo il link a tutti i contenuti del termine genitore
      $output .= '<a href="' . esc_url( get_term_link( $category ) ) . '" class="">'.$category->name.' - tutti</a><br />';
      // stampo i link a tutti i contenuti dei termini figli
      foreach ( $child_categories as $child ) {
        $term = get_term_by( 'id', $child, $taxonomy_slug );
        $output .= '<a href="' . get_term_link( $child, $taxonomy_name ) . '">' . $term->name . '</a><br />';
      }
      $output .= '</div>';
      $output .= '</div>';
      $output .= '</div>';
      $output .= '</div>';
    }
    // se non ha figli stampo solo il link a tutti i contenuti del termine genitore
    else {
      $output .= '<a href="' . esc_url( get_term_link( $category ) ) . '" class="">'.$category->name.'</a><br />';
    }
  }
  echo $output;
}
}
