<?php

if (@$_GET['debug'] == 1) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(1);
}

define('THEME_PATH', get_template_directory());
define('THEME_URL', get_template_directory_uri());

require_once THEME_PATH . '/maxmind/vendor/autoload.php';
// require get_stylesheet_directory() . '/kv-minifyhtml.php';


use GeoIp2\Database\Reader;

require_once THEME_PATH . '/availability-functions.php';

// filosofo custom image sizes
require_once THEME_PATH . '/inc/filosofo-custom-image-sizes.php';

// Search Form Shortcode
// require_once THEME_PATH . '/searching-form.php';

// Day Tour Shortcode
require_once THEME_PATH . '/inc/daytour-shortcode.php';

// Product Shortcode
require_once THEME_PATH . '/inc/product-shortcode.php';

// Blog Shortcode
require_once THEME_PATH . '/inc/blog-shortcode.php';

// Price Function
require_once THEME_PATH . '/inc/price-function.php';

// Ajax Code
require_once THEME_PATH . '/ajax-code.php';

// Protect Wp-admin
require_once THEME_PATH . '/protect-wp-admin/protect-wp-admin.php';

// post-type-slug Function
require_once THEME_PATH . '/post-type-slug.php';

// Review Page
require_once THEME_PATH . '/review-page.php';

if (!function_exists('is_val')) {
    function is_val($var, $key = null)
    {
        if (empty($key)) {
            if (isset($var) && !empty($var)) {
                return $var;
            }

        } else {
            if (is_array($var) && array_key_exists($key, $var)) {
                return is_val($var[$key]);
            } else if (is_object($var) && property_exists($var, $key)) {
                return is_val($var->$key);
            }

        }

        return;
    }
}

if (!function_exists('pre')) {
    function pre($value, $exit = false)
    {
        if (@$_GET['dev'] == 1) {
            echo '<pre>';
            print_r($value);
            echo '</pre>';

            if ($exit) {
                exit;
            }
        }
    }
}

function cf_geo_location() {
    // pre($_SERVER);
    if (!array_key_exists('HTTP_CF_IPCOUNTRY', $_SERVER)) {
        $reader = new Reader(THEME_PATH . '/maxmind/GeoLite2-City.mmdb');
        // 141.101.107.101
        // 202.143.127.149
        $ipaddress = $_SERVER['REMOTE_ADDR'];
        //$loc_response = wp_remote_get('http://ip-api.com/json/'. $ipaddress);
        //pre("SERVER_1");
        // pre( $loc_response );
        //pre($_COOKIE);
        $record = $reader->city($ipaddress);
        $country = is_val($record, 'country');
        //$country = json_decode($loc_response['body']);
        $isoCode = $country->isoCode; // is_val($country, 'isoCode');
        // $isoCode = $country->countryCode;
        //pre($country);
    } else {
        $isoCode = $_SERVER['HTTP_CF_IPCOUNTRY'];
    }

    if ($isoCode == 'US') {
        $defaultCurrency = 'USD';
    } else if ($isoCode == 'AU') {
        $defaultCurrency = 'AUD';
    } else if ($isoCode == 'GB') {
        $defaultCurrency = 'GBP';
    } else {
        $defaultCurrency = 'EUR';
    }

// pre($defaultCurrency);
    return $defaultCurrency;
}

function cf_text_lang($us_text, $eu_text)
{
    $currency = cf_curr_currency();
    if ($currency == 'USD') {
        return $us_text;
    } else {
        return $eu_text;
    }

}

