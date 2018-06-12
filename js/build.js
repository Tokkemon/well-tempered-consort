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
            var $foundDropPlace = $dropPlaces[0];
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
        })*/;
    });
    //Enable the first four items, as the quartet is default.





    //Register the size selector.
    $sizeSelector.change(function() {
        var size = $sizeSelector.val();
        $droppable.find('div.dropplace').each(function(index, value) {
            var $box = jQuery(value);
            if(index + 1 > size) {
                $box.addClass('faded');
                // $box.droppable("disable");
            }
            else {
                $box.removeClass('faded');
                // $box.droppable("enable");
            }
        });
    });
}