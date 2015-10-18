// Check if HTTP method is safe
function csrfSafeMethod(method) {
    // these HTTP methods do not require CSRF protection
    return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
}

// Set the header of each AJAX request while protecting the CSRF token from being sent to other domains
$.ajaxSetup({    

    beforeSend: function(xhr, settings) {        
        if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
            var csrfToken = $('meta[name="authenticityCSRFToken"]').attr('content');
            xhr.setRequestHeader("X-CSRF-Token", csrfToken);
        }
    }
});

// Add / Remove Bookmark
$(function() {
    $('#bookmark').click(function() {

        var bookmarkAction = $(this).data('bookmark-action');
        var bookmarkEntite = $(this).data('bookmark-entite');
        var bookmarkEntiteId = $(this).data('bookmark-entite-id');
        var bookmarkId = $(this).data('bookmark-id');        

        $(this).prop('disabled', true);

        $.ajax({
            type: 'POST',                  
            // The commented syntax below append parameters to url even for POST requests, so it not possible to use $request->request->request() at controller level ($request->query->get() instead)
            //url: Routing.generate('fbn_guide_manage_favori', { action : action, entite : entite, entiteId : entiteId }),
            url: Routing.generate('fbn_guide_favoris_manage'),
            data : { bookmarkAction : bookmarkAction, bookmarkEntite : bookmarkEntite, bookmarkEntiteId : bookmarkEntiteId, bookmarkId : bookmarkId },
            success: function(data) {
                $('#bookmark').data('bookmark-action', data.bookmarkAction);
                $('#bookmark').data('bookmark-id', data.bookmarkId);        
                var text = $('#bookmark').data('bookmark-' + data.bookmarkAction);
                $('#bookmark').text(text);
                $('#bookmark').prop('disabled', false);               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                switch (jqXHR.status) {
                    case 401:
                        var redirectUrl = Routing.generate('fos_user_security_login');
                        window.location.replace(redirectUrl);
                        break;
                    case 403:
                        // Reload page from server
                        window.location.reload(true);
                        break;
                    default:
                        break;                     
                }           
            }
        });
    }); 
});

// Remove (only) Bookmark
$(function() {

    var bookmarkIds = $('#bookmarks').data('bookmark-ids');

    for(ii=0; ii < bookmarkIds.length; ii++) {
        //console.log(bookmarkIds[ii]);
        

        //$('#bookmark-button-11').click(function() {
        $('#bookmark-button-' + bookmarkIds[ii]).click(function(id) {

            return function() 
            {
                var bookmarkAction = $(this).data('bookmark-action');
                var bookmarkId = $(this).data('bookmark-id');        
                //alert(id);

                //$(this).prop('disabled', true);

                $.ajax({
                    type: 'POST',                  
                    // The commented syntax below append parameters to url even for POST requests, so it not possible to use $request->request->request() at controller level ($request->query->get() instead)
                    //url: Routing.generate('fbn_guide_manage_favori', { action : action, entite : entite, entiteId : entiteId }),
                    url: Routing.generate('fbn_guide_favoris_manage'),
                    data : { bookmarkAction : bookmarkAction, bookmarkId : bookmarkId },
                    success: function(data) {
                        //console.log($('.restaurants #bookmark-11').length);
                        //console.log($('.restaurants .bookmark').length);
                        // Checking removal of last element of category
                        //if (($('.restaurants #bookmark-11').length == 1) && ($('.restaurants .bookmark').length == 1)) {
                        if (($('.restaurants #bookmark-' + bookmarkIds[id]).length == 1) && ($('.restaurants .bookmark').length == 1)) {    
                            $('.restaurants').remove();
                        }                        
                        else {
                            //$('#bookmark-11').remove();
                            $('#bookmark-' + bookmarkIds[id]).remove();
                            //alert(bookmarkIds[ii]);
                        }
                        // If no bookmark anymore
                        if ($('.bookmark').length == 0) {
                            var text = $('#bookmark-message').data('bookmark-message');
                            $('#bookmark-message').text(text);                    
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        switch (jqXHR.status) {
                            case 401:
                                var redirectUrl = Routing.generate('fos_user_security_login');
                                window.location.replace(redirectUrl);
                                break;
                            case 403:
                                // Reload page from server
                                window.location.reload(true);
                                break;
                            default:
                                break;                     
                        }           
                    }
                });
            };

        }(ii));
    } 
});