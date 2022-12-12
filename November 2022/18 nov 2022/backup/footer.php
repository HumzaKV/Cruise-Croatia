<div class="footer-wrapper full-section">
    <div class="container newsletter">
        <h4>Sign up to receive our news</h4>
        <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
    </div>
    <div class="container foo-one">
        <div class="footer-col-1">
            <?php dynamic_sidebar('Footer 1'); ?>
        </div>
        <div class="footer-col-2">
            <?php dynamic_sidebar('Footer 2'); ?>
        </div>
        <div class="footer-col-3">
            <?php dynamic_sidebar('Footer 3'); ?>
        </div>
    </div>
    <div class="container foo-two">
        <div class="footer-col-5">
            <div class="footer-logo">
                <?php
                $bottom_logo_image = get_field('bottom_logo_image', 'option');
                if ($bottom_logo_image) {
                    echo '<div class="bottom-logo full-section">';
                    echo '<img src="' . $bottom_logo_image . '" alt="Brands" width="314" height="60"/>';
                    echo '</div>';
                }
                ?>
            </div>
        <?php
            $copyright_text = get_field('copyright_text', 'option');
            if ($copyright_text) {
                echo '<div class="copyright-text">';
                echo '<p>' . $copyright_text . '</p>';
                echo '</div>';
            }
            ?>
            <!-- SOCIAL NETWORKS -->    
            <div class="col-2">
                <div class="social-icons">
                    <?php
                    $social_icons = get_field('social_icons', 'option');
                    if ($social_icons) {
                        echo '<ul>';
                        foreach ($social_icons as $social_icon) {
                            echo '<li><a href="' . $social_icon['add_link'] . '" target="_blank"><i class="fa ' . $social_icon['add_fa_icon_code'] . '"></i></a></li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
            </div>
            <!-- SOCIAL NETWORKS -->
    </div>
</div>
<script type="text/javascript">
    //Smooth Scroll
    var $ = jQuery;
    $('a[href*="#"]').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 170
        }, 500);
    });
</script>
<?php
echo '</div>'; //Main Wrapper
wp_footer(); ?>
<script>
    jQuery(document).on('change', 'input[name=advanced_cookie_control_check]', function () {
        if (jQuery(this).val() != 'block-all') {
            console.log('Checked Strickly Neccessary');
            jQuery('input[name=advanced_cookie_control_check][value=allow-1]').prop('checked', true);
        }
    });

    jQuery(document).ajaxComplete(function (event, xhr, settings) {
        let ajax_data =
            JSON.parse('{"' + decodeURI(settings.data).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
        if (ajax_data.action == "tgdprc_advance_cookie_consent_storage") {
            jQuery('.tgdprc_info_close_button').click();
            jQuery('.tgdprc-cookie-bar-info-confirm').click();
        }
    });
    jQuery(".gfield_captcha").attr("rel","nofollow");
</script>
</body>
</html>