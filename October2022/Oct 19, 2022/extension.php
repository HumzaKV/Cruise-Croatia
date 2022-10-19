<?php
echo '<section class="full-section passengers">';
echo '<div class="passengers_inn">';
echo '<a class="pop_close" href="javascript:;"><i class="fa fa-close"></i></a>';
printf('<h2>Would you like to add any extensions to your trip?</h2>');

echo '<div class="passen">';

$ext = get_field('pro_extension');
if( $ext ):
	$num = 1;
	foreach( $ext as $itm ):
	echo '<div class="ex_style">';
		$title = get_the_title($itm);
		$price  = get_field('price', $itm);
		printf('<h5>%s</h5>',$title);
		if(!empty($price['sale_price'])){
			printf('<span class="sale-price">From %spp</span>',_currency_format($price['regular_price'], true));
			printf('<span class="reg-price">Full %s</span>',_currency_format($price['sale_price'], true));
		}
		else
		printf('<span>From %spp</span>',_currency_format($price['regular_price'], true));
		echo '<a class="select_btn" data-id="'.$itm.'" data-num="'.$num.'" href="javascript:;">Add this Extension</a>';

	echo '</div>'; //ex_style
	$num++;
	endforeach;
endif;
		
		echo '</div>'; //passen	
		echo '<a class="btn btn-green submit-btn btn-nxt" href="https://staging8.cruisecroatia.com/inquire-form/">Next</a>';
		echo '</div>';
		echo '</section>';