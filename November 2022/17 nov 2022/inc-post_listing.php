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

	if (!$row)
		$row = 0;

	if (!$issues_per_page)
   	 	$issues_per_page = 0; // How many rows to display on each page

   	 if (!$issues)
   	 	$issues = '';

   	 if (!$total)
   	 	$total = '';

   	 if (!$pages)
   	 	$pages = 0;

   	 if (!$min)
   	 	$min = '';

   	 if (!$max)
   	 	$max = '';

   	 if($section['product_listing_title']): ?>
   	 	<h2 class="section-title"><?= $section['product_listing_title']; ?></h2>
   	 <?php endif; ?>
   	 <?= $section['product_listing_content']; ?>		
   	 <div class="listing-wrapper">	
   	 	<?php 
   	 	global $post;
   	 	$product = $section['product_listing_area'];
   	 	?>
   	 	<ul>
   	 		<?php
   	 		if( get_query_var('page') ) {
   	 			$page = get_query_var( 'page' );
   	 		} else {
   	 			$page = 1;
   	 		}                       
   	 		if ($issues_per_page == 0) 
	    		$issues_per_page = 6; // How many rows to display on each page
	    	
	    	$issues = $product;	
	    	$total = count( $issues );

	    	if ($pages == 0)
	    		$pages = ceil( $total / $issues_per_page );
	    	
	    	if ($min == '')
	    		$min = ( ( $page * $issues_per_page ) - $issues_per_page ) + 1;

	    	if ($max == '') 
	    		$max = ( $min + $issues_per_page ) - 1;
	    	
	    	if($product):

	    		$n = 0;
	    		foreach($product as $p) {
	    			$row++;
	    		// if($row < $min) {
	    		// 	continue;
	    		// } 
	    			if($row > $max) {
	    				break;
	    			}
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
	    			
			    	}// end product foreach
			    endif;//end if(product)
			    ?>
			</ul>
			<?php
			$link = $section['link'];
			if(!empty($link)):
				$link_url = $link['url'];
				$link_title = $link['title'];
				$link_target = $link['target'] ? $link['target'] : '_self';
				echo '<button class="view_all loadmore" href="'.$link_url.'" target="'.$link_target.'">'.$link_title.'</button>';
			endif;
			?>
		</div>
	</div>
</section>
<script>
	
	jQuery(function($) {
		// var product = <?php echo $section['product_listing_area']; ?>;
		// var availability_table_ajax_url = '<?php echo admin_url('admin-ajax.php'); ?>';
		// var row = 1;
		// <?php $row = 1; ?>
		var blogdata = [];
		$(document).on("click",".loadmore",function() {

			var post_count = $('.post').length;
			post_count = parseInt(post_count);
			console.log('count: '+ post_count);
			post_count = post_count + 2;
			console.log('test');
			blogdata = '<?php 	
				$product = $section['product_listing_area'];
				$stop = $i * 6;
				echo $stop;
				foreach($product as $p) {

				$post_id = $p['product'];
				if(!empty($post_id)){
					$post = get_post($post_id);
					if($post->post_status != 'publish'){
						continue;
					}
					if ($i < $total)
						if ( $i < $stop) { 

							setup_postdata($post);
							$post_image = get_field('post_listing_image');

							echo '<li class="post">';
							echo '<a href="'. get_permalink().'">';
							echo '<div class="post-thumbnail">';

							if($post_image) {
								echo wp_get_attachment_image( $post_image, 'full' );
							} else {
								echo wp_get_attachment_image( '4380', 'full');
							}

							echo '</div>';
							echo '<div class="post-details">';

							$post_category = get_the_category();
							if( $post_category ) {
								echo '<ul class="post-categories">';
								foreach( $post_category as $category ) {
									echo '<li>'. $category->name .'</li>';
								}
								echo '</ul>';
							}

							echo '<h5>'.get_the_title().'</h5>';
							echo '<span>Read More</span>';
							echo '</div>';
							echo '</a>';
							echo '</li>';
						}
						echo 'for loop'.$stop;
					}
                    }// end product foreach
	            // print_r('pages:'.$pages);
	        ?>';
	        
            $('.listing-wrapper ul').html(blogdata);
            console.log('<?php echo 'issues_per_page:'.$issues_per_page.'total:'.$total.'min:'.$min.'page:'.$page.'max'.$max.'row'.$row; ?>');
	            // console.log('<?php echo 'issues_per_page:'.$issues_per_page; ?>');
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
				console.log('<?php echo $i; ?>');
				<?php $i++; ?>;
				console.log('<?php echo $i; ?>');
        });
				

	});

</script>