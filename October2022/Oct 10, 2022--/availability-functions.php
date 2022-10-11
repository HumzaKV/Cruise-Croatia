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


add_action( 'wp_ajax_contact_quote', 'wpajax_contact_quote_callback' );
add_action( 'wp_ajax_nopriv_contact_quote', 'wpajax_contact_quote_callback' );
function wpajax_contact_quote_callback() {
ob_start();
?>
<div class="container">
    <span>Departure Date</span>
    <input type="text" disabled class="dep_date" value="<?php echo $_POST['date'] ?>">
    <span>Cabins</span>
    <input type="text" disabled class="total_cabins" value="<?php echo $_POST['cabin'] .' x Cabins' ?>">
    <span class="total_cabins_price"><?php echo intval($_POST['cabin']) * intval($_POST['price']) ?></span>
    <span>Cabins</span>
    <input type="text" disabled class="total_passengers" value="<?php echo $_POST['cabin'] .' x passengers' ?>">
    <span class="total_passengers_price"><?php echo intval($_POST['passenger']) * intval($_POST['price']) ?></span>
    <p>Availablity: <?php echo $_POST['avl'] ?></p>
</div>
<?php
return ob_get_clean();
// print_r($data['date']);
    die;
    pre($data, 1);
}