function theme_files() {
    // Theme Files

    wp_register_style('theme-style', get_stylesheet_uri(), false, null);
    wp_enqueue_style('theme-style');

    wp_register_style('theme-responsive', THEME_URL . '/css/responsive.css', false, '1.11.7');
    wp_enqueue_style('theme-responsive');
    wp_register_style('font-css', THEME_URL . '/css/fonts.css', false, false);
    wp_enqueue_style('font-css');

    // Date Picker
    wp_register_style('jquery-ui', '//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css', false, '1.11.3');
    wp_enqueue_style('jquery-ui');

    wp_register_script('datedropper_js', THEME_URL . '/js/datedropper.min.js', array('kv-scripts'), '1.0', true);

    // BG lazy load
    wp_register_script('lazy-load-bg-image', get_stylesheet_directory_uri() . '/js/lazy-load-bg-image.js', array('jquery'), false, true);
    wp_enqueue_script('lazy-load-bg-image');

    // Owl Carousel Files
    wp_register_style('owl-carousel', THEME_URL . '/owl-carousel/owl-carousel.min.css', false, '2.2.1');
    wp_enqueue_style('owl-carousel');
    wp_register_script('owl-carousel', THEME_URL . '/owl-carousel/owl.carousel.min.js', array('jquery'), '2.2.1', false);
    wp_enqueue_script('owl-carousel');

    // Slick Files
    wp_register_style('slick', THEME_URL . '/slick/slick.css', false, '3.2.1');
    wp_enqueue_style('slick');

    wp_register_script('slick', THEME_URL . '/slick/slick.min.js', array('jquery',), '1.8.0', true);
    wp_enqueue_script('slick');

    // FancyBox
    wp_register_style('fancyboxcss', THEME_URL . '/fancybox/jquery.fancybox.min.css', false, '3.2.1');
    wp_enqueue_style('fancyboxcss');

    wp_register_script('fancyboxjs', THEME_URL . '/fancybox/jquery.fancybox.min.js', array('jquery',), '1.8.0', true);
    wp_enqueue_script('fancyboxjs');

    wp_enqueue_script('jquery-ui-datepicker');

    // Accordion
    wp_enqueue_script('jquery-ui-accordion');
    // Tabs
    wp_enqueue_script('jquery-ui-tabs');

    wp_register_script('kv-scripts', THEME_URL . '/kv-scripts.js', array(
        'jquery',
        'jquery-ui-datepicker'
    ), '1.0', true);
    wp_enqueue_script('kv-scripts');
    wp_register_script('google-map-init', THEME_URL . '/js/google-maps.js', array('jquery'), '1.0', false);
    wp_register_script('google-place', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBfhbrgTxHeb88BDA1ZoJBq--ZfwAPeYc8&libraries=places', array('jquery'), '1.0', false);

    if (!is_front_page()) {
        wp_enqueue_script('google-place');
        wp_enqueue_script('google-map-init');
        wp_enqueue_script('datedropper_js');
    }

    // wp_deregister_script('tgdprc_mCustomScroller_scripts');
    // wp_enqueue_script('tgdprc_mCustomScroller_scripts', 'https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js', array(), TGDPRC_VERSION);

}
add_action('wp_enqueue_scripts', 'theme_files');

add_action('wp_head', 'cf_preload_fonts', 0);
function cf_preload_fonts() { ?>
    <link rel="preload" as="font" href="<?php echo home_url() ?>/wp-content/themes/unforgettable/css/bodoni-bold.woff" crossorigin />
    <link rel="preload" as="font" href="<?php echo home_url() ?>/wp-content/themes/unforgettable/css/bodoni-medium.woff" crossorigin />
    <?php
}

// Enable Classic Editor
add_filter('use_block_editor_for_post', '__return_false', 10);

// Theme Options
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Theme Options',
        'menu_title' => 'Theme Options',
        'menu_slug' => 'theme-pptions',
        'capability' => 'edit_posts',
        'redirect' => false,
    ));
    acf_add_options_page(array(
        'page_title' => 'Locations',
        'menu_title' => 'Locations',
        'menu_slug' => 'schema-location',
        'capability' => 'edit_posts',
        'redirect' => false,
    ));

}

// Register Sidebar
add_action('widgets_init', 'unforgettable_widgets_init');
function unforgettable_widgets_init()
{
    $sidebar_attr = array(
        'name' => '',
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widgettitle">',
        'after_title' => '</h2>',
    );
    $sidebar_id = 0;
    $gdl_sidebar = array("Footer 1", "Footer 2", "Footer 3", "Footer 4", "Header Right");
    foreach ($gdl_sidebar as $sidebar_name) {
        $sidebar_attr['name'] = $sidebar_name;
        $sidebar_attr['id'] = 'custom-sidebar' . $sidebar_id++;
        register_sidebar($sidebar_attr);
    }
}

// Register Navigation
function register_menu() {
    register_nav_menu('main-menu-new', __('Main Menu'));
    register_nav_menu('mobile-main-menu', __('Mobile Main Menu'));
}

add_action('init', 'register_menu');

