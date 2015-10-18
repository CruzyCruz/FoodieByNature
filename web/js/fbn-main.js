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

// Manage error code
function manageErrorCode(status) {
    switch (status) {
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