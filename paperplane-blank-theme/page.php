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
          <div class="content-styled modulo-space">
            <?php paperplane_breadcrumbs(); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endwhile; ?>








<?php get_footer(); ?>
