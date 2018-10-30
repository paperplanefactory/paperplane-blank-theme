<?php
// lista di tutti termini per tassonomia / categoria / tag
// reference: https://developer.wordpress.org/reference/functions/get_terms/

$terms = get_terms( 'my_taxonomy' );
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
    echo '<ul>';
    foreach ( $terms as $term ) {
        echo '<li>' . $term->name . '</li>';
    }
    echo '</ul>';
}



// lista dei termini per tassonomia / categoria / tag per un post specifico
// reference: https://wordpress.stackexchange.com/questions/220511/correct-use-of-get-the-terms
// https://developer.wordpress.org/reference/functions/get_the_terms/
foreach (get_the_terms(the_ID(), 'taxonomy') as $cat)  {
  echo $cat->name;
}
