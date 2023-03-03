<?php
function paperplane_multilang_setup()
{
    // verifico che sia attivo Polylang e creo un array con gli slug delle lingue attive
    if (function_exists('PLL')) {
        $langs_parameters = array(
            'hide_if_empty' => 0,
            'fields' => 'slug'
        );
        $languages = pll_languages_list($langs_parameters);
    }
    // oppure imposto il parametro per un sito monolingua
    else {
        $languages = array('any-lang');
    }
    return $languages;
}

function paperplane_content_transients()
{
    global $post, $content_fields;
    $content_id = $post->ID;
    $content_fields_transient = get_transient('content_fields_transient_' . $content_id);
    if (empty($content_fields_transient)) {
        $content_fields = get_fields($content_id);
        set_transient('content_fields_transient_' . $content_id, $content_fields, DAY_IN_SECONDS * 4);
    } else {
        $content_fields = $content_fields_transient;
    }
}

function paperplane_options_transients()
{
    global $options_fields;
    $options_fields_multilang = '';
    $options_fields_transient = get_transient('options_fields_transient');
    if (empty($options_fields_transient)) {
        $options_fields = get_fields('options');
        set_transient('options_fields_transient', $options_fields, DAY_IN_SECONDS * 4);
    } else {
        $options_fields = $options_fields_transient;
    }
    $languages = paperplane_multilang_setup();
    foreach ($languages as $language) {
        global ${$options_fields_multilang . $language};
        $options_fields_multilang_transient = get_transient('options_fields_multilang_transient_' . $language);
        if (empty($options_fields_multilang_transient)) {
            ${$options_fields_multilang . $language} = get_fields($language);
            set_transient('options_fields_multilang_transient_' . $language, ${$options_fields_multilang . $language}, DAY_IN_SECONDS * 4);
        } else {
            ${$options_fields_multilang . $language} = $options_fields_multilang_transient;
        }
    }


}

function paperplane_delete_content_transients($post_id, $post, $update)
{
    $this_cpt = get_post_type($post_id);
    delete_transient('content_fields_transient_' . $post_id);
    if ($this_cpt === 'page' || $this_cpt === 'post' || $this_cpt === 'cpt_banner' || $this_cpt === 'cpt_modal') {
        delete_transient('gestione_kazzum_transient_' . $post_id);
    }
    if ($this_cpt === 'cpt_modal') {
        delete_transient('paperplane_query_modals_transient');
    }
}
add_action('save_post', 'paperplane_delete_content_transients', 10, 3);

function paperplane_delete_option_pages_transients()
{
    delete_transient('options_fields_transient');
    $languages = paperplane_multilang_setup();
    foreach ($languages as $language) {
        delete_transient('options_fields_multilang_transient_' . $language);
    }
}
add_action('acf/save_post', 'paperplane_delete_option_pages_transients', 20);