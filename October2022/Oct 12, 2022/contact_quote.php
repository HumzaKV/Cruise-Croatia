<?php 
$prod_id = $_POST['post_id'];
$extension_ids = $_POST['extensions'];
$passengers = $_POST['passenger'];
$cabins = $_POST['cabin'];
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
	$ext_data .= '<h4>Extensions</h4>';
	foreach($extension_ids as $extension) {
		$_id = $extension['pid'];
		$prices = get_field('price', $_id);
		$title = get_the_title($_id);
		if( $prices ) {
			$sale_price = (float) $prices['sale_price'];
			$regular_price = (float) $prices['regular_price'];
			if( $sale_price > 0 ){
				$extprice = ( $regular_price > $sale_price ? $sale_price : $regular_price );
				$ext_price += ( $regular_price > $sale_price ? $sale_price : $regular_price );
			}
				else
				{
				$ext_price += $regular_price;
				$extprice += $regular_price;	
				}
			// echo $ext_price;

		}
		$extprice = _currency_format($extprice, true);
		$ext_data .= '<li>'.$title.' <span><span><strong></br> Price: </strong>'.$extprice.'  </span></li>';
	}
}

$passengerCost = $passengers * $cruise_price;
$cabinCost = $cabins * $cruise_price;
// echo 'cruise: '.$cruise_price;
$totalCost = $passengerCost + $ext_price + $cabinCost;
$totalCost = _currency_format($totalCost, true);
$passengerCost = _currency_format($passengerCost, true);
$cabinCost = _currency_format($cabinCost, true);
$extensionCost = _currency_format($ext_price, true);

// print_r($prices);
?>
<script>
jQuery(function($){

	$('#input_20_2').val(res)
	UFGStorage['post_id']
})
	</script>
<div id="contact_quote">
	<ul>
		<li><label>Ship:</label><span class="ship"><?= $ship; ?></span></li>
		<li><label>Cruise:</label><span><span><?= get_the_title($prod_id) ?></span></li>
		<li><label>Departure Date:</label><span><span class="date"><?= $_POST['date']; ?></span></li>
		<li><label>cabin:</label><span><span><?= $cabins; ?> x Cabins</span><strong><?= $cabinCost; ?></strong></li>
		<li><label>Guest:</label><span><span><?= $_POST['passenger']; ?> x Passengers</span><strong><?= $passengerCost; ?></strong></li>
		<?php echo $ext_data; ?>
	</ul>
	<div class="quotetotal">
		<label>Totals:</label>
		<ul>
			<li><label>Total Deposit:</label><span><?= $totalCost; ?></span></li>
		</ul>
	</div>
</div>