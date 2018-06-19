/**
 * Global JS file where generic functions for JS can be placed for access to anywhere in the site
 */

function registerPartCountFilter() {
    jQuery('#part_count_filter').find('input[type="checkbox"]').each(function(index, element) {
        var $checkbox = jQuery(element);
        $checkbox.change(function() {
            var checkboxValue = $checkbox.val();
            console.log('this box was checked!', $checkbox.attr('id'));
            if($checkbox.is(':checked')) {
                //then show all the rows that are of this value;
                jQuery.each([jQuery("#book_1"), jQuery('#book_2')], function(index, table) {
                    var $table = jQuery(table);
                    $table.find('td.parts').each(function(cellIndex, cell) {
                        var $cell = jQuery(cell);
                        var rowPartCount = $cell.attr('data-part-count');
                        if(checkboxValue == rowPartCount) {
                            $cell.parents('tr').show();
                        }
                    });
                });
            }
            else {
                //then show all the rows that are of this value;
                jQuery.each([jQuery("#book_1"), jQuery('#book_2')], function(index, table) {
                    var $table = jQuery(table);
                    $table.find('td.parts').each(function(cellIndex, cell) {
                        var $cell = jQuery(cell);
                        var rowPartCount = $cell.attr('data-part-count');
                        if(checkboxValue == rowPartCount) {
                            $cell.parents('tr').hide();
                        }
                    });
                });
            }
        });
    });

}

function choosePartsRegister() {
    var $table = jQuery('#choose_instrument');
    //Do an initial onChange deal in case of pre-filled values;
    choosePartsOnChange($table);
    //Register all the box "on change" events.
    $table.find('input[type="checkbox"]').each(function(index, box) {
        var $box = jQuery(box);
        $box.change(function() {
            choosePartsOnChange($table);
        });
    });
}

function choosePartsOnChange($table) {
    var matrix = choosePartsGetMatrix($table);
    console.log('matrix', matrix);
    //Check each part if *something* is checked. If not, throw a false.
    var selected = matrix.allPartsSelected();
    console.log('allPartsSelected', selected);
    //If all the parts have a selection, enable the button.
    if(selected === true) {
        jQuery('input[type="submit"]').prop("disabled", false);
    }
    else {
        jQuery('input[type="submit"]').prop("disabled", true);
    }
}

function choosePartsGetMatrix($table) {
    //Define a js class here for the list
    function Matrix () {}
    Matrix.prototype.allPartsSelected = function() {
        var check = 0;
        jQuery.each(this, function(index, value) {
            if(typeof value !== "function") {
                if(value.isSelected() === true) {
                    check++;
                }
            }
        });
        return (check === Object.keys(this).length);
    };
    function List () {}
    List.prototype.isSelected = function() {
        var check = false;
        jQuery.each(this, function(index, value) {
            if(value === true) {
                //Any time a true is found, the whole function returns true;
                check = true;
                return false;
            }
        });
        return check;
    };
    var matrix = new Matrix();
    //Loop through and find all the cells.
    $table.find('tbody tr td').each(function(cellIndex, cell) {
        var $cell = jQuery(cell);
        matrix[cellIndex + 1] = new List();
        $cell.find('input[type="checkbox"]').each(function(boxIndex, box) {
            var $box = jQuery(box);
            var boxVal = false;
            if($box.is(':checked')) {
                boxVal = true;
            }
            var instName = $box.val();
            matrix[cellIndex + 1][instName] = boxVal;
        });
    });
    return matrix;
}