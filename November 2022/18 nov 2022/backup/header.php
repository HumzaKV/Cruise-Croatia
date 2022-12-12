<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php wp_title(); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="facebook-domain-verification" content="itb5gobcp8rp3k8uy3uddnaoj4clpa" />
    <?php
    $favicon = get_field('favicon_image', 'option');
    if ($favicon) {
        echo '<link rel="shortcut icon" href="' . $favicon . '" type="image/x-icon" />';
    } else {
        echo '<link rel="shortcut icon" href="' . get_stylesheet_directory_uri() . '/images/favicon.png" type="image/x-icon" />';
    }
    gravity_form_enqueue_scripts(2, true);
    ?>
    <?php wp_head(); ?>
    <?php
    $faqs = get_field('faqs');
    if ( ! empty($faqs)) {
        $faqs_generator = array();
        foreach ($faqs as $faq) {
            $obj               = [
                "@type"          => "Question",
                "name"           => $faq['title'],
                "acceptedAnswer" => [
                    "@type" => "Answer",
                    "text"  => $faq['content']
                ]
            ];
            $faqs_generator [] = $obj;
        }
        $script = '<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": ' . json_encode($faqs_generator) . '
}
</script>';
        echo($script);
    } ?>
</head>
<body <?php body_class(); ?>>
<!--Main Wrapper-->
<div class="main-wrapper full-section">

<div class="header-wrapper new_head full-section">
    <div class="menu-button-new">Menu</div>
    <!--Header-->
    <div class="header-cover full-section">
        <div class="container">
            <div class="header__inn">
                <div class="logo-wrapper">
                    <?php
                    $logo = get_field('logo_image', 'option');
                    echo '<a href="' . home_url('/') . '">';
                    if ($logo) {
                        echo '<img src="' . $logo . '" alt="Cruise Croatia" width="128" height="49"/>';
                    } else {
                        echo '<img src="' . get_stylesheet_directory_uri() . '/images/logo.png" alt="Cruise Croatia" />';
                    }
                    echo '</a>';
                    ?>
                </div> <!-- logo-wrapper -->
                <div class="details">
                    <div class="number_currency">
                        <div class="numbers-switcher">
                            <?php
                            $cf_curr_currency = cf_curr_currency();
                            $gbp = get_field('gb_number', 'option');
                            $usa = get_field('us_number', 'option');
                            $aud = get_field('au_number', 'option');
                            $hours = get_field('opening_hours', 'option');

                                if($cf_curr_currency == 'GBP' || $cf_curr_currency == 'EUR'){
                                    echo '<a href="tel:'.$gbp.'">'.$gbp.'</a>';
                                } elseif($cf_curr_currency == 'AUD') {
                                    echo '<a href="tel:'.$aud.'">'.$aud.'</a>';
                                } elseif($cf_curr_currency == 'USD') {
                                    echo '<a href="tel:'.$usa.'">'.$usa.'</a>';
                                }
                            ?>
                        </div> <!-- numbers-switcher -->

                        <div class="currency-switcher">
                            <div class="current-status">
                                <?php
                                if ($cf_curr_currency == 'GBP') {
                                    $flag = '<img src="'. get_template_directory_uri() .'/images/unitedkingdim.png">';
                                } elseif ($cf_curr_currency == 'EUR') {
                                    $flag = '<img src="'. get_template_directory_uri() .'/images/europe.png">';
                                } elseif ($cf_curr_currency == 'AUD'){
                                    $flag = '<img src="'. get_template_directory_uri() .'/images/aust.png">';
                                } elseif ($cf_curr_currency == 'USD'){
                                    $flag = '<img src="'. get_template_directory_uri() .'/images/unitedstate.png">';
                                }
                                echo $flag . '<i class="fa fa-angle-down"></i>'; ?>
                            </div>

                            <ul class="auto_switcher right">
                                <li>
                                    <a data-value="USD" class="auto_switcher_link <?php echo(($cf_curr_currency == 'USD') ? 'current' : ''); ?>" href="<?php echo get_permalink() . '?currency=USD'; ?>">USD <i class="fa fa-usd" aria-hidden="true"></i>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/usa-flag.jpg" alt="USA Dollar" width="20" height="11"></a>
                                </li>
                                <li>
                                    <a data-value="EUR" class="auto_switcher_link <?php echo(($cf_curr_currency == 'EUR') ? 'current' : ''); ?>" href="<?php echo get_permalink().'?currency=EUR'; ?>">EUR <i class="fa fa-eur" aria-hidden="true"></i>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/eur-flag.jpg" alt="EUR Euro" width="20" height="11"></a>
                                </li>
                                <li><a data-value="AUD" class="auto_switcher_link <?php echo(($cf_curr_currency == 'AUD') ? 'current' : ''); ?>" href="<?php echo get_permalink() . '?currency=AUD'; ?>">AUD <i class="fa fa-usd" aria-hidden="true"></i>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/aus-flag.jpg" alt="AUD Dollar" width="20" height="11"></a>
                                </li>
                                <li><a data-value="GBP" class="auto_switcher_link <?php echo(($cf_curr_currency == 'GBP') ? 'current' : ''); ?>" href="<?php echo get_permalink() . '?currency=GBP'; ?>">GBP <i class="fa fa-gbp" aria-hidden="true"></i>
                                        <img src="<?php echo get_template_directory_uri(); ?>/images/gbp-flag.jpg" alt="GBP Pound" width="20" height="11"></a>
                                </li>
                            </ul>
                        </div> <!-- currency-switcher -->
                    </div> <!-- number_currency -->
                    <?php if($hours){printf('<div class="we-are">%s</div>', $hours);} ?>

                </div> <!-- details -->
            </div> <!-- header__inn -->
        </div>
    </div>
    <div class="header_cover">
            <?php include (TEMPLATEPATH . '/mega-menu.php' ); ?>
    </div>
</div>