// Remove (only) bookmark
$(function() {

    var bookmarkAction = 'remove_only';
    var bookmarkIds = $('#bookmarks').data('bookmark-ids');

    for(var ii=0; ii < bookmarkIds.length; ii++) {

        // Closure : for each button, bookmarkIds table index is captured in closure
        $('#bookmark-' + bookmarkIds[ii] + ' button').click((function(index) {
            
            return function() 
            {                                     
                var bookmarkId = bookmarkIds[index];                                      

                $('button').prop('disabled', true);

                $.ajax({
                    type: 'POST',                                     
                    url: Routing.generate('fbn_guide_bookmarks_manage'),
                    data : { bookmarkAction : bookmarkAction, bookmarkId : bookmarkId },
                    success: function(data) {
                        $('#bookmark-' + data.bookmarkId).remove();
                        
                        // Checking removal of last element in category                        
                        if ($('.restaurants .bookmark').length === 0) {                                
                            $('.restaurants').remove();
                        } 

                        if ($('.winemakers .bookmark').length === 0) {                              
                            $('.winemakers').remove();
                        }  

                        if ($('.shops .bookmark').length === 0) {                            
                            $('.shops').remove();
                        }

                        // If no bookmark anymore
                        if ($('.bookmark').length === 0) {
                            var text = $('#bookmark-message').data('bookmark-message');
                            $('#bookmark-message').text(text);                    
                        }

                        $('button').prop('disabled', false);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        manageErrorCode(jqXHR.status);
                    }                    
                });
            };

        })(ii));
    } 
});