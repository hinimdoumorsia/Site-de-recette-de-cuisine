$(function() {

    // Get the form.
    var form = $('#contact-form');

    // Get the messages div.
    var formMessages = $('.ajax-response');

    // Set up an event listener for the contact form.
    $(form).submit(function(e) {
        // Stop the browser from submitting the form.
        e.preventDefault();

        // Validate the form fields.
        var isValid = true;
        $('#contact-form input, #contact-form textarea').each(function() {
            if ($(this).val().trim() === '') {
                isValid = false;
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });

        if (!isValid) {
            $(formMessages).removeClass('success').addClass('error').text('Please fill in all required fields.');
            return;
        }

        // Serialize the form data.
        var formData = $(form).serialize();

        // Show loading indicator.
        $(formMessages).text('Sending your message...').addClass('loading');

        // Submit the form using AJAX.
        $.ajax({
            type: 'POST',
            url: $(form).attr('action'),
            data: formData
        })
        .done(function(response) {
            // Remove loading state.
            $(formMessages).removeClass('loading');

            // Make sure that the formMessages div has the 'success' class.
            $(formMessages).removeClass('error').addClass('success');

            // Set the message text.
            $(formMessages).text(response);

            // Clear the form.
            $('#contact-form input,#contact-form textarea').val('');
        })
        .fail(function(data) {
            // Remove loading state.
            $(formMessages).removeClass('loading');

            // Make sure that the formMessages div has the 'error' class.
            $(formMessages).removeClass('success').addClass('error');

            // Set the message text.
            if (data.responseText !== '') {
                $(formMessages).text(data.responseText);
            } else {
                $(formMessages).text('Oops! An error occurred and your message could not be sent.');
            }
        });
    });

});