// Image Crop
function codex_post_size_crop()
{
    add_image_size("destnation_boxes_image", 402, 402, true);
    add_image_size("article_image", 648, 432, true);
    add_image_size("detail_section", 641, 340, true);
    add_image_size("blog_sec_img", 402, 402, true);
    add_image_size("cruise_thumb", 350, 190, true);
    add_image_size("press", 640, 190, true);
}

add_action("init", "codex_post_size_crop");

// Product Post Type
add_action('init', 'products_post_type');
function products_post_type()
{
    add_theme_support('post-thumbnails');
    register_post_type('products', array(
        'labels' => array(
            'name' => __('Products'),
            'singular_name' => __('Product'),
        ),
        'supports' => array(
            'title',
            // 'editor',
            'thumbnail',
        ),
        'public' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'query_var' => true,
        'has_archive' => true,
        //'rewrite' => array('slug' => 'products'),
        'rewrite' => array('slug' => false, 'with_front' => false),
        // 'rewrite' => array('slug' => '[^/]+/products/([^/]+)/?$'),
        //'rewrite' => array('slug' => '%product_category%', 'with_front' => false),
        'menu_icon' => 'dashicons-cart',
    ));

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Product Categories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Product Category', 'taxonomy singular name', 'textdomain'),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        // 'rewrite'           => array( 'slug' => 'product-category' ),
        // 'rewrite'           => array( 'slug' => false ),
        'rewrite' => array(
            'slug' => 'product-category',
            'with_front' => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('product_category', array('products'), $args);
    flush_rewrite_rules();
}

// Ship Information Post type
add_action('init', 'ship_information_post_type');
function ship_information_post_type()
{
    register_post_type('ship_information', array(
        'labels' => array(
            'name' => __('Ship Information'),
            'singular_name' => __('Ship Information'),
        ),
        'supports' => array(
            'title',
            //'editor',
            'thumbnail'
        ),
        'public' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-performance',
    ));
    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Ship Categories', 'taxonomy general name', 'textdomain'),
        'singular_name' => _x('Ship Category', 'taxonomy singular name', 'textdomain'),
    );
    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        // 'rewrite'           => array( 'slug' => 'product-category' ),
        // 'rewrite'           => array( 'slug' => false ),
        'rewrite' => array(
            'slug' => 'ship-category',
            'with_front' => false,
            'hierarchical' => true,
        ),
    );

    register_taxonomy('ship_category', array('ship_information'), $args);
    flush_rewrite_rules();
}

//New Availability TAble
// if (@$_GET['dev'] == 1) {
//     add_shortcode('availability_table', 'codex_availability_table_test');
// }

add_filter("gform_confirmation_anchor_1", '__return_false');

function misha_my_load_more_scripts() {

    // register our main script but do not enqueue it yet
    wp_register_script('my_loadmore', get_stylesheet_directory_uri() . '/js/myloadmore.js', array('jquery'), false, true);
    wp_enqueue_script('my_loadmore');

    wp_enqueue_script('cookieBar');
}

//add_action( 'wp_enqueue_scripts', 'misha_my_load_more_scripts' );

//-------------------------------------------------------------------------------

add_action('wp_ajax_load_posts_by_ajax', 'load_posts_by_ajax_callback');
add_action('wp_ajax_nopriv_load_posts_by_ajax', 'load_posts_by_ajax_callback');
function load_posts_by_ajax_callback()
{
    check_ajax_referer('load_more_posts', 'security');
    $paged = $_POST['page'];
    $args = array(
        'post_type' => 'products',
        'post_status' => 'publish',
        'posts_per_page' => '3',
        'paged' => $paged,
    );
    $products = new WP_Query($args);
    if ($products->have_posts()):
        ?>
        <?php while ($products->have_posts()): $products->the_post(); ?>
        <!-- Item -->
        <?php get_template_part('item', 'loop'); ?>
        <!-- Item END -->
    <?php endwhile; ?>
        <?php wp_reset_postdata(); ?>
    <?php
    endif;
    wp_die();
}

// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js($src)
{
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }

    return $src;
}

add_filter('style_loader_src', 'vc_remove_wp_ver_css_js', 9999);
add_filter('script_loader_src', 'vc_remove_wp_ver_css_js', 9999);


