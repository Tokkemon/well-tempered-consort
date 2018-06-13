//Generic JS stuff for Well-Tempered Consort site

jQuery(function() {
    jQuery('ul.part-list').selectable({
        classes: {
            "ui-selected": "selected",
            "ui-selecting": "selecting"
        },
        stop: validatePartInstList
    });
});

function validatePartInstList(event, ui) {
    //
    console.log('the ui', event);
    var $validation = $list.prev('h6').find('span.validation');
    //Check if it's valid
    var validFlag = false;
    $list.find('li.instrument').each(function(index, value) {
        if(jQuery(value).hasClass("selected")) {
            validFlag = true;
        }
    });
    if(validFlag === true) {
        $validation.addClass('valid');
    }
    else {
        $validation.removeClass('valid');
    }
}

function getPartsSelected() {
    var partsSelected = {};
    //For each "piece", i.e. the prelude and fugue.
    jQuery('ul.part-list').parent('div').each(function(pieceIndex, pieceValue) {
        var $pieceValue = jQuery(pieceValue);
        if(typeof partsSelected[pieceIndex] === "undefined") {
            partsSelected[pieceIndex] = {};
        }
        //Find each respective part list
        $pieceValue.find('ul.part-list').each(function(listIndex, listValue) {
            var $listValue = jQuery(listValue);
            if(typeof partsSelected[pieceIndex][listIndex] === "undefined") {
                partsSelected[pieceIndex][listIndex] = [];
            }
            $listValue.find('li').each(function(index, value) {
                var $listItem = jQuery(value);
                var partNum = $listItem.parents('ul').attr('data-part');
                if($listItem.hasClass('selected')) {
                    partsSelected[pieceIndex][listIndex].push($listItem.text());
                }
            });
        });
    });
    return partsSelected;
}

function checkPartsSelectedValid(partsSelected) {
    var foundErrors = [];
    //Cycle through the selected and if there's any missing, return no.
    jQuery.each(partsSelected, function(pieceIndex, pieceValue) {
        jQuery.each(pieceValue, function(partIndex, partValue) {
            if(partValue.length === 0) {
                foundErrors.push(pieceIndex + ':' + partIndex);
            }
        });
    });
    if(jQuery.isEmptyObject(foundErrors)) {
        return true;
    }
    return foundErrors;
}

//Function to calculate the prices required based on the selected parts
function partsPriceCalc() {
    var partsSelected = getPartsSelected();
    var foundErrors = checkPartsSelectedValid(partsSelected);
    console.log('the found errors', foundErrors);

    //Do stuff with the errors that are found


    //There should be at least one from every part.

    //Do some math here.

}



