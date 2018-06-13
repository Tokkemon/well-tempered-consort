<?php
//Pieces Page Block
echo '<section class="bg-dark text-primary">';

//use the page_params to build individual pieces pages.
//BWV ranges between 846 to 893
if(isset($page_params[0]) && is_numeric($page_params[0]) && ((846 <= $page_params[0]) && ($page_params[0] <= 893))) {
	$bwv_number = $page_params[0];
	$piece = get_pieces_data($bwv_number);
	$image_src = $site_url . 'scores/' . $piece['bwv'] . '.svg';
	//Get the parts selector data.
	$prelude_parts = get_parts_data($piece['prelude']['type']);
	$fugue_parts = get_parts_data($piece['fugue']['type']);
	$instruments = get_instruments(); ?>
	<div class="container text-center">
		<h2>Prelude and Fugue in <?php echo $piece['key']; ?>, BWV<?php echo $piece['bwv']; ?></h2>
		<h4 class="text-faded">Well-Tempered Clavier, Book <?php echo($piece['book'] == 1 ? 'I' : 'II'); ?></h4>
		<div class="row text-center">
            <img class="score-page" src="<?php echo $image_src; ?>" alt="Score Page">
        </div>
        <div class="row text-left text-white">
            <div class="col-md-4">
                <h5 class="piece-list">Prelude: <?php echo $piece['prelude']['type']; ?></h5>
                <?php foreach($prelude_parts as $part_num => $part) {
                    //Parts selectors
                    echo '<h6 class="part-list">Part ' . $part_num . '<span class="validation"></span></h6>';
                    echo '<ul class="part-list" data-part="' . $part_num . '">';
                    foreach($part as $part_inst) {
                        echo '<li class="instrument">' . $part_inst . '</li>';
                    }
                    echo '</ul>';
                } ?>
            </div>
            <div class="col-md-4">
                <h5 class>Fugue: <?php echo $piece['fugue']['type']; ?></h5>
                <?php foreach($fugue_parts as $part_num => $part) {
                    //Parts selectors
                    echo '<h6>Part ' . $part_num . '</h6>';
                    echo '<ul class="part-list" data-part="' . $part_num . '">';
                    foreach($part as $part_inst) {
                        echo '<li class="instrument">' . $part_inst . '</li>';
                    }
                    echo '</ul>';
                } ?>
            </div>
            <div class="col-md-4">
                <span class="price">Price: </span>
            </div>
		</div>
		<a href="<?php echo $site_url; ?>pieces">Back to Pieces</a>
	</div>
<?php }
//If there's no specific piece, use the other one.
else { 
	$pieces = get_pieces_data(); ?>
	<div class="container text-center">
		<h1><?php echo $page_name; ?></h1>
		<div class="row">
	<?php foreach(['1' => 'I', '2' => 'II'] as $num => $rom) { ?>
	<div class="col-xs-1">
		<h3 id="book_<?php echo $num; ?>">Book <?php echo $rom; ?></h3>
		<table class="table table-hover text-white">
			<thead>
				<tr>
					<th>BWV</th>
					<th>Name</th>
					<th>Key</th>
					<th>Parts</th>
					<th>Incipit <span> Hide</span></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($pieces[$num] as $piece) { 
				$piece_link = $site_url . 'pieces/' . $piece['bwv'] . '/';
				$incipit_link = $site_url . 'incipits/' . $piece['bwv'] . '.svg';
			?>
				<tr>
					<td rowspan="2"><a href="<?php echo $piece_link; ?>">BWV<?php echo $piece['bwv']; ?></a></td>
					<td rowspan="2"><?php echo $piece['key']; ?></td>
					<td>Prelude</td>
					<td><?php echo $piece['prelude']['type']; ?></td>
					<td rowspan="2"><img src="<?php echo $incipit_link; ?>" alt="incipit"></td>
				</tr>
				<tr>
					<td>Fugue</td>
					<td><?php echo $piece['fugue']['type']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>	
	<?php } ?>
		</div>
	</div>
	<?php
}

echo '</section>';
echo '<script>partsPriceCalc();</script>';

debug_print($page_request);
debug_print($page_params);
