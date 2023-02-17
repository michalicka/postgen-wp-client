<?php
function pgwc_options() {
    echo strtr(
        file_get_contents(PGWC_PLUGIN_DIR.'/templates/options.html'),
        [
            '{{ _wpnonce }}' => wp_create_nonce('update-options'),
            '{{ pgwc_enabled_1 }}' => get_option('pgwc_enabled') == "1" ? "selected" : "",
            '{{ pgwc_enabled_0 }}' => get_option('pgwc_enabled') == "0" ? "selected" : "",
            '{{ pgwc_api_url }}' => plugin_dir_url(__FILE__).'api.php',
            '{{ pgwc_api_key }}' => get_option('pgwc_api_key', sha1(time())),
            '{{ pgwc_status }}' => get_option('pgwc_status', 'publish'),
            '{{ pgwc_status_publish }}' => get_option('pgwc_status', 'publish') === "publish" ? "selected" : "",
            '{{ pgwc_status_future }}' => get_option('pgwc_status', 'publish') === "future" ? "selected" : "",
            '{{ pgwc_status_draft }}' => get_option('pgwc_status', 'publish') === "draft" ? "selected" : "",
            '{{ pgwc_status_pending }}' => get_option('pgwc_status', 'publish') === "pending" ? "selected" : "",
            '{{ pgwc_status_private }}' => get_option('pgwc_status', 'publish') === "private" ? "selected" : "",
            '{{ pgwc_category }}' => wp_dropdown_categories([
                'show_option_none' => '',
                'option_none_value' => '',
                'orderby' => 'name',
                'echo' => 0,
                'hide_empty' => false,
                'name' => 'pgwc_category_id',
                'selected' => get_option('pgwc_category_id')
            ]),
            '{{ pgwc_author }}' => wp_dropdown_users([
                'echo' => 0,
                'selected' => get_option('pgwc_author_id'),
                'name' => 'pgwc_author_id',
            ]),
            '{{ submit_label }}' => translate('Save Changes'),
        ]
    );
}
