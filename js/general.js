//Generic JS stuff for Well-Tempered Consort site

jQuery(function() {
    jQuery('ul.part-list').find('li').each(function(index, value) {
        let $listItem = jQuery(value);
        $listItem.click(function(e) {
            if($listItem.hasClass('selected')) {
                $listItem.removeClass('selected');
            }
            else {
                $listItem.addClass('selected');
            }
            partsPriceCalc();
        });
    });
});


function getPartsSelected() {
    var partsSelected = {};
    //For each "piece", i.e. the prelude and fugue.
    jQuery('ul.part-list').parent('div').each(function(pieceIndex, pieceValue) {
        let $pieceValue = jQuery(pieceValue);
        if(typeof partsSelected[pieceIndex] === "undefined") {
            partsSelected[pieceIndex] = {};
        }
        //Find each respective part list
        $pieceValue.find('ul.part-list').each(function(listIndex, listValue) {
            let $listValue = jQuery(listValue);
            if(typeof partsSelected[pieceIndex][listIndex] === "undefined") {
                partsSelected[pieceIndex][listIndex] = [];
            }
            $listValue.find('li').each(function(index, value) {
                let $listItem = jQuery(value);
                let partNum = $listItem.parents('ul').attr('data-part');
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
    //Do stuff with the errors that are found


    //There should be at least one from every part.

    //Do some math here.

}