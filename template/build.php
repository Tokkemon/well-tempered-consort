<?php
//Build Your Ensemble Block

$instrument_data = get_instruments();

//TODO: Build the ensemble builder here.
?>
<section class="bg-dark text-white">
	<div class="container text-center">
		<h2 class="mb-4">Build Your Ensemble</h2>
		<div class="row">
		<?php 
		foreach($instrument_data as $instrument) {
			echo '<div class="col-md-1">' . $instrument['label'] . ' (' . $instrument['transposition'] . ')</div>';
		}
		?>
	</div>
</section>