<?php
/**
 *  Paperplane _blankTheme
 * Template Name: Listing
 */
get_header();
$page_listing_cpt = get_field('page_listing_cpt');
$page_listing_layout = get_field('page_listing_layout');
global $listing_page_id;
$listing_page_id = get_the_ID();
$content_fields = paperplane_content_transients($post->ID);
include(locate_template('template-parts/grid/page-opening.php'));
?>
<?php if ($page_listing_layout === 'listing-grid'): ?>
  <div class="wrapper <?php the_field('page_opening_color_scheme'); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <?php
        $page = get_query_var('paged');
        $args_posts_paginati_infiniti = array(
          'post_type' => $page_listing_cpt,
          'posts_per_page' => 12,
          'paged' => $page
        );
        query_posts($args_posts_paginati_infiniti);
        if (have_posts()): ?>
          <div
            class="flex-hold flex-hold-<?php the_field('page_listing_columns_number'); ?> margins-wide grid-infinite listing-grid-container">
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

<?php elseif ($page_listing_layout === 'listing-blocks'): ?>
  <div class="wrapper <?php the_field('page_opening_color_scheme'); ?>">
    <div class="wrapper-padded">
      <div class="wrapper-padded-container">
        <div class="wrapper-padded-more-924">
          <div class="listing-grid-container">
            <?php
            $page = get_query_var('paged');
            $args_posts_paginati_infiniti = array(
              'post_type' => $page_listing_cpt,
              'posts_per_page' => 12,
              'paged' => $page
            );
            query_posts($args_posts_paginati_infiniti);
            if (have_posts()): ?>
              <div class="flex-hold flex-hold-3 margins-wide grid-infinite">
                <?php while (have_posts()):
                  the_post();
                  include(locate_template('template-parts/grid/block-infinite.php'));
                endwhile; ?>
              </div>
            <?php endif; ?>
          </div>

        </div>
      </div>
    </div>
  </div>
  <?php theme_pagination_system(); ?>
<?php endif; ?>
<?php get_footer(); ?>