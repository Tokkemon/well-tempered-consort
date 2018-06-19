/**
 * JS materials for the Build Ensemble view
 */

jQuery(function() {
    var $select = jQuery('#add_instrument_select');
    var $list = jQuery('#instrument_list');
    jQuery("#add_instrument").click(function() {
        var $selected = $select.find("option:selected");
        var instrument = $selected.val();
        $list.append('<li>' + instrument + '</li>');

    });
    jQuery("#reset_list").click(function() {
        $list.find('li').remove();
    });
    jQuery('#common_ensembles').change(function() {
        //Clear the list first
        $list.find('li').remove();
        //Get the ensemble and add them to the list.
        var ensemble = jQuery(this).val();
        ensemble = ensembles.filter(function(obj) {
            return obj.name == ensemble;
        })[0];
        jQuery.each(ensemble.instruments, function(index, value) {
            $list.append('<li>' + value + '</li>');
        });
        //Animate the instruments to flow into the correct boxes.
        //see this fiddle for animation: http://jsfiddle.net/h7tuehmo/3/
        //https://stackoverflow.com/questions/26650877/move-an-element-from-one-div-to-another-div-with-animate-effect-on-button-click

    });
    //Bucket turn on and off
    jQuery("#part_count").change(function() {
        var partCount = jQuery(this).val();
        for(var i = 5; i > 0; i--) {
            var $bucket = jQuery("#bucket_" + i);
            if(i <= partCount) {
                $bucket.removeClass('part_bucket_disabled');
                continue;
            }
            $bucket.addClass('part_bucket_disabled');
        }
    });
});