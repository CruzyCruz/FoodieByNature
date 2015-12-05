// Remove (only) Bookmark
$(function() {

    var bookmarkIds = $('#bookmarks').data('bookmark-ids');

    for(ii=0; ii < bookmarkIds.length; ii++) {

        $('#bookmark-button-' + bookmarkIds[ii]).click(function(id) {  

            // Closure
            return function() 
            {
                var bookmarkAction = $(this).data('bookmark-action');
                var bookmarkId = $(this).data('bookmark-id');                                      

                $('[id*="bookmark-button-"]').prop('disabled', true);

                $.ajax({
                    type: 'POST',                                     
                    url: Routing.generate('fbn_guide_bookmarks_manage'),
                    data : { bookmarkAction : bookmarkAction, bookmarkId : bookmarkId },
                    success: function(data) {
                        // Checking removal of last element in category                        
                        if ($('.restaurants .bookmark').length == 1) {                                
                            $('.restaurants').remove();
                        }                                                
                        else if ($('.winemakers .bookmark').length == 1) {                              
                            $('.winemakers').remove();
                        }                        
                        else if ($('.cavistes .bookmark').length == 1) {                            
                            $('.cavistes').remove();
                        }  
                        else {
                            $('#bookmark-' + data.bookmarkId).remove();
                        }

                        // If no bookmark anymore
                        if ($('.bookmark').length === 0) {
                            var text = $('#bookmark-message').data('bookmark-message');
                            $('#bookmark-message').text(text);                    
                        }
                        else
                        {
                            $('[id*="bookmark-button-"]').prop('disabled', false);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        manageErrorCode(jqXHR.status);
                    }                    
                });
            };

        }(ii));
    } 
});