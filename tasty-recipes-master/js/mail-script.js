// -------   Mail Send AJAX
$(document).ready(function() {
    var form = $('#myForm'); // Contact form
    var submit = $('.submit-btn'); // Submit button
    var alert = $('.alert-msg'); // Alert div for showing alert messages

    // Form submit event
    form.on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            url: 'mail.php', // Form action URL
            type: 'POST', // Form submit method (GET/POST)
            dataType: 'html', // Request type (HTML/JSON/XML)
            data: form.serialize(), // Serialize form data
            beforeSend: function() {
                alert.fadeOut();
                submit.prop('disabled', true).html('Sending....'); // Change submit button text
            },
            success: function(data) {
                alert.html(data).fadeIn(); // Fade in response data
                form.trigger('reset'); // Reset form fields
                submit.prop('disabled', false).html('Submit'); // Reset submit button
            },
            error: function(e) {
                alert.html('An error occurred. Please try again.').fadeIn(); // Show error message
                submit.prop('disabled', false).html('Submit'); // Re-enable submit button
                console.error(e); // Log the error
            }
        });
    });
});
