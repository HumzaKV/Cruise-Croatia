<?php
$bg_color 	= $section['bg_color'];
$top 		= $section['padding_top'];
$bottom 	= $section['padding_bottom'];
$margin 	= $section['section_margin'];
if(!$i)
	$i=1;
if($margin == true)
{
	$marginbot = 'margin-bottom: 0px;';
} else {

}
echo '<section id="post_listing" class="full-section post-listing" style="background: '.$bg_color.'; padding-top:'.$top.';padding-bottom: '.$bottom.'; '.$marginbot.'">';
?>
<div class="container">
	<?php 
   	 if($section['product_listing_title']): ?>
   	 	<h2 class="section-title"><?= $section['product_listing_title']; ?></h2>
   	 <?php endif; ?>
   	 <?= $section['product_listing_content']; ?>		
   	 <div class="listing-wrapper">	
   	 	<?php 
   	 	// global $post;
   	 	$product_ids = $section['product_listing_area'];
   	 	$product_ids = wp_list_pluck($product_ids, 'product');
   	 	$product_ids = is_array($product_ids) ? array_unique($product_ids) : array();

   	 	// echo '<pre>';
   	 	// print_r($product_ids);
   	 	// echo '</pre>';
   	 	// die;

    	if( $product_ids ) :
   	 		printf('<ul>');

    		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
    		$args = array(
    			'paged' => $paged,
    			'posts_per_page' => 1,
    			// 'post_type' => '',
    			'post_status' => 'publish',
    			'post__in' => $product_ids,
    		);
    		// $products = get_posts($args);
    		$products = new WP_Query($args);
    		// echo '<pre>';
	   	 	// print_r($products);
	   	 	// echo '</pre>';

    		// foreach($products as $prod) { setup_postdata($prod);
    		while ($products->have_posts()) : $products->the_post();
    			// $product_id = $prod->ID;
    			$product_id = get_the_ID();
    			$attach_id = get_field('post_listing_image', $product_id);
    	?>
				<li class="post">
					<a href="<?php the_permalink(); ?>">
						<div class="post-thumbnail">
							<?php 
							if( $attach_id ) {
								echo wp_get_attachment_image( $attach_id, 'full' );
							} else {
								echo wp_get_attachment_image( '4380', 'full');
							}
							?>
						</div>
						<div class="post-details">
							<?php
							$post_category = get_the_category($product_id);
							if( $post_category ) {
								echo '<div class="post-categories">';
								foreach( $post_category as $category ) {
	                    			//echo '<li><a href="'. get_category_link( $category->term_id ) .'">' . $category->name . '</a></li>';
									echo '<div>'. $category->name .'</div>';
								}
								echo '</div>';
							}
							?>
							<h5><?php the_title();?></h5>
							<span>Read More</span>
						</div>
					</a>
				</li>
		<?php
	    	endwhile;
	    	// End Foreach
	    	printf('</ul>');

	    	echo '<div class="ex-pagination">';
	    		next_posts_link( 'Load More', $products->max_num_pages );
	    	echo '</div>';
	    	// previous_posts_link( 'Newer posts', $products->max_num_pages );
	    	
	        wp_reset_postdata();
		endif;
		// Endif
		?>
	</div>
</div>
<script>
	
jQuery(function($) {
	$('.listing-wrapper').on('click', '.ex-pagination a', function(e) {
		e.preventDefault();

		$.ajax({
			url: $(this).attr('href'),
			method: 'GET',
			dataType: 'html',
			success: (res) => {
				let _li = $('.listing-wrapper ul .post', res),
					_nav = $(".ex-pagination a", res);

				$('.listing-wrapper ul').append(_li);
				
				if( _nav.length === 0 )
					$('.ex-pagination').hide();
				else
					$('.ex-pagination').html(_nav);
			}
		});

		return false;
	})
});
</script>