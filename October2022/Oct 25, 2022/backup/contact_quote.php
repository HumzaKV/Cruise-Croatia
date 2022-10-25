
<?php 
$prod_id = $_POST['post_id'];
$extension_ids = $_POST['extensions'];
$passengers = $_POST['passenger'];
$cabins = $_POST['cabin'];
$ship_name = $_POST['ship'];
$cruise_prices = get_field('field_6301f00fd87cb', $prod_id); // key: price
$cruise_price = 0;
$price = $_POST['price'];
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

	$e_id = 36;
	foreach($extension_ids as $extension) {
		$_id = $extension['pid'];
		$prices = get_field('price', $_id);
		$title = get_the_title($_id);
		if( $prices ) {
			$sale_price = (float) $prices['sale_price'];
			$regular_price = (float) $prices['regular_price'];
			if( $sale_price && $sale_price > 0 && $regular_price > $sale_price ){
				$extprice =  $sale_price;
				$ext_price += $sale_price;
				$extprice = _currency_format($extprice, true);
				$ext_data .= '<li><label>Extensions</label><span class="ext_name">'.$title.' </span>
				<span class="ext_reg_price">Full Price: '._currency_format($regular_price, true).' </span>
				<span class="ext_sale_price">From: '.$extprice.' </span></li>';
			}
			else if( $sale_price && $sale_price > 0 && $sale_price > $regular_price )
			{
				$ext_price += $regular_price;
				$extprice += $regular_price;	
				$extprice = _currency_format($extprice, true);
				$ext_data .= '<li><label>Extensions</label><span class="ext_name">'.$title.' </span>
				<span class="ext_price">Price: '.$extprice.' </span></li>';
			}
			else
			{
				$ext_price += $regular_price;
				$extprice += $regular_price;	
				$extprice = _currency_format($extprice, true);
				$ext_data .= '<li><label>Extensions</label><span class="ext_name">'.$title.' </span>
				<span class="ext_price">Price: '.$extprice.' </span></li>';
			}
			// echo $ext_price;

		}
		

		echo '<script> $("#input_20_49").val( $("#input_20_49").val() + "'. $title .', " ); </script>';
	}
}

$passengerCost = $passengers * $price;
$cabinCost = $cabins * $price;
// echo 'cruise: '.$cruise_price;
$totalCost = $passengerCost + $ext_price + $cabinCost;
// INSERT cruise and total price in hidden fields 
?>

<script> 
let UFGStorage = JSON.parse( localStorage.getItem('UFGStorage') );
console.log(UFGStorage['extensions']);
console.log(JSON.stringify(UFGStorage['extensions']));
// UFGStorage['extensions']
</script>
<?php
echo '
<script>
$("#input_20_44").val( "'. $ship_name .'" );
$("#input_20_2").val( "'. htmlspecialchars_decode( get_the_title( $prod_id ) ) .'" );
$("#input_20_45").val( "'. $totalCost .'" );
</script>
';
$totalCost = _currency_format($totalCost, true);
$passengerCost = _currency_format($passengerCost, true);
$cabinCost = _currency_format($cabinCost, true);
$extensionCost = _currency_format($ext_price, true);

// print_r($prices);
?>
<div id="contact_quote" class="box_1 style_box inquire_sec">
	<ul>
		<li><label>Ship:</label><span class="ship"><?=  $ship_name; ?></span></li>
		<li><label>Cruise:</label><span><span><?= get_the_title($prod_id) ?></span></li>
		<li><label>Departure Date:</label><span><span class="date"><?= $_POST['date']; ?></span></li>
		<input type="hidden" class="cabin" value="<?php echo $cabins ?>">
		<li><label>Cabin:</label><span><span><?= $cabins; ?> x </span><strong><?= $cabinCost; ?></strong></li>
		<input type="hidden" class="paas" value="<?php echo $_POST['passenger'] ?>">
		<li><label>Passengers:</label><span><span><?= $_POST['passenger']; ?> x </span><strong><?= $passengerCost; ?></strong></li>
		<?php echo $ext_data; ?>
	</ul>
	<div class="quotetotal">
		<label>Totals:</label>
		<ul>
			<li><label>Total Deposit:</label><span><?= $totalCost; ?></span></li>
		</ul>
	</div>
</div>