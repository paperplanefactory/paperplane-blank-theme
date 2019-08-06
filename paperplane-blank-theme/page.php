<?php
/**
*  Paperplane _blankTheme - template predefinito per pagine.
*/
get_header();
?>
<?php while ( have_posts() ) : the_post(); ?>
  <div class="wrapper">
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
    print_theme_image( $image_data, $image_sizes );
    ?>


    <div class="wrapper-padded">
      <div class="wrapper-padded-more">
        <div class="wrapper-padded-more-840">
          <div class="content-styled">
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>





<h2>griglia a 4 - margins-thin</h2>



<div class="flex-hold flex-hold-4 margins-thin bg-5">
  <?php
  // query con tassonomia
  $args_filter_posts = array(
    'post_type' => 'post',
    'posts_per_page' => -1
  );
  $my_filter_posts = get_posts( $args_filter_posts );
  ?>
  <?php if ( !empty ( $my_filter_posts ) ) : ?>
    <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
      <div class="flex-hold-child bg-3">
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
        print_theme_image( $image_data, $image_sizes );
        ?>
        <h2><?php the_title(); ?></h2>
      </div>
    <?php endforeach; wp_reset_postdata(); endif; ?>




</div>



<?php get_footer(); ?>
