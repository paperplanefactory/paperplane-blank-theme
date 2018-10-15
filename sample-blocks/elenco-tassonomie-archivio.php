<?php
// url per tornare alla pagina senza filtri (custom field option)
$no_filter_archive = get_field( 'archivio_applicazioni', 'option' );

// dati per scheda post singolo - determino il suo termine di tassonomia
// id della tassonomia dall'archivio
$current_arch_id = get_queried_object()->term_id;
// recupero la sua tassonomia
$terms_activity = get_the_terms( $post->ID , 'nome_tassonomia' );
// Loop over each item since it's an array
if ( $terms_activity != null ){
foreach( $terms_activity as $term_activity ) {
// Print the name method from $term which is an OBJECT
$current_arch_id = $term_activity->term_id;
{ ?>
  <script>
  $(document).ready(function() {
    $('.this-tax-<?php echo $current_arch_id; ?>').addClass('current_tax');
    });
  </script>
<?php }
unset($term_activity);
} }
//backup per pagina corrente se non ci sono filtri
if ( $current_arch_id == '' ) {
  $current_arch_id = 'alltax';
}
?>


<?php
// è la pagina senza filtro ovvero una finta pagina di archivio
if ( $current_arch_id === 'alltax' ) : ?>
<h1><?php the_title(); ?></h1>
<?php
// è il singolo post
elseif ( is_single() ) : ?>
<h1><?php the_title(); ?></h1>
<?php
//è la pagina di archivio con filtro
 else : ?>
<h1><?php echo single_term_title(); ?></h1>
<?php echo term_description(); ?>
<?php endif; ?>
<?php
// stampo la tassonomia come elenco di navigazione
$list_nome_tassonomia = get_terms( 'nome_tassonomia', array(
  'orderby'    => 'count',
  'hide_empty' => 0,
) );
if ( ! empty( $list_nome_tassonomia ) && ! is_wp_error( $list_nome_tassonomia ) ){
  echo '<ul class="archive-menu">';
  // voce per tornare alla pagina senza filtri
  echo '<li class="' .$current_arch_id . '"><a href="' . $no_filter_archive . '" alt="">' . pll__('tutte_output') . '</a></li>';
  foreach ( $list_cat_applicazione as $term ) {
    echo '<li class="this-tax-' . $term->term_id . '"><a href="' . esc_url( get_term_link( $term ) ) . '" alt="' . esc_attr( sprintf( __( 'View all post filed under %s', 'my_localization_domain' ), $term->name ) ) . '">' . $term->name . '</a></li>';
  }
  echo '</ul>';
}
?>
