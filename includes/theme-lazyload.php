<?php
// lazy load
function footer_lazyload() { ?>
  <script>
  (function() {
    var lazyLoadInstances = [];
    // The "lazyLazy" instance of lazyload is used (kinda improperly)
    // to check when the .horzContainer divs enter the viewport
    var lazyLazy = new LazyLoad({
      elements_selector: ".lazy",
      class_loading: "lazy-loading",
      class_loaded: "lazy-loaded",
        // When the .horzContainer div enters the viewport...
        callback_enter: function(el) {
          console.log('entered');
            // ...instantiate a new LazyLoad on it
            var oneLL = new LazyLoad({
                container: el
            });
            // Optionally push it in the lazyLoadInstances
            // array to keep track of the instances
            lazyLoadInstances.push(oneLL);
        }
    });
  }());
</script>
<?php
}
//add_action('wp_footer', 'footer_lazyload');

function filter_lazyload($content) {
    return preg_replace_callback('/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'preg_lazyload', $content);
}
add_filter('the_content', 'filter_lazyload');


function preg_lazyload($img_match) {

    $img_replace = $img_match[1] . 'src="' . get_stylesheet_directory_uri() . '/images/lazy-load/preload.png" data-src' . substr($img_match[2], 3) . $img_match[3];

    $img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazy ', $img_replace);

    $img_replace .= '<noscript>' . $img_match[0] . '</noscript>';
    return $img_replace;
}


function filter_lazyloadcf($content) {
    return preg_replace_callback('/(<\s*img[^>]+)(src\s*=\s*"[^"]+")([^>]+>)/i', 'preg_lazyloadcf', $content);
}
add_filter('acf_the_content', 'filter_lazyloadcf');


function preg_lazyloadcf($img_match) {

    $img_replace = $img_match[1] . 'src="' . get_stylesheet_directory_uri() . '/images/lazy-load/preload.png" data-src' . substr($img_match[2], 3) . $img_match[3];

    $img_replace = preg_replace('/class\s*=\s*"/i', 'class="lazy ', $img_replace);

    $img_replace .= '<noscript>' . $img_match[0] . '</noscript>';
    return $img_replace;
}
