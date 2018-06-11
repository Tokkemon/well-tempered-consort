<?php
//Pieces Page Block

//Parse the json file
$json_file = $site_path . 'data/pieces.json';
$json = file_get_contents($json_file);
$pieces = json_decode($json, true);

echo '<section class="bg-dark text-primary">';

//use the page_params to build individual pieces pages.
//BWV ranges between 846 to 893
if(isset($page_params[0]) && is_numeric($page_params[0]) && ((846 <= $page_params[0]) && ($page_params[0] <= 893))) {
	$piece = $page_params[0];
	$book = null;
	//get the specific piece's data
	foreach($pieces as $book_num => $book_data) {
		$piece_data = array_values(array_filter($book_data, function($value) use ($piece) {
			return ($value['bwv'] == $piece);
		}))[0];
		if(!empty($piece_data)) {
			$book = $book_num;
			break;
		}
	}
	echo '<div class="container text-center">';
	echo '<h2>Prelude and Fugue in ' . $piece_data['key'] . ', BWV' . $piece_data['bwv'] . '</h2>';
	echo '<h4 class="text-faded">Well-Tempered Clavier, Book ' . ($book == 1 ? 'I' : 'II') . '</h4>';
	echo '<div class="container score-page">';
	//TODO: Score goes here.
	$image_src = $site_url . 'scores/' . $piece_data['bwv'] . '.svg';
	echo '<img src="' . $image_src . '" alt="Score Page">';
	echo '</div>';
	//TODO: list of available parts???
	echo '<a href="' . $site_url . 'pieces">Back to Pieces</a>';
	echo '</div>';
}
//If there's no specific piece, use the other one.
else {
	?>
	<div class="container text-center">
		<h1><?php echo $page_name; ?></h1>
		<a class="btn btn-light btn-xl js-scroll-trigger" href="#book_1">Book I</a>
		<a class="btn btn-light btn-xl js-scroll-trigger" href="#book_2">Book II</a>
	<?php foreach(['1' => 'I', '2' => 'II'] as $num => $rom) { ?>
		<h3 id="book_<?php echo $num; ?>">Book <?php echo $rom; ?></h3>
		<table class="text-white">
			<thead>
				<tr>
					<th>BWV</th>
					<th>Name</th>
					<th>Key</th>
					<th>Parts</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($pieces[$num] as $piece) { 
				$piece_link = $site_url . 'pieces/' . $piece['bwv'] . '/';
			?>
				<tr>
					<td rowspan="2"><a href="<?php echo $piece_link; ?>">BWV<?php echo $piece['bwv']; ?></a></td>
					<td rowspan="2"><?php echo $piece['key']; ?></td>
					<td>Prelude</td>
					<td><?php echo $piece['prelude']['type']; ?></td>
				</tr>
				<tr>
					<td>Fugue</td>
					<td><?php echo $piece['fugue']['type']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php } ?>
	</div>
	<?php
}

echo '</section>';

debug_print($page_request);
debug_print($page_params);

debug_print($pieces);
