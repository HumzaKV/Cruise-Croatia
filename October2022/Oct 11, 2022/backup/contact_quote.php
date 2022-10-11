<?php 
$prod_id = @$_POST['product_id'];
$extension_ids = @$_POST['extensions'];
$passengers = @$_POST['passenger'];
$ship = get_field('ship_type', $prod_id);
$cruise_prices = get_field('field_6301f00fd87cb', $prod_id); // key: price
$cruise_price = 0;
$ext_price = 0;
// print_r( get_option('cur_rate_conversion') );

// Cruise
if( $cruise_prices ) {
	$sale_price = (float) $cruise_prices['regular_price'];
	$regular_price = (float) $cruise_prices['full_price'];
	if( $sale_price > 0 )
		$cruise_price += ( $regular_price > $sale_price ? $sale_price : $regular_price );
	else
		$cruise_price += $regular_price;
}

// Extensions
if( $extension_ids ) {
	foreach($extension_ids as $extension) {
		$_id = $extension['pid'];
		$prices = get_field('price', $_id);
		if( $prices ) {
			$sale_price = (float) $prices['sale_price'];
			$regular_price = (float) $prices['regular_price'];
			if( $sale_price > 0 )
				$ext_price += ( $regular_price > $sale_price ? $sale_price : $regular_price );
			else
				$ext_price += $regular_price;
			
			// echo $ext_price;

		}
		
	}
}

$passengerCost = $passengers * $cruise_price;
$totalCost = $passengerCost + $ext_price;
$totalCost = _currency_format($totalCost, true);
$passengerCost = _currency_format($passengerCost, true);
$extensionCost = _currency_format($ext_price, true);

// print_r($prices);
?>
<div id="contact_quote">
	<ul>
		<li><label>Ship:</label><span><?= $ship; ?></span></li>
		<li><label>Cruise:</label><span><span><?= get_the_title($prod_id) ?></span></li>
		<li><label>Departure Date:</label><span><span><?= @$_POST['date']; ?></span></li>
		<li><label>Cabin:</label><span><span><?= count($extension_ids); ?> x Cabins</span><strong><?= $extensionCost; ?></strong></li>
		<li><label>Guest:</label><span><span><?= @$_POST['passenger']; ?> x Passengers</span><strong><?= $passengerCost; ?></strong></li>
	</ul>
	<div class="quotetotal">
		<label>Totals:</label>
		<ul>
			<li><label>Total Deposit:</label><span><?= $totalCost; ?></span></li>
		</ul>
	</div>
</div>