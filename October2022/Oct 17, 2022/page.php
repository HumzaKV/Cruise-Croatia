<?php get_header();
 /* 
 * The default page template
 */
// Hero Image
$hero_image = get_field('desktop_hero_image');
$m_hero_image = get_field('mobile_hero_image');
$options = get_field('content_link');
if($options == 'content'){
?>
<section id="home-slider" class="home-slide styled full-section <?php if($m_hero_image){ echo 'mobile-hero-available'; }  ?>">
	<div class="silder-cover">
		<div id="owl-demo" class="<?php echo count($hero_image) > 1 ? 'owl-carousel banner-carousel' : '' ?>">
			<?php
				
				foreach($hero_image as $h) {
				$image_id = attachment_url_to_postid($h['image']);
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);
			?>

				<div class="item">
				  <?php if($h['image_link']) { ?>
						<div class="slide-bg kv-layzy" data-background="<?php echo $h['image']; ?>" role="img" aria-label="<?php echo $image_alt; ?>">
							<div class="slider-content">
								<div class="container">
									<?php if($h['sub_title']): ?>
									<h3><?php echo $h['sub_title']; ?></h3>
									<?php endif; ?>
									<h1><?php echo $h['main_title']; ?></h1>
									<?php echo $h['slider_content']; ?>
									<a href="<?php echo $h['image_link']; ?>" target="<?php echo $h['link_target']; ?>"><?php echo $h['button_label']; ?></a>
								</div>
							</div>
						</div>
				  <?php } else { ?>
						<div class="slide-bg" style="background-image:url(<?php echo $h['image']; ?>);" role="img" aria-label="<?php echo $image_alt; ?>"></div>
				  <?php } ?>
				</div>	
			<?php } ?>
		</div>
	</div>
<?php
	$banner_links = get_field('banner_links');
	if ($banner_links):
	    echo '<div class="banner_links">';
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
?>
</section>
<?php
} else { ?>
<section id="home-slider" class="home-slide styled full-section <?php if($m_hero_image){ echo 'mobile-hero-available'; }  ?>">
	<div class="silder-cover">
		<div id="owl-demo" class="<?php echo count($hero_image) > 1 ? 'owl-carousel banner-carousel' : '' ?>">
			<?php
				foreach($hero_image as $h){
				$image_id = attachment_url_to_postid($h['image']);
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);?>

				<div class="item">
				  <?php if($h['image_link']) { ?>
				  	<a href="<?php echo $h['image_link']; ?>" target="<?php echo $h['link_target']; ?>">
						<div class="slide-bg" style="background-image:url(<?php echo $h['image']; ?>);" role="img" aria-label="<?php echo $image_alt; ?>"></div>
					</a>
				  <?php } else { ?>
						<div class="slide-bg" style="background-image:url(<?php echo $h['image']; ?>);" role="img" aria-label="<?php echo $image_alt; ?>"></div>
				  <?php } ?>
				</div>
			<?php } ?>
		</div>
	</div>
<?php
	$banner_links = get_field('banner_links');
	if ($banner_links):
	    echo '<div class="banner_links">';
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
?>
</section>

<?php }
if($m_hero_image){
?>
<section id="home-slider" class="home-slide full-section mobile-hero-image">
	<div class="silder-cover">
		<div id="owl-demo" class="<?php echo count($m_hero_image) > 1 ? 'owl-carousel banner-carousel' : '' ?>">
			<?php
				
				foreach($m_hero_image as $h){
				$image_id = attachment_url_to_postid($h['image']);
				$image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', TRUE);				 ?>

				<div class="item">
				  <?php if($h['image_link']) { ?>
					<a href="<?php echo $h['image_link']; ?>" target="<?php echo $h['target']; ?>">
						<div class="slide-bg kv-layzy" data-background="<?php echo $h['image']; ?>" role="img" aria-label="<?php echo $image_alt; ?>"></div>
					</a>
				  <?php } else { ?>
						<div class="slide-bg kv-layzy" data-background="<?php echo $h['image']; ?>" role="img" aria-label="<?php echo $image_alt; ?>"></div>
				  <?php } ?>
				</div>	
			<?php } ?>
		</div>
	</div>
<?php
	$banner_links = get_field('banner_links');
	if ($banner_links):
	global $post;
	$post_slug = $post->post_name;
	echo '<a class="jp_open" href="javascript:;">'. get_the_title() .'</a>';
	    echo '<div class="banner_links">';
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
?>
</section>
<?php
}


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
	

<?php get_footer(); ?>