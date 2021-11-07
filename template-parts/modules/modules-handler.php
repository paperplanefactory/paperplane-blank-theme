<div class="modules-handler">
  <?php
  global $module_count;
  global $last_rep_color;
  $module_count = 0;
  if ( have_rows( 'new_module' ) ) : while ( have_rows( 'new_module' ) ) : the_row();
  $module_count++;
  $choose_module = get_sub_field( 'choose_module');
  $show_hide_module = get_sub_field( 'show_hide_module');
  if ( $show_hide_module == 1 ) {
    if ( is_user_logged_in() ) {
      //echo '<div class="wrapper admin-hideable"><div class="admin-index">Modulo: '.$module_count.' - Tipo di modulo: '.$choose_module.' - URL: '.get_permalink().'#section-'.$module_count.'</div></div>';
    }
    echo '<a name="section-'.$module_count.'" class="header-offset-anchor"></a>';
    switch ( $choose_module ) {
      // module-text
      case 'module-text' :
      include( locate_template( 'template-parts/modules/module-text.php' ) );
      break;
      // module-highlighted-sentence
      case 'module-highlighted-sentence' :
      include( locate_template( 'template-parts/modules/module-highlighted-sentence.php' ) );
      break;
      // module-columns
      case 'module-columns' :
      include( locate_template( 'template-parts/modules/module-columns.php' ) );
      break;
      // module-module-columns-fix-column
      case 'module-columns-fix-column' :
      include( locate_template( 'template-parts/modules/module-columns-fix-column.php' ) );
      break;
      // module-stripe
      case 'module-stripe' :
      include( locate_template( 'template-parts/modules/module-stripe.php' ) );
      break;
      // module-slideshow
      case 'module-slideshow' :
      include( locate_template( 'template-parts/modules/module-slideshow.php' ) );
      break;
      // module-fullscreen-image
      case 'module-fullscreen-image' :
      include( locate_template( 'template-parts/modules/module-fullscreen-image.php' ) );
      break;
      // module-expanding-text
      case 'module-expanding-text' :
      include( locate_template( 'template-parts/modules/module-expanding-text.php' ) );
      break;
      // module-banner
      case 'module-banner' :
      include( locate_template( 'template-parts/modules/module-banner.php' ) );
      break;
    }
  }

  endwhile; endif;
   ?>
</div>
