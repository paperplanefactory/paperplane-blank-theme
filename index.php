<?php
// Paperplane _blankTheme - template per index.
get_header();
?>
<?php
$args_filter_posts = array(
  'post_type' => 'post',
  'posts_per_page' => 2
);
$my_filter_posts = get_posts( $args_filter_posts );
?>
<?php if ( !empty ( $my_filter_posts ) ) : ?>

  <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post );
  $thumb_id = get_post_thumbnail_id();
  $attachment_title = get_the_title($thumb_id);
  $attachment_alt = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true);
  $thumb_url_desktop = wp_get_attachment_image_src($thumb_id, 'desktop_image', true);
  $thumb_url_tablet = wp_get_attachment_image_src($thumb_id, 'tablet_image', true);
  $thumb_url_mobile = wp_get_attachment_image_src($thumb_id, 'mobile_image', true);
  $thumb_url_mini = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
  ?>
    <div class="box-fullscreen test-gradient lazy coverize">
        <?php get_template_part( 'template-parts/images/image-display-fullscreen' ); ?>
      <div class="fullscreen-cta fullscreen-cta-center">
        <div class="wrapper">
          <div class="wrapper-padded">
            <h1 class="txt-6">aa<?php the_title(); ?></h1>
          </div>
        </div>
      </div>
    </div>


  <?php endforeach; wp_reset_postdata();
endif;

?>




<h1>Hold on</h1>

<div class="box-fullscreen bg-3 lazy coverize">
  <?php get_template_part( 'template-parts/images/image-display-fullscreen' ); ?>
  <div class="fullscreen-cta-bottom">
    <div class="wrapper">
      <div class="wrapper-padded">
        <h1 class="txt-6">Box full-screen con titolo in basso</h1>
      </div>
    </div>
  </div>
</div>




<h1>Slideshow</h1>
<!-- modulo slide -->

<?php get_template_part( 'template-parts/slideshows/fullscreen-slideshow' ); ?>

<div class="wrapper bg-6 modulo-space">
  <div class="in-box-space">
    <div class="box-fullscreen-home">
      <div class="wrapper">
        <div class="wrapper-padded">
          <div class="wrapper-padded-more">
            <div class="wrapper-padded-more-650">
              <?php get_template_part( 'template-parts/slideshows/regular-slideshow' ); ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<?php get_template_part( 'template-parts/slideshows/fullscreen-slideshow' ); ?>







<h1>Test tipografico h1<br /><a href="#" class="inzzz">Test tipografico h1!</a></h1>
<h2>Test tipografico h2<br />Test tipografico h2!</h2>
<h3>Test tipografico h3<br />Test tipografico h3!</h3>
<h4>Test tipografico h4<br />Test tipografico h4!</h4>
<h5>Test tipografico h5<br />Test tipografico h5!</h5>
<h6>Test tipografico h6<br />Test tipografico h1!</h6>


<a href="#" class="round-button">round-button</a>

<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more content-styled bg-5">
      <div class="pad-1">
        <h1>Test tipografico h1<br />Test tipografico h1!!!!!</h1>
      </div>

      <h2>Test tipografico h2<br />Test tipografico h2</h2>
      <h3>Test tipografico h3<br />Test tipografico h3</h3>
      <h4>Test tipografico h4<br />Test tipografico h4</h4>
      <h5>Test tipografico h5<br />Test tipografico h5</h5>
      <h6>Test tipografico h6<br />Test tipografico h6</h6>
      <div class="marg-1">
        <p>Test <em>tipografico</em> paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
      </div>

      <ul>
        <li>Elenco puntato</li>
        <li>Elenco puntato</li>
        <li>Elenco puntato</li>
        <li>Elenco puntato</li>
        <li>Elenco puntato</li>
      </ul>
      <ol>
        <li>Elenco numerato</li>
        <li>Elenco numerato</li>
        <li>Elenco numerato</li>
        <li>Elenco numerato</li>
        <li>Elenco numerato</li>
      </ol>
      <p>Test tipografico <a href="#" class="download">paragrafo!!!</a><br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
    </div>
  </div>
</div>

<h1>Testo ad espansione</h1>
<!-- modulo espansione -->
<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <div class="wrapper-padded-more-650 expander-bottom">
        <div class="expander-top">
          <h4 class="expander exp-plus"><span></span>Titolo ad espansione</h4>
        </div>

        <div class="expandable-content">
          <div class=" content-styled">
            <p>Test tipografico paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

























<h1>Test griglie</h1>
<div class="wrapper">
  <div class="wrapper-padded">
    <h2>griglia a 5</h2>
    <div class="flex-hold flex-hold-5 bg-3">
      <?php
      $args_filter_posts = array(
        'post_type' => 'post',
        'posts_per_page' => -1
      );
      $my_filter_posts = get_posts( $args_filter_posts );
      ?>
      <?php if ( !empty ( $my_filter_posts ) ) : ?>
        <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
          <?php get_template_part( 'template-parts/grid/post' ); ?>
        <?php endforeach; wp_reset_postdata(); endif; ?>
    </div>

    <h2>griglia a 4</h2>
    <div class="flex-hold flex-hold-4 bg-3">
      <?php
      $args_filter_posts = array(
        'post_type' => 'post',
        'posts_per_page' => -1
      );
      $my_filter_posts = get_posts( $args_filter_posts );
      ?>
      <?php if ( !empty ( $my_filter_posts ) ) : ?>
        <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
          <?php get_template_part( 'template-parts/grid/post' ); ?>
        <?php endforeach; wp_reset_postdata(); endif; ?>
    </div>

    <h2>griglia a 3</h2>
    <div class="flex-hold flex-hold-3 bg-3">
      <?php
      $args_filter_posts = array(
        'post_type' => 'post',
        'posts_per_page' => -1
      );
      $my_filter_posts = get_posts( $args_filter_posts );
      ?>
      <?php if ( !empty ( $my_filter_posts ) ) : ?>
        <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
          <?php get_template_part( 'template-parts/grid/post' ); ?>
        <?php endforeach; wp_reset_postdata(); endif; ?>
    </div>
    <h2>griglia a 2</h2>
    <div class="flex-hold flex-hold-2 bg-3">
      <?php
      $args_filter_posts = array(
        'post_type' => 'post',
        'posts_per_page' => -1
      );
      $my_filter_posts = get_posts( $args_filter_posts );
      ?>
      <?php if ( !empty ( $my_filter_posts ) ) : ?>
        <?php foreach ( $my_filter_posts as $post ) : setup_postdata ($post ); ?>
          <?php get_template_part( 'template-parts/grid/post' ); ?>
        <?php endforeach; wp_reset_postdata(); endif; ?>
    </div>
  </div>
</div>
























<?php get_footer(); ?>
