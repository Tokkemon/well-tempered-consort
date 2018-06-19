<?php
	echo '<h1>' . $title . '</h1>';
	echo '<p>List of Pieces</p>';
	echo '<fieldset id="part_count_filter">';
	echo '<legend>Filter by total number of parts</legend>';
	foreach(['duet', 'trio', 'quartet', 'quintet'] as $index => $name) {
		$id = 'part_count_filter_' . ($index + 2);
		echo '<label for="' . $id . '">' . ucfirst($name) . '</label><input type="checkbox" name="part_count_filter[' . ($index + 2) . ']" id="' . $id . '" value="' . ($index + 2) . '" checked="checked"><br />';
	}
	echo '</fieldset>';
	echo '<script>
		jQuery(function() {
		    registerPartCountFilter();
		})
	</script>';
	$str = '';
	$table_head = '<thead><tr><th>Name</th><th>Parts</th><th>Incipit</th></tr></thead>';
	foreach($pieces as $book_num => $book) {
		$str .= '<h2>Book ' . convert_number_to_roman($book_num) . '</h2>';
		$str .= '<table id="book_' . $book_num . '">' . $table_head . '<tbody>';
		foreach($book as $piece_index => $piece) {
			$name = ucfirst($piece['kind']) . ' in ' . $piece['key'] . ' (BWV' . $piece['bwv'] . ')';
			//Make the link to the individual piece's page.
			//TODO: Move all this linky and incipit stuff to the controller.
			$link = base_url() . 'piece/' . $book_num . '/' . $piece_index;
			$name = '<a href="' . $link . '" title="' . $name . '">' . $name . '</a>';
			$parts = ucfirst(convertIntToEnsemble($piece['partCount']));
			$incipit = (isset($piece['incipit']) ? '<object class="incipit" data="' . base_url() . 'media/incipit/' . $piece['incipit'] . '" type="image/svg+xml"></object>' : '');
			$str .= '<tr><td class="name">' . $name . '</td><td class="parts" data-part-count="' . $piece['partCount'] . '">' . $parts . '</td><td class="incipit">' . $incipit . '</td></tr>';
		}
		$str .= '</tbody></table>';
	}
	echo $str;