<?php
//Build Your Ensemble Block

$instrument_data = get_instruments();
$sections = array_unique(array_column($instrument_data, 'section'));

//TODO: Build the ensemble builder here.
?>
<section class="bg-dark text-white">
	<div class="container text-center">
		<h2 class="mb-4">Build Your Ensemble</h2>
        <label for="ensemble_size">Ensemble Size</label>
        <select id="ensemble_size">
            <option value="2">Duet</option>
            <option value="3">Trio</option>
            <option value="4" selected>Quartet</option>
            <option value="5">Quintet</option>
        </select>
        <div class="row dropplaces">
            <div class="col-md-2 dropplace" id="part_1_drop"><h4>Part 1</h4></div>
            <div class="col-md-2 dropplace" id="part_2_drop"><h4>Part 2</h4></div>
            <div class="col-md-2 dropplace" id="part_3_drop"><h4>Part 3</h4></div>
            <div class="col-md-2 dropplace" id="part_4_drop"><h4>Part 4</h4></div>
            <div class="col-md-2 dropplace faded" id="part_5_drop"><h4>Part 5</h4></div>
        </div>
        <?php foreach($sections as $section) {
            echo '<h3>' . ucfirst($section) . '</h3>';
            echo '<div class="row instrument-section" id="' . $section . '_list">';
            $section_data = array_filter($instrument_data, function($value) use ($section) {
                return ($value['section'] == $section);
            });
            foreach($section_data as $instrument) {
                echo '<div class="col-md-1 instrument">';
                echo '<img src="' . $site_url . 'img/836800-music-instruments/svg/' . $instrument['icon'] . '" width="100" alt="' . $instrument['label'] .'">';
                echo $instrument['label'] . ' (' . $instrument['transposition'] . ')';
                echo '</div>';
            }
            echo '</div>';
        } ?>
        <script>
            jQuery(function() {
                registerBuildEnsemble("#ensemble_size", ".dropplaces", ".instrument-section");
            });
        </script>
    </div>
</section>