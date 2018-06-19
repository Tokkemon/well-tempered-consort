//Generic JS stuff for Well-Tempered Consort site

jQuery(function() {
    jQuery('ul.part-list').selectable({
        classes: {
            "ui-selected": "selected",
            "ui-selecting": "selecting"
        },
        stop: function(event, ui) {
            //validate each list.
            validatePartInstList(event, ui);
            //calculate the price of the selected.
            partsPriceCalc();
        }
    });
});

function validatePartInstList(event, ui) {
    console.log('the ui', event);
    var $list = jQuery(event.target);
    console.log($list);
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
    console.log('the parts selected', partsSelected);
    var quantitySelected = 0;
    jQuery.each(partsSelected, function(index, value) {
        jQuery.each(value, function(ind, val) {
            quantitySelected += val.length;
        });
    });

    // var foundErrors = checkPartsSelectedValid(partsSelected);
    // console.log('the found errors', foundErrors);

    console.log('the quantity selected', quantitySelected);
    var partPrice = 295;
    var price = quantitySelected * partPrice;
    price = price.toString();
    console.log('the price', price);

    //Add the price to the DOM
    var priceDollars = price.substr(0, price.length - 2);
    var priceCents = price.substr(price.length -2, 2);
    var priceStr = '$' + (priceDollars === '' ? '0' : priceDollars) + '.' + (priceCents.length === 1 ? '0' + priceCents : priceCents);
    jQuery("#price").html(priceStr);

    //TODO: Add stuff for volume discounts etc.


}



