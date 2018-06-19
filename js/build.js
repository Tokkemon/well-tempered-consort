// All the functions for building the ensemble

function registerBuildEnsemble(sizeSelector, dropSelector, instrumentSelector) {
    var $droppable = jQuery(dropSelector);
    var $dropPlaces = $droppable.find('div.dropplace');
    //Register the draggable instruments
    var $instruments = jQuery(instrumentSelector).find("div.instrument");

    var $sizeSelector = jQuery(sizeSelector);
    $instruments.each(function(index, value) {
        var $instrument = jQuery(value);
        //Click on each instrument
        $instrument.unbind("click");
        $instrument.click(function(e) {
            //Calculate where to send it.
            var size = $sizeSelector.val();
            var lclPartsData = {};
            jQuery.each(partsData, function(index, value) {
                if(Object.keys(value.parts).length == size) {
                    lclPartsData = value.parts;
                    return false;
                }
            });
            console.log('the parts data', partsData);
            console.log('the size', size);
            console.log('the local parts data', lclPartsData);
            //Fill in the first available part for this bucket. However if the bucket is already valid, try the next one.
            //Check which parts are valid, i.e. which are "filled" already.
            var partValid = {};
            $droppable.find('div.dropplace').slice(0, size).each(function(index, value) {
                partValid[index + 1] = (!!jQuery(value).hasClass('part-valid'));
            });

            //Filter out which parts are valid for *this* instrument.
            var instId = $instrument.attr('data-instrument');
            var instValid = {};
            jQuery.each(lclPartsData, function(partIndex, parts) {
                var found = parts.indexOf(instId);
                instValid[partIndex] = found !== -1;
            });
            console.log('valid parts', partValid);
            console.log('valid inst', instValid);
            //Merge these validities. Only parts that are instValid will even be considered.
            jQuery.each(instValid, function(partInstIndex, partInstValid) {
                if(partInstValid === false) {
                    delete partValid[partInstIndex];
                }
            });
            console.log('valid parts', partValid);
            //Search through the individual parts and check if any are invalid. If so, place the instrument there.
            var finalRestingPlace = null;
            jQuery.each(partValid, function(partIndex, lclPartValid) {
                //Find the first one that is not valid.
                if(lclPartValid === false) {
                    //stick the instrument here!
                    finalRestingPlace = partIndex - 1;
                    return false;
                }
            });
            //If all parts are valid, take the one with *fewer* of the given instrument.
            var partCounts = {};
            if(finalRestingPlace === null) {
                $dropPlaces.each(function(dropPlaceIndex, dropPlace) {
                    var foundInst = jQuery(dropPlace).find('div.instrument').filter('[data-instrument="' + instId + '"]');
                    if(foundInst.length > 0) {
                        partCounts[dropPlaceIndex] = foundInst.length;
                    }
                });
                console.log('the parts counts', partCounts);
                finalRestingPlace = Math.min.apply(Math, Object.keys(partValid));  //default to the first valid one
                jQuery.each(partCounts, function(partIndex, partCount) {
                    finalRestingPlace = (partCount < partCounts[finalRestingPlace] ? partIndex : finalRestingPlace);
                });
            }
            console.log('the final resting place', finalRestingPlace);

            var $foundDropPlace = $dropPlaces[finalRestingPlace];
            var $cloneInstrument = $instrument.clone();
            $cloneInstrument.removeClass('col-md-1');
            jQuery(this).after($cloneInstrument);
            //Position the new thing
            $cloneInstrument.position({
                my: "left top",
                at: "left top",
                of: $foundDropPlace,
                using: function(css, calc) {
                    jQuery(this).animate(css, 500, "swing", function() {
                        console.log('the clone inst', $cloneInstrument);
                        $cloneInstrument.appendTo($foundDropPlace);
                    });
                }
            });
            //Set the box to be valid by placing a new class.
            jQuery($foundDropPlace).addClass('part-valid');
        });

        /*$box.draggable({
            revert: "invalid",
            helper: "clone"
        });*/
    });

    //Register the droppable action
    $dropPlaces.each(function(index, value) {
        var $box = jQuery(value);
       /* $box.droppable({
            activeClass: "ui-state-default",
            hoverClass: "ui-state-hover",
            disabled: true,
            //TODO: this isn't working
            drop: function(event, ui) {
                console.log('ui', ui);
                var newClone = jQuery(ui.helper).clone();
                // newClone.removeClass('col-md-1');
                jQuery(this).after(newClone);
            }
        });*/
    });
    //Enable the first four items, as the quartet is default.





    //Register the size selector.
    //TODO: When changed value, remove all instrument blocks.
    $sizeSelector.change(function() {
        var size = $sizeSelector.val();
        $droppable.find('div.dropplace').each(function(index, value) {
            var $box = jQuery(value);
            if(index + 1 > size) {
                $box.hide("slide", { direction: "left" }, 500);
            }
            else {
                $box.show("slide", { direction: "left" }, 500);
            }
        });
        //Make the boxes fit.
    });
}