// Add Additional Function in ACF
add_action('acf/render_field_settings', 'my_admin_only_render_field_settings');
function my_admin_only_render_field_settings($field) {
    // echo "<pre>";
    // print_r($field);
    // echo "</pre>";
    acf_render_field_setting($field, array(
        'label' => __('Read Only?', 'acf'),
        'instructions' => '',
        'name' => 'readonly',
        'type' => 'true_false',
        'ui' => 1,
    ), true);

    acf_render_field_setting($field, array(
        'label' => __('Custom Class'),
        'instructions' => __('Enter custom class'),
        'name' => 'exclude_words',
        'type' => 'text',
        'class' => 'tegs',
        // 'class'        => $field['exclude_words'],
    ));
}

function my_acf_load_field($field) {

    // make required
    $field['required'] = true;

    // customize instructions with icon
    $field['instructions'] = '<i class="helppp" title="Instructions here"></i>';

    // customize wrapper element
    $field['wrapper']['id'] = 'my-custom-id';
    $field['wrapper']['data-jsify'] = '123';
    $field['wrapper']['title'] = 'Text here';

    // return
    return $field;

}

add_filter('acf/load_field', 'my_admin_only_load_field', 99);
function my_admin_only_load_field($field)
{
    if (array_key_exists('exclude_words', $field)) {
        $field['class'] = $field['exclude_words'];
    }

    return $field;
}

function admin_js() {
    // wpb_custom_cron_func();
    $rate_conversion = get_option('cur_rate_conversion');
    ?>
    <script type="text/javascript">
        jQuery(function ($) {
            $(".curr_rate_gbp").val(<?=$rate_conversion['gbp'];?>);
            $(".curr_rate_aud").val(<?=$rate_conversion['aud'];?>);
            $(".curr_rate_usd").val(<?=$rate_conversion['usd'];?>);
            console.log(11);
            $('#acf-field_5cc2152a369f8').on('change', function () {
                console.log(15);
                var term_tax_id = $(this).val();
                $.ajax({
                    method: 'POST',
                    url: <?=json_encode(admin_url('admin-ajax.php'));?>,
                    data: {action: 'get_term_ship', term_id: term_tax_id},
                    dataType: 'html',
                    success: function (res) {
                        console.log(res);
                        $('#acf-field_5dd6823e91cbe').html(res).select2();
                    }
                })
            });
        });
    // End

    </script>
    <?php
}

add_action('admin_head', 'admin_js');

//------------------ACF Schema Field Maping----------------

function acf_load_select_schema_city_field_choices($field) {
    global $post;
    /*echo '<pre>';
    print_r($field);
    echo '</pre>';*/
    // reset choices
    $field['choices'] = array();

    // if has rows
    if (have_rows('location_data', 'option')) {
        //echo get_post_meta($post->ID, 'select_schema_city', true);
        if (!empty(get_post_meta($post->ID, 'select_schema_city', true))) {
            $field['default_value'] = array(get_post_meta($post->ID, 'select_schema_city', true));
        }

        $field['choices'][''] = 'Select Location';

        // while has rows
        while (have_rows('location_data', 'option')) {
            // instantiate row
            the_row();

            // vars
            $value = str_replace(' ', '_', get_sub_field('schema_title'));
            $value = sanitize_key($value);
            $label = get_sub_field('schema_title');

            // append to choices
            $field['choices'][$value] = $label;
        }
    }

    // return the field
    return $field;
}

add_filter('acf/load_field/name=select_schema_city', 'acf_load_select_schema_city_field_choices', 999);

// Add scripts to wp_head()
function location_schema()
{
    //<!----------------Schema Start------------->
    $page_id = get_the_ID();

    $href_url = get_field('select_schema_city', $page_id);
    if (empty($href_url)) {
        $href_url = array('0' => 'croatia');
    }

    if (have_rows('location_data', 'option')): ?>

        <?php while (have_rows('location_data', 'option')): the_row(); ?>

            <?php $value = str_replace(' ', '_', get_sub_field('schema_title'));
            // print_r($href_url).'<br>';
            // foreach ($href_url as $href_urls) {
            $values = strtolower($value);

            if (!in_array($values, $href_url)) {
                continue;
            }

            printf('<script type="application/ld+json">{"@context":"http://schema.org","@type":"Place","name":"%s","publicAccess":true,"isAccessibleForFree":true,"sameAs":["%s","%s"]}</script>', get_sub_field('schema_title'), get_sub_field('schema_wikipedia_url'), get_sub_field('schema_wikidata_url'));
            // }

            ?>
        <?php endwhile; ?>

    <?php endif;

    //<!----------------Schema END--------------->
}

add_action('wp_head', 'location_schema');

