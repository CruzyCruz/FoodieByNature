/**
 * Disable unfilled locations (coordinates, shop,...) and Check/Uncheck associated 'use ext tel/site' checkboxs.
 * Leave coordinates enable for new event (event creation).
 *
 * @param  {String} entities 'restaurant', 'shop', ...
 *
 * @return {Array} :input selectors like 'restaurant :input'.
 */
function initialize(entities) {    
    var disabledCoordinates = false;
    var selector = [];

    for (var ii = 0; ii < entities.length; ii++) {
        selector[ii] = '.' + entities[ii] + ' :input';
        if (entities[ii] !== 'coordinates') {
            if (!$(selector[ii]).val()) {
                $(selector[ii]).prop('disabled', true);
            } else {
                disabledCoordinates = true;
                $('.coordinates :input').prop('disabled', true);
            }
        }
    }

    if (false === disabledCoordinates) {
        changeExtCheckBoxStatus(true, false);      
    }

    return selector;      
}

/**
 * Check/Uncheck and Disable/Enable 'use ext tel/site' checkboxs.
 *
 * @param {Boolean} disabled True or False.
 * @param {Boolean} checked  True or False.
 */
function changeExtCheckBoxStatus(disabled, checked) {    
    $('.useExtTel :input').prop('disabled', disabled).prop('checked', checked);
    $('.useExtSite :input').prop('disabled', disabled).prop('checked', checked);     
}

/**
 * Disable/Enable locations and Check/Uncheck associated 'use ext tel/site' checkboxs when user click on location name.
 *
 * @param {Array} :input selectors like 'restaurant :input'.
 */
$(function() {
    var entities = ['restaurant', 'shop', 'winemakerDomain', 'eventPast', 'coordinates'];
    var selector = initialize(entities);

    for (var ii = 0; ii < entities.length; ii++) {    
        var labelEntities = $('.' + entities[ii]).find('label').first();

        // Closure
        $(labelEntities).on('click', (function(index) {

            return function() {
                if ($(selector[index]).is(':disabled')) {
                    $(selector[index]).prop('disabled', false);
                    if (entities[index] === 'coordinates') {
                        changeExtCheckBoxStatus(true, false);
                    } else {
                        changeExtCheckBoxStatus(false,false);
                    }                    
                    for (var jj=0; jj < entities.length; jj++) {
                        if (jj !== index) {
                            if (entities[jj] !== 'coordinates') {
                                $(selector[jj]).prop('disabled', true).val('').trigger('change');                                
                            } else {
                                $(selector[jj]).prop('disabled', true);                                                        
                            }
                        }
                    }
                }               
            };

        })(ii));  
    }

    // Enable all disabled element on form submission
    $(document).on('submit', "#edit-event-form", function(event){
        $("#edit-event-form :disabled").prop('disabled', false);
    });     

});

