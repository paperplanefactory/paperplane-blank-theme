<?php
// alla classe del contenitore devo aggiungere il selettore ".grid-infinite"
$page = get_query_var('paged');
$args_posts_paginati_infiniti = array(
  'post_type' => 'post',
  'posts_per_page' => 12,
  'paged' => $page
);
query_posts( $args_posts_paginati_infiniti );
if ( have_posts() ) : ?>
<div class="grid-infinite">
<?php while ( have_posts() ) : the_post();
// fai qualcosa tipo stampare il titolo - alla classe del box devo aggiungere il selettore ".grid-item-infinite"
endwhile; ?>
</div>
<?php endif; ?>

<script>
$(document).ready(function() {
  var grid = $('.grid-infinite');
  grid.infinitescroll({
    // Pagination element that will be hidden
    navSelector: '.navigation',
		// Next page link
		nextSelector: '.nav-next a',
		// Selector of items to retrieve
		itemSelector: '.grid-item-infinite',
    // Loading message
    loading: {
      finishedMsg: 'Fine dei risultati',
      msgText: "Caricamento dei risultati in corso..."
    }
  },
  // Function called once the elements are retrieved
  function(new_elts) {
    var elts = $(new_elts).css('opacity', 0);
		elts.animate({opacity: 1});
    $("img.lazymage, img.lazy, div.lazy, li.lazy").lazyload({
      effect : "fadeIn",
      placeholder : "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAADICAYAAACtWK6eAAABh0lEQVR42u3TAQ0AMAgAoLtXM5P1tYAJHHQgflY/YBWCgCAgCAgCgoAgIAgIAoKAIIAgIAgIAoKAICAICAKCgCAgiCAgCAgCgoAgIAgIAoKAICAIIAgIAoKAICAICAKCgCAgCAgCCAKCgCAgCAgCgoAgIAgIAggCgoAgIAgIAoKAICAICAKCAIKAICAICAKCgCAgCAgCggCCgCAgCAgCgoAgIAgIAoKAIIAgIAgIAoKAICAICAKCgCAgiCAgCAgCgoAgIAgIAoKAICAIIAgIAoKAICAICAKCgCAgCAgiCAgCgoAgIAgIAoKAICAICAIIAoKAICAICAKCgCAgCAgCggCCgCAgCAgCgoAgIAgIAoIAgoAgIAgIAoKAICAICAKCgCCAICAICAKCgCAgCAgCgoAggCAgCAgCgoAgIAgIAoKAICAIIAgIAoKAICAICAKCgCAgCAgiCAgCgoAgIAgIAoKAICAICAIIAoKAICAICAKCgCAgCAgCgggCgoAgIAgIAoKAICAIXDQgo1u4oXpdLAAAAABJRU5ErkJggg==",
      load : function() {
        $(".lazy-placehoder").fadeOut(150);
      }
    });
	});
});
</script>


<!-- qui aggiungo la paginazione classica di WP che verrà poi nascosta -->
<div class="navigation">
<div class="alignleft"><?php previous_posts_link( '&laquo; Previous Entries' ); ?></div>
<div class="alignright nav-next"><?php next_posts_link( 'Next Entries &raquo;', '' ); ?></div>
</div>
