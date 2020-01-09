<?php
// Paperplane _blankTheme - template per index.
get_header();
?>


<div class="box-fullscreen fullscreen-cta fullscreen-cta-center bg-3 lazy coverize" data-bg="url('<?php bloginfo('stylesheet_directory'); ?>/assets/images/test-images/1.jpg')" data-aos="zoom-out">
  <div class="fullscreen-cta-aligner">
    <div class="wrapper">
      <div class="wrapper-padded">
        <div class="fullscreen-cta-safe-padding last-child-no-margin txt-4" data-aos="fade-right">
          <h1>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In nec sodales nibh, ut volutpat felis. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</h1>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="wrapper bg-7" data-aos="fade-up">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more-840">
      <div class="content-styled modulo-space">
        <h1>Test tipografico h1<br />Test tipografico h1!!!!!</h1>
        <a href="#" class="round-button clear-round-button">clear-round-button</a>
        <h2>Test tipografico h2<br />Test tipografico h2</h2>
        <h3>Test tipografico h3<br />Test tipografico h3</h3>
        <h4>Test tipografico h4<br />Test tipografico h4</h4>
        <h5>Test tipografico h5<br />Test tipografico h5</h5>
        <h6>Test tipografico h6<br />Test tipografico h6</h6>
        <p>
          Lorem ipsum dolor sit amet, <a href="#">consectetur</a> adipiscing elit. <em>Sed facilisis sodales sem eu vestibulum</em>. Pellentesque mi nulla, molestie at accumsan sed, vulputate sed mauris. Phasellus orci arcu, iaculis eu finibus eu, efficitur et quam. Quisque lobortis, dolor quis dignissim porttitor, mi velit lacinia lectus, eget consectetur nisl orci a erat. Fusce posuere orci non felis maximus sodales. Fusce eu augue auctor, congue nisl sit amet, dapibus ligula. Quisque id diam nisi. Nunc lacinia mauris vel tincidunt tincidunt. <strong>Nulla sed augue auctor, volutpat dui varius, rutrum arcu.</strong> Aliquam id sem odio. Ut a ligula tempor, dapibus magna ut, lobortis nunc. Fusce vitae mattis nibh.
        </p>
        <a href="#" class="round-button dark-round-button">dark-round-button</a>

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

        <p>
          <?php _e('Ciao mondo!', 'paperplane-theme'); ?>
        </p>

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


<div class="box-fullscreen fullscreen-cta fullscreen-cta-bottom bg-3 lazy fixx" data-bg="url('<?php bloginfo('stylesheet_directory'); ?>/assets/images/test-images/2.jpg')">
  <div class="fullscreen-cta-aligner">
    <div class="wrapper">
      <div class="wrapper-padded">
        <div class="fullscreen-cta-safe-padding last-child-no-margin txt-4" data-aos="fade-right">
          <h1>Box fullscreen con titolo in basso e immagine BG</h1>
          <h1>Box fullscreen con titolo in basso e immagine BG</h1>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="wrapper bg-7">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <div class="wrapper-padded-more-650">
        <div class="modulo-space">
          <h1>Slideshow</h1>
          <?php get_template_part( 'template-parts/slideshows/regular-slideshow-b' ); ?>
        </div>

      </div>
    </div>
  </div>
</div>


<div class="wrapper bg-7">
  <div class="wrapper-padded">
    <div class="wrapper-padded-more">
      <h1>Test griglie</h1>
      <h2>le griglie con flexbox ora hanno una classe che gestisce il numero di elementi per riga e una che definisce la loro spaziatura.</h2>

      <h2>griglia a 2 - margins-thin</h2>
      <div class="flex-hold flex-hold-2 margins-thin bg-5">

        <div class="flex-hold-child bg-3">
          <h2>just a box - xxx</h2>
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
<div class="wrapper bg-7 modulo-space">
  <?php get_template_part( 'template-parts/slideshows/regular-slideshow' ); ?>
</div>
<?php get_footer(); ?>
