</div><!-- id="page-content" aperto in header.php -->
<?php
// Paperplane _blankTheme - template per footer.
wp_reset_query();
global $acf_options_parameter, $options_fields, $options_fields_multilang, ${$options_fields_multilang . $acf_options_parameter}, $footer_wrapper, $static_bloginfo_stylesheet_directory, $cta_url_modal_array;
$cta_url_modal_array = array_unique($cta_url_modal_array);
?>
<footer id="footer" class="colors-white-bg">
  <div class="wrapper">
    <div class="wrapper-padded">
      <div class="<?php echo $footer_wrapper; ?>">
        <div class="flex-hold flex-hold-2 margins-wide verticalize">
          <div class="flex-hold-child">
            <div class="footer-logo">
              <a href="<?php echo home_url(); ?>" rel="bookmark" title="homepage - <?php echo get_bloginfo('name'); ?>">
                <img data-src="<?php echo $static_bloginfo_stylesheet_directory; ?>/assets/images/site-logo-header.svg"
                  class="lazy" alt="<?php echo get_bloginfo('name'); ?> - homepage" />
              </a>
            </div>
          </div>
          <div class="flex-hold-child desktop-align-right">
            <?php if ($options_fields['global_socials']): ?>
              <ul class="inline-socials">
                <?php foreach ($options_fields['global_socials'] as $global_social): ?>
                  <li>
                    <a href="<?php echo $global_social['global_socials_profile_url']; ?>"
                      class="<?php echo $global_social['global_socials_icon']; ?>" target="_blank"
                      aria-label="Visit <?php echo $global_social['global_socials_profile_url']; ?>" rel="noopener">
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>
        </div>
        <?php
        if (has_nav_menu('footer-menu')) {
          wp_nav_menu(array('theme_location' => 'footer-menu', 'container' => 'ul', 'menu_class' => 'footer-menu'));
        }
        ?>
        <div class="flex-hold flex-hold-2 margins-wide verticalize">
          <div class="flex-hold-child">
            <?php echo ${$options_fields_multilang . $acf_options_parameter}['footer_legal_notes']; ?>
            <p>
              <a href="#" class="accessible-navi-activate-js"
                title="<?php _e('Activate focus on links', 'paperPlane-blankTheme'); ?>"
                aria-label="<?php _e('Activate focus on links', 'paperPlane-blankTheme'); ?>"
                data-original-label="<?php _e('Activate focus on links', 'paperPlane-blankTheme'); ?>"
                data-active-label="<?php _e('Deactivate focus on links', 'paperPlane-blankTheme'); ?>">
                <?php _e('Activate focus on links', 'paperPlane-blankTheme'); ?>
              </a>
            <div id="install">install</div>
            </p>
          </div>
          <div class="flex-hold-child desktop-align-right">
            <?php echo ${$options_fields_multilang . $acf_options_parameter}['footer_credits']; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</footer>

<?php
$args_modals = array(
  'post_type' => 'cpt_modal',
  'posts_per_page' => -1,
  'include' => $cta_url_modal_array
);
$paperplane_query_modals_transient = get_transient('paperplane_query_modals_transient');
if (empty($paperplane_query_modals_transient)) {
  $my_modals = get_posts($args_modals);
  set_transient('paperplane_query_modals_transient', $my_modals, DAY_IN_SECONDS * 4);
} else {
  $my_modals = $paperplane_query_modals_transient;
}
if (!empty($my_modals)) {
  foreach ($my_modals as $post):
    setup_postdata($post);
    include(locate_template('template-parts/grid/modal.php'));
  endforeach;
  wp_reset_postdata();
}
?>
</div>







<!--
<div class="preload-container">
  <div class="sk-folding-cube">
    <div class="sk-cube1 sk-cube"></div>
    <div class="sk-cube2 sk-cube"></div>
    <div class="sk-cube4 sk-cube"></div>
    <div class="sk-cube3 sk-cube"></div>
  </div>
</div>
-->
<?php wp_footer(); ?>
</body>

</html>