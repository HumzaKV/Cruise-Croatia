<?php get_header();
/* Template Name: New Design */
$image_desktop = get_field('image_desktop');
$image_mobile  = get_field('image_mobile');
$title    	   = get_field('title');
$tag    	   	= get_field('tag');
$bottom    	   = get_field('margin_bottom');

$image_id = attachment_url_to_postid($image_desktop);
$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
$image_idm = attachment_url_to_postid($image_mobile);
$image_altm = get_post_meta($image_idm, '_wp_attachment_image_alt', TRUE);

if($image_desktop):
?>
	<section class="home-slide styled full-section <?php if($image_mobile){ echo 'mobile-hero-available'; }  ?>" style="margin-bottom:<?php echo $bottom; ?>;">
		<div class="silder-cover">
			<div class="padding" style="padding-top:31.25%"></div>	
			<div class="slide-bg kv-layzy" data-background="<?php echo $image_desktop; ?>" role="img" aria-label="<?php echo $image_alt; ?>">
				<div class="container">
					<?php
						if($title){ printf('<%s>%s</%s>', $tag, $title, $tag); }
					?>
				</div>
			</div>
		</div>
	</section>
<?php endif;

if($image_mobile): ?>
	<section id="home-slider" class="home-slide full-section mobile-hero-image" style="margin-bottom:<?php echo $bottom; ?>;">
		<div class="silder-cover">
			<div class="padding" style="padding-top: 70.51%"></div>	
			<div class="slide-bg kv-layzy" data-background="<?php echo $image_mobile ?>" role="img" aria-label="<?php echo $image_altm; ?>">
				<div class="container">
					<?php
						if($title){ printf('<h2>%s</h2>', $title); }
					?>
				</div>
			</div>
		</div>
	</section>
<?php endif;
$banner_links = get_field('banner_links');
if ($banner_links):
    echo '<div class="banner_links full-section" style="margin: 0px;">';
    echo '<div class="container">';
    echo '<ul>';
    $active_link = get_page_link(get_field('select_active_page'));
    foreach ($banner_links as $key => $b) {
    $label  = $b['label'];
    $link   = $b['link'];
        if ($link && $label):
            $active = '';
            if ($active_link === $link) {
                $active = 'active';
            }
            echo '<li class="' . $active . '">';
            echo sprintf('<a href="%s">%s</a>', $link, $label);
            echo '</li>';
        endif;
    }
    echo '</ul>';
    echo '</div>';
    echo '</div>'; //banner_links
endif;

// Breadcrumb
if ( function_exists('yoast_breadcrumb') ) {
  if (!is_front_page()){
	echo '<div class="breadcrumb-wrapper full-section">';
		echo '<div class="container">';
  			yoast_breadcrumb( '<p id="breadcrumbs">','</p>' );
		echo '</div>';
	echo '</div>';
  }
}

	if( get_field('page_builder') ){
	$page_builder = get_field('page_builder');
	foreach ($page_builder as $key => $section) {
		include('inc/inc-'.$section['acf_fc_layout'].'.php');
	}
}
else
{
	echo '<div class="container" style="text-align:center;">';
		echo '<h2 style="margin:20px 0 20px;display:inline-block;">';
			echo 'Fields Not Founds';
		echo '</h2>';
	echo '</div>';	
}
?>
<script>
jQuery(function($) {
	let UFGStorage = JSON.parse( localStorage.getItem('UFGStorage') )
	UFGStorage['action'] = 'contact_quote';
	$.ajax({
		url: tgdprc_frontend_js.ajax_url,
		method: 'POST',
		data: UFGStorage,
		success: function(res) {
			console.log(res)
			$('.inquire_form_new').html(res)
		},
		error: function(res) {
			console.log(res)
		}
	});

        $("#input_20_32").val( UFGStorage['date'] );
        $("#input_20_33").val( UFGStorage['price'] );
        $("#input_20_34").val( UFGStorage['avl'] );
        $("#input_20_35").val( UFGStorage['cabin'] );
        $("#input_20_31").val( UFGStorage['passenger'] );


})
</script>

<?php get_footer(); ?>