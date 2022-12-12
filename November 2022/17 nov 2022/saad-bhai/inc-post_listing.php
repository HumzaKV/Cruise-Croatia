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
   	 	// $product_ids = is_array($product_ids) ? array_unique($product_ids) : array();

		echo '<pre>';
		print_r($product_ids);
		echo '</pre>';
   	 	// die;
		?>
		<ul>
			<?php
			global $wp_query; // you can remove this line if everything works for you
 
			if (  $wp_query->max_num_pages > 1 )
				// don't display the button if there are not enough posts
				echo '<div class="loadmore">More posts</div>'; // you can use <a> as well
			if( $product_ids ) :
				$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
				$args = array(
					'paged' => $paged,
					'posts_per_page' => 1,
    			// 'post_type' => '',
    			// 'post_status' => 'publish',
					'post__in' => $product_ids,
				);


    		// echo '<pre>';
	   	 	// print_r($products);
	   	 	// echo '</pre>';

				foreach($products as $prod) { setup_postdata($prod);
					$product_id = $prod->ID;
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
									echo '<ul class="post-categories">';
									foreach( $post_category as $category ) {
	                    			//echo '<li><a href="'. get_category_link( $category->term_id ) .'">' . $category->name . '</a></li>';
										echo '<li>'. $category->name .'</li>';
									}
									echo '</ul>';
								}
								?>
								<h5><?php the_title();?></h5>
								<span>Read More</span>
							</div>
						</a>
					</li>
					<?php
				}
	    	// End Foreach

			endif;
		// Endif
			?>
		</ul>

		<div class="navigation">
			<div class="next"><?php next_post_link(); ?></div>
		</div>
		<?php
		// $link = $section['link'];
		// if(!empty($link)):
		// 	$link_url = $link['url'];
		// 	$link_title = $link['title'];
		// 	$link_target = $link['target'] ? $link['target'] : '_self';
		// 	echo '<button class="view_all loadmore" href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</button>';
		// endif;
		?>
	</div>
</div>
<script>
	
	jQuery(function($){ // use jQuery code inside this to avoid "$ is not defined" error
		var availability_table_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';

		$(document).on("click",".loadmore",function() {
 
		var button = $(this),
		    data = {
			'action': 'travelblog',
			'query': json_encode( $wp_query->query_vars ), // that's how we get params from wp_localize_script() function
			'page' : <?php echo $paged; ?>
		};
 	
			            // make ajax request
	            	$.ajax({
	            		url: availability_table_ajax_url,
	            		type : "post",
	            		// data: {
	                    //         // this is the AJAX action we set up in PHP
	            		// 	'action': 'travelblog',
	            		// 	'row': row,
	            		// 	'product': product,
	            		// },
	            		success: function(resp) {
	            			console.log(resp);
	            			$('.listing-wrapper ul').html(resp);
	                                    // this ID must match the id of the show more link
				// $('#availability_table_show_more_link').css('display', 'none');
	            		},
	            		error: function(error) {
	            			console.log(error);
	            		}
	            	});

		$.ajax({ // you can also use $.post here
			url: availability_table_ajax_url, // AJAX handler
			data : data,
			type : 'POST',
			beforeSend : function ( xhr ) {
				button.text('Loading...'); // change the button text, you can also add a preloader image
			},
			success : function( data ){
				if( data ) { 
					button.text( 'More posts' ).prev().before(data); // insert new posts
					misha_loadmore_params.current_page++;
 
					if ( misha_loadmore_params.current_page == misha_loadmore_params.max_page ) 
						button.remove(); // if last page, remove the button
 
					// you can also fire the "post-load" event here if you use a plugin that requires it
					// $( document.body ).trigger( 'post-load' );
				} else {
					button.remove(); // if no data, remove the button as well
				}
			}
		});
	});

		// var product = <?php echo $section['product_listing_area']; ?>;
		// var availability_table_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		// var row = 1;
		// <?php $row = 1; ?>
		// var blogdata = [];
		// $(document).on("click",".loadmore",function() {

		// 	var post_count = $('.post').length;
		// 	post_count = parseInt(post_count);
		// 	console.log('count: '+ post_count);
		// 	post_count = post_count + 2;
		// 	console.log('test');
		// 	blogdata = '<?php 	
		// 		$product = $section['product_listing_area'];
		// 		echo $stop = $i * 6;
		// 		foreach($product as $p) {

		// 		$post_id = $p['product'];
		// 		if(!empty($post_id)){
		// 			$post = get_post($post_id);
		// 			if($post->post_status != 'publish'){
		// 				continue;
		// 			}
		// 			if ($i < $total)
		// 				if ( $i < $stop) { 

		// 					setup_postdata($post);
		// 					$post_image = get_field('post_listing_image');

		// 					echo '<li class="post">';
		// 					echo '<a href="'. get_permalink().'">';
		// 					echo '<div class="post-thumbnail">';

		// 					if($post_image) {
		// 						echo wp_get_attachment_image( $post_image, 'full' );
		// 					} else {
		// 						echo wp_get_attachment_image( '4380', 'full');
		// 					}

		// 					echo '</div>';
		// 					echo '<div class="post-details">';

		// 					$post_category = get_the_category();
		// 					if( $post_category ) {
		// 						echo '<ul class="post-categories">';
		// 						foreach( $post_category as $category ) {
		// 							echo '<li>'. $category->name .'</li>';
		// 						}
		// 						echo '</ul>';
		// 					}

		// 					echo '<h5>'.get_the_title().'</h5>';
		// 					echo '<span>Read More</span>';
		// 					echo '</div>';
		// 					echo '</a>';
		// 					echo '</li>';
		// 				}
		// 				echo 'for loop'.$stop;
		// 			}
        //             }// end product foreach
	    //         // print_r('pages:'.$pages);
	    //     ?>';

        //     $('.listing-wrapper ul').html(blogdata);
        //     console.log('<?php echo 'issues_per_page:'.$issues_per_page.'total:'.$total.'min:'.$min.'page:'.$page.'max'.$max.'row'.$row; ?>');
	    //         // console.log('<?php echo 'issues_per_page:'.$issues_per_page; ?>');
	            // make ajax request
	            // 	$.ajax({
	            // 		url: availability_table_ajax_url,
	            // 		type : "post",
	            // 		data: {
	            //                 // this is the AJAX action we set up in PHP
	            // 			'action': 'travelblog',
	            // 			'row': row,
	            // 			'product': product,
	            // 		},
	            // 		success: function(resp) {
	            // 			console.log(resp);
	            // 			$('.listing-wrapper ul').html(resp);
	            //                         // this ID must match the id of the show more link
				// // $('#availability_table_show_more_link').css('display', 'none');
	            // 		},
	            // 		error: function(error) {
	            // 			console.log(error);
	            // 		}
	            // 	});
		// 		console.log('<?php echo $i; ?>');
		// 		<?php $i++; ?>;
		// 		console.log('<?php echo $i; ?>');
        // });


	});

</script>