<?php
// Paperplane _blankTheme - template per index.
get_header();
?>

<div class="box-fullscreen bg-3 lazy coverize" data-bg="url('<?php bloginfo('stylesheet_directory'); ?>/images/test-images/1.jpg')">
  <div class="fullscreen-cta fullscreen-cta-center">
    <div class="wrapper">
      <div class="wrapper-padded">
        <h1 class="txt-6">Box fullscreen con titolo a metà e immagine BG</h1>
      </div>
    </div>
  </div>
</div>


<div class="box-fullscreen bg-3 covered">
  <div class="lazy only-explorer" data-bg="url('<?php bloginfo('stylesheet_directory'); ?>/images/test-images/2.jpg')"></div>
  <picture>
     <source media="(max-width: 1024px)" data-srcset="<?php bloginfo('stylesheet_directory'); ?>/images/test-images/2.jpg">
     <source media="(min-width: 1025px)" data-srcset="<?php bloginfo('stylesheet_directory'); ?>/images/test-images/2.jpg">
     <img src="<?php bloginfo('stylesheet_directory'); ?>/images/test-images/2.jpg" data-src="<?php bloginfo('stylesheet_directory'); ?>/images/test-images/2.jpg" title="<?php echo $attachment_title; ?>" alt="<?php echo $attachment_alt; ?>"  class="no-explorer lazy" />
   </picture>
  <div class="fullscreen-cta-bottom">
    <div class="wrapper">
      <div class="wrapper-padded">
        <h1 class="txt-6">Box fullscreen con titolo in basso e immagine con proprietà object-fit</h1>
        <h2 class="txt-6">incluso un fallback per Explorer che mostra l'immagine di BG perchè object-fit non è supportato da Explorer</h2>
      </div>
    </div>
  </div>
</div>

<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <div class="content-styled">
        <h1>Test tipografico h1<br />Test tipografico h1!!!!!</h1>
        <h2>Test tipografico h2<br />Test tipografico h2</h2>
        <h3>Test tipografico h3<br />Test tipografico h3</h3>
        <h4>Test tipografico h4<br />Test tipografico h4</h4>
        <h5>Test tipografico h5<br />Test tipografico h5</h5>
        <h6>Test tipografico h6<br />Test tipografico h6</h6>
        <p>Test <em>tipografico</em> paragrafo<br />Test tipografico paragrafo con un <a href="#">link</a>.</p>
        <a href="#" class="round-button">round-button</a>

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
</div>


<h1>Slideshow con altezza adattiva</h1>
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

<h1>Slideshow verticale con altezza adattiva</h1>
<?php get_template_part( 'template-parts/slideshows/regular-slideshow-b' ); ?>




<div class="wrapper">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <h1>Test griglie</h1>
      <h2>le griglie con flexbox ora hanno una classe che gestisce il numero di elementi per riga e una che definisce la loro spaziatura.</h2>

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
