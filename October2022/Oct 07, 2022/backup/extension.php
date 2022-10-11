<?php
echo '<section class="full-section passengers">';
	echo '<div class="passengers_inn">';

		echo '<a class="pop_close" href="javascript:;"><i class="fa fa-close"></i></a>';
		printf('<h2>Would you like to add any extensions to your trip?</h2>');

		echo '<div class="passen">';

			echo '<div class="ex_style">';
				printf('<h5>2-3 Nights stay inDubrovnik</h5>');
				printf('<span>From $399pp</span>');
				echo '<a class="select_btn" href="javascript:;">Add this Extension</a>';
			echo '</div>'; //ex_style

			echo '<div class="ex_style">';
				printf('<h5>2-3 Nights stay inDubrovnik</h5>');
				printf('<span>From $399pp</span>');
				echo '<a class="select_btn" href="javascript:;">Add this Extension</a>';
			echo '</div>'; //ex_style

			echo '<div class="ex_style">';
				printf('<h5>2-3 Nights stay inDubrovnik</h5>');
				printf('<span>From $399pp</span>');
				echo '<a class="select_btn" href="javascript:;">Add this Extension</a>';
			echo '</div>'; //ex_style

			echo '<div class="ex_style">';
				printf('<h5>2-3 Nights stay inDubrovnik</h5>');
				printf('<span>From $399pp</span>');
				echo '<a class="select_btn active" href="javascript:;">Remove this Extension</a>';
			echo '</div>'; //ex_style

		echo '</div>'; //passen
		echo '<a class="btn btn-green submit-btn" href="javascript:;">Next</a>';
	echo '</div>'; //passengers_inn
echo '</section>';