// Add scripts to for home shema
function homeschema()
{

    if (is_front_page()) {
        //<!----------------Schema Start------------->
        ?>

        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "Organization",
                "name": "Cruise Croatia",
                "legalName": "Unforgettable Travel Company",
                "url": "https://cruisecroatia.com/",
                "logo": "https://cruisecroatia.com/wp-content/uploads/2019/04/logo.png",
                "foundingDate": "2019",
                "founders": [
                    {
                        "@type": "Person",
                        "name": "Graham Carter"
                    }
                ],
                "address": {
                    "@type": "PostalAddress",
                    "streetAddress": "5th Floor, 649 Mission Street",
                    "addressLocality": "San Francisco",
                    "addressRegion": "CA",
                    "postalCode": "94105",
                    "addressCountry": "USA"
                },
                "contactPoint": {
                    "@type": "ContactPoint",
                    "contactType": "customer support",
                    "telephone": "[+1-415-685-0816]",
                    "email": "info@cruisecroatia.com"
                },
                "sameAs": [
                    "https://www.facebook.com/croatiancruises",
                    "https://www.instagram.com/croatian_cruises"
                ]
            }
        </script>
        <?php

    }

    //<!----------------Schema END--------------->
}

add_action('wp_head', 'homeschema');

//-------------------- Product Schema START -----------------------------------

