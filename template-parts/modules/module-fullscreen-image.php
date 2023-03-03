<!-- module-fullscreen-image -->
<?php
$module_fullscreen_image_image = $module['module_fullscreen_image_image'];
if ($module_fullscreen_image_image != '') {
  $module_fullscreen_image_image_URL = $module_fullscreen_image_image['sizes']['full_desk'];
  $module_fullscreen_image_image_hd_URL = $module_fullscreen_image_image['sizes']['full_desk_hd'];
  $bg_lazy_class = 'lazy coverize';
}
?>
<div
  class="wrapper module-fullscreen-image <?php echo $module['module_bg'] . ' ' . $module['module_vertical_top_space'] . ' ' . $module['module_vertical_bottom_space']; ?>">
  <a name="section-<?php echo $module_count; ?>" class="section-anchor"></a>
  <div
    class="module-box-fullscreen coverize <?php echo $module['module_fullscreen_text_align_horizontal'] . ' ' . $bg_lazy_class; ?>"
    data-bg="<?php echo $module_fullscreen_image_image_URL; ?>"
    data-bg-hidpi="<?php echo $module_fullscreen_image_image_hd_URL; ?>" data-aos="fade">
    <div class="above-image-opacity"></div>
    <div class="wrapper-padded">
      <div class="module-fullscreen-texts" data-aos="fade-right">
        <?php if ($module['module_fullscreen_image_main_text']): ?>
          <h1>
            <?php echo $module['module_fullscreen_image_main_text']; ?>
          </h1>
        <?php endif; ?>
        <?php if ($module['module_fullscreen_image_secondary_text']): ?>
          <h2>
            <?php echo $module['module_fullscreen_image_secondary_text']; ?>
          </h2>
        <?php endif; ?>
        <div class="clearer"></div>
        <?php paperplane_theme_cta_advanced($module['paperplane_theme_cta']); ?>
      </div>
    </div>
  </div>
</div>
<!-- module-fullscreen-image -->