<?php

echo '<section class="full-section passengers">';

echo '<div class="passengers_inn">';



echo '<a class="pop_close" href="javascript:;"><i class="fa fa-close"></i></a>';

printf('<h2>Would you like to add any extensions to your trip?</h2>');



echo '<div class="passen">';

$ext = get_field('pro_extension');
if( $ext ):

	foreach( $ext as $itm ):
	echo '<div class="ex_style">';
		$title = get_the_title($itm);
		$price  = get_field('price', $itm);
		printf('<h5>%s</h5>',$title);
		printf('<span>From $%spp</span>',$price['regular_price']);

		echo '<a class="select_btn" href="javascript:;">Add this Extension</a>';

	echo '</div>'; //ex_style
	endforeach;

endif;

		
		echo '</div>'; //passen
		
		echo '<a class="btn btn-green submit-btn" href="javascript:;">Next</a>';
		
		echo '</div>'; //passengers_inn
		
		echo '</section>';
		
		