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

// Manage HTTP error code
function manageErrorCode(status) {
    var redirectUrl;
    switch (status) {
        case 401:
            redirectUrl = Routing.generate('fos_user_security_login');
            window.location.replace(redirectUrl);
            break;
        case 403:
            redirectUrl = Routing.generate('fbn_guide_display_error_pages', { statusCode : status });
            window.location.replace(redirectUrl);
            break;
        case 404:
            redirectUrl = Routing.generate('fbn_guide_display_error_pages', { statusCode : status });
            window.location.replace(redirectUrl);
            break;            
        default:
            break;                     
    }
}