<?php
/**
 *  Paperplane _blankTheme
 * Template Name: Moduli
 */
get_header();
?>
<?php
while (have_posts()):
    the_post();
    $content_fields = paperplane_content_transients($post->ID);
    include(locate_template('template-parts/grid/page-opening.php'));
    include(locate_template('template-parts/modules/modules-handler.php'));
endwhile;
get_footer(); ?>