// Add scripts to for home shema
function product_schema()
{
    global $post;
    if (is_single($post->ID) && $post->post_type == 'products') {
        $product_short_description = get_field('description', $post->ID);
        if (strlen($product_short_description) > 70) {
            $product_short_description = substr($product_short_description, 0, 70) . '...';
        }

        $post_image = get_field('product_image_new', $post->ID);
        $image = wp_get_attachment_url($post_image);
        $product_price = get_field('price', $post->ID);
        $date_end = get_field('duration', $post->ID);
        $link = get_permalink($post->ID);
        // echo "<pre>";
            // print_r($post);
        // echo "</pre>";
        printf('<script type="application/ld+json">
    {"@context":"https://schema.org/","@type":"Product","name":"%s","image":"%s","description":"%s","brand":{"@type":"Thing","name":"Cruise Croatia"},"offers":{"@type":"Offer","priceCurrency":"USD","price":"%d","priceValidUntil":"%s","itemCondition":"http://schema.org/NewCondition","availability":"http://schema.org/InStock","seller":{"@type":"Organization","name":"Cruise Croatia"},"url":"%s"}}
    </script>', $post->post_title, $image, $product_short_description, $product_price['product_regular_price'], $date_end, $link);
    }


}

//add_action('wp_head', 'product_schema');

//-------------------- Product Schema END -------------------------------------


add_filter('parse_query', 'tsm_convert_id_to_term_in_query');

function tsm_convert_id_to_term_in_query($query) {
    global $post_type, $pagenow;

    if ($pagenow == 'edit.php' && $post_type == 'products' && isset($_GET['ship_filter']) && $query->query['post_type'] == 'products') {
        $query->query_vars['meta_key'] = 'ship';
        $query->query_vars['meta_value'] = $_GET['ship_filter'];
    }
}

add_action('login_init', 'wpse187831_redir_loggedin');
function wpse187831_redir_loggedin() {
    global $action;

    if ('logout' === $action || !is_user_logged_in()) {
        return;
    }

    wp_redirect(apply_filters(
        'wpse187831_loggedin_redirect', admin_url(), wp_get_current_user()), 302);
    exit;
}

add_shortcode('cst-breadcrumbs', 'codex_generate_custom_breadcrumbs');
function codex_generate_custom_breadcrumbs($atts) {
    ob_start();
    wp_reset_postdata();
    extract(shortcode_atts(array(
        'id' => get_the_ID(),
        'slug' => false,
    ), $atts));

    ?>
    <?php if (!empty($id)): ?>
    <div class="cst-breadcrumbs">
        <ul>
            <li class="home_bc"><a href="<?php echo home_url(); ?>"><i class="fa fa-home"></i></a></li>
            <?php if (have_rows('custom_breadcrumb', $id)) : ?>
                <?php while (have_rows('custom_breadcrumb', $id)) : the_row(); ?>

                    <?php
                    $value = get_sub_field('custom_breadcrumb_link');
                    $post_id = $value->ID;
                    $breadcrumb_title = $value->post_title;
                    $breadcrumb_slug = ucfirst(str_replace('-', ' ', $value->post_name));
                    $page_link = get_permalink($post_id);
                    ?>
                    <?php if ($slug == false): ?>
                        <li><a href="<?php echo $page_link; ?>"><?php echo $breadcrumb_title; ?></a></li>
                    <?php else: ?>
                        <li><a href="<?php echo $page_link; ?>"><?php echo $breadcrumb_slug; ?></a></li>
                    <?php endif; ?>

                <?php endwhile; ?>
            <?php endif; ?>
            <li><span><?php echo get_the_title($id); ?></span></li>
        </ul>
    </div>
<?php endif; ?>
    <?php
    wp_reset_postdata();

    return '' . ob_get_clean();
}

function my_acf_google_map_api($api) {
    $api['key'] = 'AIzaSyCrCSTP04O3Cd9W2wdHD2aooqjPiyy56e0';
    return $api;
}

if (!is_front_page()) {
    add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');
}

function my_theme_custom_upload_mimes($existing_mimes) {
    $existing_mimes['svg'] = 'image/svg+xml';
    $existing_mimes['webp'] = 'image/webp';

// Return the array back to the function with our added mime type.
    return $existing_mimes;
}

add_filter('mime_types', 'my_theme_custom_upload_mimes');

function my_custom_mime_types($mimes) {

// New allowed mime types.
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    $mimes['doc'] = 'application/msword';
    $mimes['webp'] = 'image/webp';

// Optional. Remove a mime type.
    unset($mimes['exe']);

    return $mimes;
}

add_filter('upload_mimes', 'my_custom_mime_types');
// ========================================================

// Review Post type
add_action('init', 'reviews_post_type');
function reviews_post_type()
{
    register_post_type('reviews', array(
        'labels' => array(
            'name' => __('Reviews'),
            'singular_name' => __('Reviews')
        ),
        'supports' => array(
            'title',
            'editor',
            //'thumbnail'
        ),
        'public' => true,
        'hierarchical' => false,
        'show_ui' => true,
        'query_var' => true,
        'menu_icon' => 'dashicons-testimonial'
    ));
}

// Feefo Review Button
//add_action('admin_menu', 'add_sub_menu');
function add_sub_menu()
{
    add_submenu_page(
        'edit.php?post_type=reviews',
        'Reviews', /*page title*/
        'Fetch Reviews', /*menu title*/
        'manage_options', /*roles and capabiliyt needed*/
        'wnm_fund_set',
        'review_init' /*replace with your own function*/
    );
}

function review_init()
{
    // Render our theme options page here ...
    echo "<div>";
    echo "<form action='" . site_url('/feefo-review.php') . "' method='get' id='form1'>";
    echo '<h3>Fetch new reviews from Feefo</h3>';
    echo "<button class='mybtn hvr-hollow' type='submit' form='form1' value='Submit'>Fetch Reviews</button>";
    echo "</form>";
    echo "</div>";
}


add_action('wp_ajax_newbid', 'newbid_ajax');
add_action('wp_ajax_nopriv_newbid', 'newbid_ajax');
function newbid_ajax()
{
    $postid = $_POST['postid'];
    $rev_id = $_POST['rev_id'];
    $review_checked = $_POST['review_checked'];

    if ($review_checked == 1) {
        add_post_meta($postid, 'review_checked', $rev_id);
        add_post_meta($rev_id, 'product_id', $postid);
    } else {
        delete_post_meta($postid, 'review_checked', $rev_id);
        delete_post_meta($rev_id, 'product_id', $postid);
    }
    exit();
}


// Shortcode for single product reviews
// Review Shortcode
//add_shortcode('single-product-reviews', 'single_product_review');
function single_product_review()
{
    ob_start();
    ?>
    <div class="singal-product-reviews">
        <?php
        global $post;
        $post_id = $post->ID;
        $post_arr = get_post_meta($post_id, 'review_checked');
        // echo "<pre>";
        // print_r($post_arr);
        $args = array(
            'post_type' => 'reviews',
            'post__in' => $post_arr,
            'posts_per_page' => 15

        );
        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            $custom = get_post_custom($post->ID);
            $rating = get_post_meta(get_the_ID(), 'stars', true);
            ?>
            <div class="item">
                <div class="review">
                    <a href="<?php echo get_post_meta(get_the_ID(), 'review_url', true) ?>" target="_blank">
                        <div class="rating"><span class="star star-<?php echo $rating ?>"></span></div>
                        <div class="title"><?php echo mb_strimwidth(get_the_title(), 0, 30, '...'); ?></div>
                        <div class="excerpt"><?php echo mb_strimwidth(get_the_content(), 0, 100, '...'); ?></div>
                        <div class="customer-name"><?php echo get_post_meta(get_the_ID(), 'author_name', true) ?> -
                            <span class="time"><?php echo human_time_diff(get_the_time('U'), current_time('timestamp')) . ' ago'; ?></span>
                        </div>
                    </a>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <?php
    wp_reset_postdata();

    return '' . ob_get_clean();
}

add_filter('clean_url', function ($url) {
    if (FALSE === strpos($url, 'https://www.google.com/recaptcha/api.js')) { // not our file
        return $url;
    }
    // Must be a ', not "!
    return "$url' defer='defer";
}, 11, 1);

// Prevent Form Submission for bots
add_filter('gform_validation', 'custom_validation');
function custom_validation($validation_result)
{
    $form = $validation_result['form'];
    //finding Field with ID of 1 and marking it as failed validation
    foreach ($form['fields'] as &$field) {
        //NOTE: replace 1 with the field you would like to validate
        if ($field->cssClass == 'no-bots') {
            $zip_val = rgpost("input_" . $field->id);
            if (!empty($zip_val)) {
                $validation_result['is_valid'] = false;
                $field->failed_validation = true;
                $field->validation_message = 'This field is invalid!';
                break;
            }
        }
    }

    //Assign modified $form object back to the validation result
    $validation_result['form'] = $form;
    return $validation_result;
}


add_action('gform_pre_submission_2', 'pre_submission_currency_handler');
function pre_submission_currency_handler($form)
{
    if (!empty(rgpost('input_35'))) {
        $_POST['input_35'] = strtoupper($_POST['input_35']);
    } else {
        $_POST['input_35'] = "EUR";

    }
}

// Disables the block editor from managing widgets in the Gutenberg plugin.
add_filter( 'gutenberg_use_widgets_block_editor', '__return_false' );

// Disables the block editor from managing widgets.
add_filter( 'use_widgets_block_editor', '__return_false' );

add_shortcode('itinerary_items', 'cf_itinerary_items_shortcode');
function cf_itinerary_items_shortcode() {
    ob_start();
?>
    <div id="itinerary_search">
    <form id="frm_itinerary">
        <input type="text" name="it_dt" placeholder="On any date">
        <input type="number" name="it_budget" placeholder="On any budget">
        <input type="hidden" name="action" value="it_items">
        <button type="button">Search Cruises</button>
    </form>
    </div>
    <section class="full-section product-listing">
        <div class="listing-wrapper itinerary_items"><ul></ul></div>
    </section>
    <script type="text/javascript">
    jQuery(function($) {
        // $('[name="it_dt"]').datepicker({
        //     dateFormat: "dd-M-yy",
        //     changeMonth: true,
        //     changeYear: true,
        //     showOtherMonths: true,
        //     selectOtherMonths: true,
        //     // maxDate: max_date,
        //     // minDate: min_date,
        //     // yearRange: "-100:+6",
        //     showButtonPanel: true,
        //     closeText: 'Reset',
        // });
        function currentDate() {
            var d = new Date(),
                month = '' + (d.getMonth() + 1),
                day = '' + d.getDate(),
                year = d.getFullYear();

            if (month.length < 2)
                month = '0' + month;
            if (day.length < 2)
                day = '0' + day;

            return [month, day, year].join('/');
        }
        let today = currentDate();
        if ($('[name="it_dt"]').length == 1) {
            $('[name="it_dt"]').addClass('dateDropper').dateDropper({
                'large': 1,
                'minDate': today,
                'largeDefault': 1,
                'format': 'd/m/Y'
            });
        }

        // Ajax Search
        $('#frm_itinerary button').on('click', function() {
            $.ajax({
                url: '<?php echo admin_url( 'admin-ajax.php' ); ?>',
                type: "POST",
                data: $('#frm_itinerary').serialize(),
                success: function(data) {
                    // $('.a-loading-wrap').fadeOut();
                    if( data == 'error' ) {
                        alert('Error: invalid request');
                    }
                    else {
                        $('.itinerary_items ul').html(data);
                    }
                },
                error: function(){
                    // $('.a-loading-wrap').fadeOut();
                }
            })
        })
    })
    </script>
<?php
    return ob_get_clean();
}

add_action('wp_ajax_it_items', 'ajax_it_items_callback');
add_action('wp_ajax_nopriv_it_items', 'ajax_it_items_callback');
function ajax_it_items_callback() {
    //
    if( @$_POST['action'] !== 'it_items' )
        die('error');

    // if( empty(@$_POST['vehicle_brands']) )
    //     die('error');

    $args = array(
        'post_type'   => 'products',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );
    print_r($_POST);
    if( isset($_POST['it_budget']) ) {
        $args['meta_query'][0] = array(
                'key'       => 'price_regular_price', 
                'value'     => $_POST['it_budget'], 
                'compare'   => '>=', 
            );
    }
    // echo '<pre>';
    // print_r($args);
    // echo '</pre>';
    $prod_query = new WP_Query($args);

    if ($prod_query->have_posts()):
?>
    <?php while ($prod_query->have_posts()): $prod_query->the_post(); ?>
    <!-- Item -->
    <?php get_template_part('item', 'loop'); ?>
    <!-- Item END -->
    <?php endwhile; ?>
    <?php wp_reset_postdata(); ?>
<?php
    else:
        die('no listing found!');
    endif;

    wp_die();
}

add_action( 'wp_ajax_contact_quote', 'wpajax_contact_quote_callback' );
add_action( 'wp_ajax_nopriv_contact_quote', 'wpajax_contact_quote_callback' );
function wpajax_contact_quote_callback() {
    // print_r($_POST['extensions'][]);
    get_template_part('contact_quote');
    // pre($_POST, 1);
    die;
}

    // add action for logged in users
    add_action('wp_ajax_availability_table', 'availability_table_show_more_fn');
    // add action for non logged in users
    add_action('wp_ajax_nopriv_availability_table', 'availability_table_show_more_fn');
    
    function availability_table_show_more_fn() {
       if( have_rows('availability_table', $_POST['post_id']) ):
                    $n = 0;
                    while( have_rows('availability_table',$_POST['post_id']) ) : the_row();
                            $price = get_sub_field('price');
                        ?>
                        <div class="accordion-set">
                            <?php $avl = get_sub_field('availability');
                            if ($avl == 'Sold Out') 
                                echo '<div class="accordion-head disabled">';
                              else 
                                echo '<div class="accordion-head">';?>
                                <div class="col ac-date"><?php echo get_sub_field('date'); ?></div>
                                <input type="hidden" value="<?php echo get_sub_field('date'); ?>" class="date<?php echo $n ?>">



                                <div class="col ac-price"><?php echo _currency_format($price, true); ?></div>
                                <input type="hidden" value="<?php echo get_sub_field('price'); ?>" class="price<?php echo $n ?>">
                                <div class="col ac-avl"><?php echo $avl; ?></div>
                                <input type="hidden" value="<?php if ($avl == 'Available') echo 1; elseif ($avl == 'Limited Cabins') echo 2; elseif ($avl == 'Sold Out') echo 3; ?>" class="avl<?php echo $n ?>">
                            </div>
                            <div class="accordion-body">
                                <div class="accordion_cover">
                                    <div class="cabines-area styler">
                                        <label for="<?php echo $n; ?>">Select Cabin</label>
                                        <select class="cabin-select" id="<?php echo $n; ?>">
                                            <option>No of Cabins</option>
                                            <!-- loop for cabins -->
                                            <?php for ($i=1; $i < 11 ; $i++) { ?>
                                                <!-- cabin option value -->
                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                            <?php } ?>
                                        </select>
                                    <span class="text-danger cab-val"></span>
                                    </div>
                                    <div class="passenger-area styler">
                                        <label for="<?php echo $n; ?>">Select Passenger</label>
                                        <select class="passenger-select" id="<?php echo $n; ?>">
                                            <option>No of Passengers</option>
                                        </select>
                                        <span class="text-danger pass-val"></span>
                                    </div>
                                    <div class="booking-btn styler"><a class="btn btn-green" href="javascript:;">Check Availability & Book</a></div>
                                </div>
                            </div>
                        </div>
                            <?php
                            $n++;
                        endwhile;

        // No value.
                    else :
                        echo 'Sorry! No details matching your repeater was found.<br>';
                    endif;
    } // end function availability_table_show_more
