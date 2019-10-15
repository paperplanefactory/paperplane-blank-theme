<?php
// query con tassonomia
$args_filter_posts = array(
  'post_type' => 'post',
  'posts_per_page' => 10
);
$my_filter_posts = get_posts( $args_filter_posts );
?>
<?php if ( !empty ( $my_filter_posts ) ) : ?>
<div class="single-item">
  <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
    <?php
    $image_data = array(
        'image_type' => 'post_thumbnail', // options: post_thumbnail, acf_field, acf_sub_field
        'image_value' => 'immagine_acf', // se utilizzi un custom field indica qui il nome del campo
        'size_fallback' => 'full_desk'
    );
    $image_sizes = array( // qui sono definiti i ritagli o dimensioni. Devono corrispondere per numero a quanto dedinfito nella funzione nei parametri data-srcset o srcset
        'retina' => 'full_desk_retina',
        'desktop' => 'full_desk',
        'mobile' => 'content_picture',
        'micro' => 'micro'
    );
    print_theme_image_lazyslick( $image_data, $image_sizes );
    ?>
  <?php endforeach; wp_reset_postdata(); ?>
</div>

<div class="paging-info"></div>
<?php endif; ?>
