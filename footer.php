<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
?>
<div id="footer" class="bg-1 txt-6">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div id="footer-structure">
        <div class="footer-structure-1">
          <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage">
          &copy; <?php echo date("Y"); ?> <?php echo get_bloginfo( 'name' ); ?>
          </a>
        </div>
        <div class="footer-structure-2">
          <ul>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'foot-menu' ) ); ?>
          </ul>
        </div>
        <div class="footer-structure-3">
          handcrafted by <a href="http://www.paperplanefactory.com/" target="_blank">Paperplane</a>  - powered by <a href="http://wordpress.org/" target="_blank">WordPress</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?php wp_footer();
?>
</body>
</html>
