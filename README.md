# paperplane-blank-theme
A starter theme by PaperPlane Factory. Theme used as a starting base for WordPress projects.

## Requirements
Required plugins:
 - Advanced Custom Fields Pro

## Getting Started
1. delete GitHub folders to disconnect the folder from the repo
2. rename the theme folder e.g. clientname-theme
3. update the style.css file by modifying the Text Domain parameter: "paperPlane-blankTheme"
4. update the style.css file by modifying the GitHub repository links:
- Theme URI: https://github.com/paperplanefactory/clientname-theme
- GitHub Theme URI: https://github.com/paperplanefactory/clientname-theme
5. create the new repository on GitHub
6. activate the new theme in back end

## File strcture
### CSS
CSS - SCSS are located in assets > css folder.  
css folder contains desktop, global and mobile folders in order to manage SCSS partial files.  
Main SCSS compiler file - style.scss - is in css main folder.  
desktop, global and mobile folders can have a subfolder to manage external libraries CSS, like global > libraries > _aos.scss
### JavaScript
JavaScript are located in assets > js and assets > js > libs folders.
### Theme's media files
Media files are located in assets > images folder.  
The folder has sub folder in order to keep clean the use of media: admin-images, favicons, icons.  
Other images and media, like site logo, are in the main assets > images folder.
### Fonts
Fonts are located in assets > fonts folder.  
This folder is used for Material Icons mainly, but if project uses fonts that needs to be stored this is the righe folder.

## Debug
Use Query Monitor for debugging. To avoid slowdowns in back end, you can disable Query Monitor analyses only for the back end from the Theme Settings options page > Enable Query Monitor in back end?

## Default CPT Management
1. if some CPTs (e.g. banners or modals) are not needed:
- delete any existing content
- set the "Show UI" option to "false" in the CPT UI plugin and remove them in the relevant ACF fields (e.g. CTA) 

2. if the Under Construction plugin option is active, saving the "Theme Settings" page automatically generates the under construction page and maintenance page based on the site's logo and colors. For this to work, it's important that the "site-logo-header.svg" logo is replaced but not renamed

## ACF and transients
- $content_fields = paperplane_content_transients( $post->ID ); is used to recall fields related to the displayed content. It is generated in header.php and set as a global variable
- $options_fields = paperplane_options_transients(); is used for theme options that don't require translation. It is generated in header.php and set as a global variable
- $options_fields_multilang = paperplane_options_transients_multilanguage( $acf_options_parameter ); is used for theme options prepared for translation. It is generated in header.php and set as a global variable

You can disable the use of transients for ACF in back end from the Theme Settings options page > Use transients for custom fields?

## Page Openings
To properly maintain the above-the-fold image preload functionality, if additional page openings are needed, where possible maintain these names for custom fields of images and video poster:
- page_opening_image_desktop
- page_opening_image_mobile
- page_opening_video_poster

## Favicon
Starting from a file of at least 512x512 pixels, upload it to https://www.favicon-generator.org/, download the zip file, extract the contents and replace them with those present in the assets/images/favicons folder

## Performance Optimization
### CSS
After debugging, remove any unused partial CSS in assets/css/style.scss

### Upload Images
After debugging, use includes/theme-images-crop.php to verify that:
- added crops are of the correct size and are not pixelated or oversized
- that there are no unused add_image_size: each additional image takes up disk space and, if unused, becomes an unnecessary cost

If necessary, you can use the Regenerate Thumbnails plugin to bulk resize all uploaded images and delete unused crops.

### Theme Images
After debugging, to optimize images used by the theme (header logo, svg files...) download and install ImageOptim (https://imageoptim.com/mac) and drag the assets/images folder into the window. ImageOptim will automatically optimize the listed files.

### Font
For Google Fonts - Adobe Fonts copy the content of the provided stylesheet e.g.<br />
https://fonts.googleapis.com/css2?family=Atkinson+Hyperlegible:ital,wght@0,400;0,700;1,400;1,700&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap<br />
and replace the content of the file assets/css/global/_theme-font.scss<br />
After debugging open the file<br />
/includes/theme-performance.php<br />
and add the fonts in preload in the function<br />
paperplane_preload_data -> $fonts_preload<br />
which is an array of fonts to preload with their configurations.<br />
If using Adobe Fonts, it's not possible to retrieve font URLs. The next step will therefore be limited to the first element of the array.<br />
To determine which fonts to preload:
- view a page of the site in Chrome
- open the dev panel
- reload the page
- open the Network tab
- filter by font file type
- for each font copy the "Request URL:" and add it to the array
- 'type' can be 'preconnect' for the font server connection to use as the first element of the array
- 'font/woff2' for specific font files - use the correct font extension

## Footer links and © year
Year and the Privacy and Cookie Policy links in the footer are populated via script based on their classes:  
<code>&lt;span class="year-set-js"&gt;2025&lt;/span&gt;</code>  
<code>&lt;a class="privacy-link-js"&gt;Privacy Policy!&lt;/a&gt;</code>  
<code>&lt;a class="cookie-link-js"&gt;Cookie Policy&lt;/a&gt;</code>  
The function is called paperplane_compile_privacy_cookies and can be found in the file includes/theme-menus.php

## CSS Tools
- [CSS Gradient Generator](https://cssgradient.io/)
- [CSS Text Shadow Generator](https://css3gen.com/text-shadow/)
- [CSS Border Radius Generator](https://css3gen.com/border-radius/)
- [CSS Box Shadow Generator](https://css3gen.com/box-shadow/)
- [How to use mixins with parameters](https://marksheet.io/sass-mixins.html)