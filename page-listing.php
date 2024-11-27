<?php
/**
 *  Paperplane _blankTheme
 * Template Name: Listing
 */
get_header();
global $listing_page_id;
$listing_page_id = get_the_ID();
//$content_fields = paperplane_content_transients( $post->ID );
?>
<div class="wrapper">
	<div class="wrapper-padded">
		<div class="wrapper-padded-container">
			<?php
			$page = get_query_var( 'paged' );
			$args_posts_paginati_infiniti = array(
				'post_type' => 'post',
				'posts_per_page' => 12,
				'paged' => $page
			);
			query_posts( $args_posts_paginati_infiniti );
			if ( have_posts() ) : ?>
				<div class="flex-hold flex-hold-3 grid-infinite listing-grid-container">
					<?php
					while ( have_posts() ) :
						the_post();
						include( locate_template( 'template-parts/grid/post-infinite.php' ) );
					endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php theme_pagination_system(); ?>

<?php
wp_reset_query();
get_footer(); ?>