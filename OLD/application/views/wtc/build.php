<?php
	echo '<h1>' . $title . '</h1>';
	echo '<p>Have an usual combination you\'re looking for? Choose your instruments here!</p>';
	echo '<script type="text/javascript" src="' . base_url() . 'js/build_ensemble.js" ></script>';
	echo '<script type="text/javascript">var instruments = ' . json_encode($instruments) . '; var ensembles = ' . json_encode($ensembles) . ';</script>';
	//TODO: Build the ensemble module here.
	echo '<p>What are you looking for?</p>';
	echo '<button id="reset_list">Reset</button>';
	echo '<button id="add_instrument">Add Instrument</button>';
	echo '<select id="add_instrument_select">';
	foreach($instruments as $instrument) {
		echo '<option value="' . $instrument['name'] . '">' . ucwords($instrument['name']) . '</option>';
	}
	echo'</select>';
	echo '<select id="common_ensembles">';
	echo '<option value=""></option>';
	foreach($ensembles as $ensemble) {
		echo '<option value="' . $ensemble['name'] . '">' . ucwords($ensemble['name']) . '</option>';
	}
	echo '</select>';
	echo '<label for="part_count">What how many parts?</label>';
	echo '<select id="part_count">';
	echo '<option value=""></option>';
	echo '<option value="2">Duet</option>';
	echo '<option value="3">Trio</option>';
	echo '<option value="4">Quartet</option>';
	echo '<option value="5">Quintet</option>';
	echo '</select>';
	echo '<ul id="instrument_list"></ul>';
	echo '<ul class="bucket_wrapper">';
	echo '<li id="bucket_1" class="part_bucket"><h3>Part I</h3><ul id="bucket_1_inst"></ul></li>';
	echo '<li id="bucket_2" class="part_bucket"><h3>Part II</h3><ul id="bucket_1_inst"></ul></li>';
	echo '<li id="bucket_3" class="part_bucket"><h3>Part III</h3><ul id="bucket_1_inst"></ul></li>';
	echo '<li id="bucket_4" class="part_bucket"><h3>Part IV</h3><ul id="bucket_1_inst"></ul></li>';
	echo '<li id="bucket_5" class="part_bucket"><h3>Part V</h3><ul id="bucket_1_inst"></ul></li>';
	echo '</ul>';