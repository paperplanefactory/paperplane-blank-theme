<?php
/**
*  Paperplane _blankTheme - template predefinito per pagine.
*/
get_header();
?>
<?php
while ( have_posts() ) : the_post();
include( locate_template( 'template-parts/modules/modules-handler.php' ) );
endwhile;
get_footer(); ?>
