<?php
	$str = '';
	$str .= '<h1>' . $title . '</h1>';
	$str .= '<h2>Book ' . convert_number_to_roman($book). '</h2>';
	$str .= '<p>' . $program_notes . '</p>';
	$str .= '<object style="height: 600px; width: 300px; border: 1px solid black;">Place the preview here...</object>';
	//Being the form items here
	$hidden = [
		'book' => $book,
		'piece_index' => $piece_index
	];
	$str .= form_open('confirm', '', $hidden);
	$str .= '<div class="panel-wrapper">';
	$str .= '<div class="options-panel">';
	$str .= '<div class="accordion-wrap">';
	$str .= '<h3>Choose Your Format</h3>';
	$str .= '<div class="accordion-item">';
	$str .= '<p>Every purchase includes the digital version of this score. It is available as a PDF download and online attached to your user account.</p>';
	$str .= '<ul class="format-list">';
	//For each type of format, build a checkbox.
	foreach([
		[
			'id' => 'score-digital',
			'label' => 'Score Digital',
			'value' => 'score-digital',
			'checked' => true,
			'readonly' => true,
		],
        [
	        'id' => 'parts-digital',
	        'label' => 'Parts Digital',
	        'value' => 'parts-digital',
	        'checked' => true
        ],
        [
	        'id' => 'score-print',
	        'label' => 'Score Print',
	        'value' => 'score-print'
        ],
        [
	        'id' => 'parts-print',
	        'label' => 'Parts Print',
	        'value' => 'parts-print'
        ]
	        ] as $field) {
		$str .= '<li>';
		$str .= form_checkbox([
			'id' => $field['id'],
			'name' => 'format[' . $field['id'] . ']',
			'value' => $field['value'],
			'checked' => (isset($field['checked']) ? $field['checked'] : false),
			'readonly' => (isset($field['readonly']) ? $field['readonly'] : false), //TODO: Does this actually work???
		]);
		$str .= form_label($field['label'], $field['id']);
		$str .= '</li>';
	}
	$str .= '</ul>';
	$str .= '</div>';
	$str .= '<h3>Choose the Parts You Want</h3>';
	$str .= '<div class="accordion-item">';
	$str .= '<table id="choose_instrument"><thead>';
	$str .= '<tr>';
	for($i = 1; $i <= $piece['partCount']; $i++) {
		$str .= '<th>Part ' . convert_number_to_roman($i) . (isset($piece['partDiv'][$i]) && $piece['partDiv'][$i] == true ? ' <span class="divided-note" title="This part has optional divisi. More than one copy of this part is recommended.">(div.)</span>' : '') . '</th>';
	}
	$str .= '</tr></thead>';
	$str .= '<tbody><tr>';
	for($i = 1; $i <= $piece['partCount']; $i++) {
		$str .= '<td>';
		foreach($matrix[$i] as $key => $instruments) {
			foreach($instruments as $instrument) {
				//TODO: Split out the sanitized thing to a separate helper.
				$sanitized_instrument = sanitize_instrument($instrument);
				$id = 'part_' . $i . '_' . $sanitized_instrument;
				$args = [
					'id' => $id,
					'name' => 'part[' . $i . '][' . $sanitized_instrument . ']',
					'value' => $sanitized_instrument,
					'checked' => false
				];
				$str .= form_checkbox($args);
				$str .= form_label($instrument, $id);
				$str .= '<br />';
			}
		}
		$str .= '</td>';
	}
	$str .= '</tr>';
	$str .= '</tbody></table>';
	$str .= '</div>';
/*	$str .= '<h3>Finalize</h3>';
	$str .= '<div class="accordion-item>';
	$str .= '</div>';*/
	$str .= '</div>';      //accordion wrap
	$str .= '</div>';      //options panel
	//Price Panel
	$str .= '<h3>Your Price</h3>';
	$str .= '<div class="price-panel">';
	//Do price stuff here...
	$str .= '<span id="price_placeholder" class="price">' . $default_price . '</span>';
	$str .= form_hidden('price', $default_price);
	$str .= '<br />';
	$str .= form_submit('parts_submit', 'Submit');
	$str .= '</div>';   //price panel
	$str .= '</div>';   //panel wrapper
	$str .= form_close();
	$str .= '<script>
		jQuery(function() {
		    jQuery(".accordion-wrap").accordion({
		    	header: "h3"
		    });
			choosePartsRegister();
		});
	</script>';
	echo $str;