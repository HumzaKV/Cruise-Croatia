<?php
$bg_color 	= $section['bg_color'];
$top 		= $section['padding_top'];
$bottom 	= $section['padding_bottom'];
$margin 	= $section['section_margin'];
if($margin == true){
	$marginbot = 'margin-bottom: 0px;';
} else {

}
echo '<section id="post_listing" class="full-section post-listing" style="background: '.$bg_color.'; padding-top:'.$top.';padding-bottom: '.$bottom.'; '.$marginbot.'">';
?>
	<div class="container">
		<?php if($section['product_listing_title']): ?>
			<h2 class="section-title"><?= $section['product_listing_title']; ?></h2>
		<?php endif; ?>
			<?= $section['product_listing_content']; ?>		
		<div class="listing-wrapper">	
			<ul>
			<?php 
			global $post;
            $product = $section['product_listing_area'];
			if($product):
            foreach($product as $p) {
            	$post_id = $p['product'];
            	if(!empty($post_id)){
				$post = get_post($post_id);
				if($post->post_status != 'publish'){
					continue;
				}
				setup_postdata($post);
				$post_image = get_field('post_listing_image');
	?>
			    <li class="post">
		            <a href="<?php the_permalink();?>">
				        <div class="post-thumbnail">
				                <?php 
				                    if($post_image) {
				                        echo wp_get_attachment_image( $post_image, 'full' );
				                    } else {
				                        echo wp_get_attachment_image( '4380', 'full');
				                    }
				                ?>
				         </div>
				        <div class="post-details">
					        <?php
					            $post_category = get_the_category();
					            if( $post_category ) {
					              echo '<ul class="post-categories">';
					                foreach( $post_category as $category ) {
					                    //echo '<li><a href="'. get_category_link( $category->term_id ) .'">' . $category->name . '</a></li>';
					                    echo '<li>'. $category->name .'</li>';
					                }
					              echo '</ul>';
					            }
					        ?>
					        <h5><?php the_title();?></h5>
					        <!-- <p><?php //echo wp_trim_words( get_the_content(), 20 );  ?></p> -->
					        <span>Read More</span>
				        </div>
		            </a>
			    </li>
	<?php
            	}
            }
		endif;
            ?>
			</ul>
			<?php
				$link = $section['link'];
				if(!empty($link)):
				    $link_url = $link['url'];
				    $link_title = $link['title'];
				    $link_target = $link['target'] ? $link['target'] : '_self';
				    echo '<a class="view_all loadmore" href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</a>';
				endif;
			?>
		</div>
	</div>
</section>