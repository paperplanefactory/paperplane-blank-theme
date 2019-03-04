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




<h1>Slideshow altezza adattiva</h1>
<!-- modulo slide -->
<?php //get_template_part( 'template-parts/slideshows/fullscreen-slideshow' ); ?>

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

<h1>Slideshow verticale</h1>
<?php get_template_part( 'template-parts/slideshows/regular-slideshow-b' ); ?>




<h1>Tipografia</h1>
<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more content-styled">
      <h1>Test tipografico h1<br />Test tipografico h1!!!!!</h1>
      <h2>Test tipografico h2<br />Test tipografico h2</h2>
      <h3>Test tipografico h3<br />Test tipografico h3</h3>
      <h4>Test tipografico h4<br />Test tipografico h4</h4>
      <h5>Test tipografico h5<br />Test tipografico h5</h5>
      <h6>Test tipografico h6<br />Test tipografico h6</h6>
      <p>Test <em>tipografico</em> paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
      <p>Test <em>tipografico</em> paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>

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
      <a href="#" class="round-button">round-button</a>
      <p>Test tipografico <a href="#" class="download">paragrafo!!!</a><br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
      <div class="expander-top">
        <button class="expander exp-open" aria-expanded="false"><span class="exp-plus"></span>Titolo ad espansione<br />con test a capo</button>
      </div>

      <div class="expandable-content">
        <div class=" content-styled">
          <p>Test tipografico paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
        </div>
      </div>
    </div>
  </div>
</div>























<h1>Test griglie</h1>
<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">

      <h2>griglia a 2 - margins-thin</h2>
      <div class="flex-hold flex-hold-2 margins-thin bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 2 - margins-wide</h2>
      <div class="flex-hold flex-hold-2 margins-wide bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 2 - margins-fit</h2>
      <div class="flex-hold flex-hold-2 margins-fit bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 3 - margins-thin</h2>
      <div class="flex-hold flex-hold-3 margins-thin bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 3 - margins-wide</h2>
      <div class="flex-hold flex-hold-3 margins-wide bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 3 - margins-fit</h2>
      <div class="flex-hold flex-hold-3 margins-fit bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 4 - margins-thin</h2>
      <div class="flex-hold flex-hold-4 margins-thin bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 4 - margins-wide</h2>
      <div class="flex-hold flex-hold-4 margins-wide bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 4 - margins-fit</h2>
      <div class="flex-hold flex-hold-4 margins-fit bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 5 - margins-thin</h2>
      <div class="flex-hold flex-hold-5 margins-thin bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 5 - margins-wide</h2>
      <div class="flex-hold flex-hold-5 margins-wide bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

      <h2>griglia a 5 - margins-fit</h2>
      <div class="flex-hold flex-hold-5 margins-fit bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

        <div class="flex-hold-child bg-3">
          <h2>just a box</h2>
        </div>

      </div>

    </div>
  </div>
</div>

<?php get_footer(); ?>
