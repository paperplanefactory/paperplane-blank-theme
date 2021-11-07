<?php
function theme_pagination_system() {
  $theme_pagination = get_field( 'theme_pagination', 'option' );
  if ( $theme_pagination === 'theme-pagenavi' ) {
    include( locate_template( 'template-parts/grid/pagination-page-navi.php' ) );
  }
  elseif ( $theme_pagination === 'theme-infinite-scroll' )  {
    include( locate_template( 'template-parts/grid/pagination-infinite-scroll.php' ) );
  }
}
