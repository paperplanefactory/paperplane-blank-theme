<?php
/**
 * The template for displaying search results pages
 */

get_header();
?>
<div class="wrapper <?php echo $options_fields['theme_archive_page_color_scheme']; ?>">
    <div class="wrapper-padded">
        <div class="wrapper-padded-container">
            <?php if (have_posts()): ?>
                <div class="flex-hold flex-hold-3 margins-wide grid-infinite listing-grid-container">
                    <?php
                    while (have_posts()):
                        the_post();
                        include(locate_template('template-parts/grid/post-infinite.php'));
                    endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php theme_pagination_system(); ?>



<?php get_footer(); ?>