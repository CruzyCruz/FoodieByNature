// Add / Remove bookmark
$(function() {
    $('#bookmark').click(function() {

        var bookmarkAction = $(this).data('bookmark-action');
        var bookmarkEntity = $(this).data('bookmark-entity');
        var bookmarkEntityId = $(this).data('bookmark-entity-id');
        var bookmarkId = $(this).data('bookmark-id');        

        $(this).prop('disabled', true);

        $.ajax({
            type: 'POST',                  
            // The commented syntax below append parameters to url even for POST requests, so it not possible to use $request->request->request() at controller level ($request->query->get() instead)
            //url: Routing.generate('fbn_guide_manage_bookmark', { action : action, entity : entity, entityId : entityId }),
            url: Routing.generate('fbn_guide_bookmarks_manage'),
            data : { bookmarkAction : bookmarkAction, bookmarkEntity : bookmarkEntity, bookmarkEntityId : bookmarkEntityId, bookmarkId : bookmarkId },
            success: function(data) {
                $('#bookmark').data('bookmark-action', data.bookmarkAction);
                $('#bookmark').data('bookmark-id', data.bookmarkId);        
                var text = $('#bookmark').data('bookmark-' + data.bookmarkAction);
                $('#bookmark').text(text);
                $('#bookmark').prop('disabled', false);               
            },
            error: function(jqXHR, textStatus, errorThrown) {
                manageErrorCode(jqXHR.status);
            } 
        });
    }); 
});