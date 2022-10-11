<?php
// Extensions Post Type
add_action('init', 'create_extensions');
function create_extensions() {
    register_post_type('extensions', array(
        'labels' => array(
            'name' => __('Extensions'),
            'singular_name' => __('Extensions'),
        ),
        'supports' => array(
            'title',
            // 'editor',
            // 'thumbnail'
        ),
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-images-alt2',
    ));
}

add_shortcode('availability_table', 'cf_availability_table_shortcode');
function cf_availability_table_shortcode() {
    ob_start();
    get_template_part('availability', 'table');
    return ob_get_clean();
}
